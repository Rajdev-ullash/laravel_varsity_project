<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;
use App\Models\Enroll;
use App\Models\AssignCourseTeacher;
use App\Models\Marksystem;
use App\Models\Assignmark;
use App\Models\Coursemark;
use App\Models\Assigncoursemark;
use App\Models\Teachergivenmarks;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function home(){
        return view('teacher.pages.home');
    }

    public function assignCourseList(){
        return view('teacher.pages.assignCourseList');
    }

    public function assignCourseListView(Request $request){
        $teacher_id = $request->session()->get('userid');
        $data = DB::table('assign_course_teachers')
                    ->where('assign_course_teachers.teacher_id','=',$teacher_id)
                    ->join('courses','assign_course_teachers.course_code','=','courses.id')
                    ->join('sections','assign_course_teachers.section_name','=','sections.id')
                    ->select('assign_course_teachers.*','courses.course_code as course_code','courses.course_title as course_title','courses.course_credit as course_credit','courses.course_semester as course_semester','sections.section_name as section_name','sections.id as section_id')
                    ->orderBy('courses.course_semester', 'asc')
                    ->orderBy('courses.course_credit', 'asc')
                    ->orderBy('sections.section_name', 'asc')
                    ->get();
        if($data){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
                   

    }

    public function enrollStudentList($id){
        return view('teacher.pages.enrollStudentList', ['section_id' => $id]);
    }

    public function getEnrollStudentList($id){
        $data = DB::table('enrolls')
                    ->where('enrolls.section_name','=',$id)
                    ->join('sections','enrolls.section_name','=','sections.id')
                    ->join('users','enrolls.student_id','=','users.id')
                    ->select('enrolls.*','sections.*','users.id as user_id','users.name as user_name','users.email as user_email','users.uid as user_uid',)
                    ->orderBy('users.uid', 'asc')
                    ->get();
        if($data->count() > 0){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }

    public function storeTeacherMarkSystem(Request $request){
        $teacher_id = $request->session()->get('userid');
        $obj = new Marksystem();
        $obj->section_name = $request->section_name;
        $obj->teacher_id = $teacher_id;
        if($obj->save()){
            return response()->json([
                'status' => 'success',
                'message' => 'Marks Store successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Marks Store failed'
            ]);
        }
    }

    public function courseMarksStoreAction(Request $request){
        $teacher_id = $request->session()->get('userid');
        //multiple insert
        $marks_title = $request->marks_title;
        $marks = $request->marks_number;
        foreach($marks_title as $key => $value){
            $obj = new Coursemark();
            $obj->marks_title = $value;
            $obj->marks = intval($marks[$key]);
            $obj->teacher_id = $teacher_id;
            $obj->section_name = $request->section_id;
            $obj->save();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Marks Store successfully'
        ]);

        
    }
    
    public function specificCourseMarksStoreView($id){
        return view('teacher.pages.assignCourseMarksList', ['section_id' => $id]);
    }

    public function courseSpecificMarkSystem($id){
        $data = Coursemark::where('section_name','=',$id)->get();
        if($data && $data->count() > 0){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }

    //update a multiple specfice coursemark with a single request
    public function updateCourseSpecificMarkSystem(Request $request, $id){
        
        //update multiple with id and value
        $marks_title = $request->marks_title;
        $marks = $request->marks_number;
        $marks_id = $request->marks_id;
        foreach($marks_title as $key => $value){
            $obj = Coursemark::find($marks_id[$key]);
            $obj->marks_title = $value;
            $obj->marks = intval($marks[$key]);
            $obj->save();
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Marks Update successfully'
        ]);
        
    }

    //delete a multiple specfice coursemark with a single request
    public function deleteCourseSpecificMarkSystem(Request $request, $id){
        
        //delete specific section course marks
        $data = Coursemark::where('section_name','=',$id)->delete();
        
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Marks Delete successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Marks Delete failed'
            ]);
        }
        
    }

    //store multiple student marks with a single request
    public function storeStudentCourseMarks(Request $request){
        $teacher_id = $request->session()->get('userid');
        //multiple student marks with dynamic marks title and marks
        $student_id = $request->student_id;
        $marks_title = $request->marks_title;
        $assign_marks = $request->assign_marks;
        $given_marks = $request->given_marks;
        $total = $request->total;
        $done = $request->done;
        $section_name = $request->section_name;

            
            // foreach($marks_title as $key2 => $value2){
            //     $obj = new Assigncoursemark();
            //     $obj->marks_title = $value2;
            //     $obj->assign_marks = intval($assign_marks[$key2]);
            //     $obj->given_marks = intval($given_marks[$key2]);
            //     $obj->total = intval($total);
            //     $obj->done = intval($done);
            //     $obj->teacher_id = $teacher_id;
            //     $obj->section_name = $request->section_name;
            //     //multiple students have same marks title students single request
            //     //set every student id with every marks title
            //     foreach($student_id as $key => $value){
            //         $obj->student_id = $value;                   
            //         $obj->save();
            //     }

            //     foreach($student_id as $key => $value){
            //         //now we need to store multiple student marks with same marks title
            //         $obj->student_id = $value[$key2];
                    

            //     }
            // }
            //student
            foreach($student_id as $key => $value){
                //marks title and assign_marks and given_marks and total and done and section_name and teacher_id for each student
                foreach($marks_title as $key2 => $value2){
                    $obj = new Assigncoursemark();
                    $obj->marks_title = $value2;
                    $obj->assign_marks = intval($assign_marks[$key2]);
                    $obj->given_marks = intval($given_marks[$key2]);
                    $obj->total = intval($total);
                    $obj->done = intval($done);
                    $obj->teacher_id = $teacher_id;
                    $obj->section_name = $request->section_name;
                    $obj->student_id = $value;
                    $obj->save();
                }

                
            }
            if ($obj->save()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Marks Store successfully'
                    ]);
                }
                else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Marks Store failed'
                    ]);
                }
        
            
        
        
           

        
    }

    public function jsonStudentCourseMarks(Request $request){
        $teacher_id = $request->session()->get('userid');
        //multiple student marks with dynamic marks title and marks
        $student_id = $request->student_id;
        $marks_title = $request->marks_title;
        $assign_marks = $request->assign_marks;
        $given_marks = $request->given_marks;
        $total = $request->total;
        $done = $request->done;
        $section_name = $request->section_name;

            
            foreach($student_id as $key => $value){
                //marks title and assigned marks and given marks store json data
                
                    $obj = new Teachergivenmarks();
                    //array to json
                    $obj->marks_title = json_encode($marks_title);
                    $obj->assign_marks = json_encode($assign_marks);
                    $obj->given_marks = json_encode($given_marks);
                    $obj->total = intval($total);
                    $obj->done = intval($done);
                    $obj->teacher_id = $teacher_id;
                    $obj->section_name = $request->section_name;
                    $obj->student_id = $value;
                    $obj->save();
                

                
            }
            if ($obj->save()) {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Marks Store successfully'
                    ]);
                }
                else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Marks Store failed'
                    ]);
                }
        
            
        
        
           

        
    }

    // get a specific  json student marks
    public function getSpecificJsonStudentCourseMarks(Request $request, $id){
        $teacher_id = $request->session()->get('userid');
        $obj = Teachergivenmarks::where('student_id', $id)->where('teacher_id', $teacher_id)->first();
        if ($obj) {
            return response()->json([
                'status' => 'success',
                'message' => 'Marks found',
                'data' => $obj
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }

    //update a specific json student marks
    public function updateSpecificJsonStudentCourseMarks(Request $request, $id){
        $teacher_id = $request->session()->get('userid');
        $section_name = $request->section_name;
        $data = Teachergivenmarks::where('student_id', $id)->where('teacher_id', $teacher_id)->where('section_name', $section_name)
                    ->update([
                        'marks_title' => json_encode($request->marks_title),
                        'assign_marks' => json_encode($request->assign_marks),
                        'given_marks' => json_encode($request->given_marks),
                        'total' => intval($request->total),
                    ]);

        if ($data) {
            return response()->json([
                'status' => 'success',
                'message' => 'Marks updated successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Marks update failed'
            ]);
        }
    }


    //student course marks list views
    public function studentCourseMarksList($id){
        return view('teacher.pages.studentCourseMarksList', ['section_id' => $id]);
    }

    //get all student marks & group by with student id with a single request
    public function getStudentCourseMarks($id){
        $data = DB::table('Teachergivenmarks')
                   //marks_title, assign_marks, given_marks return as json data
                      ->where('Teachergivenmarks.section_name','=',$id)
                    ->join('sections','Teachergivenmarks.section_name','=','sections.id')
                    ->join('users','Teachergivenmarks.student_id','=','users.id')
                    ->select('Teachergivenmarks.*','sections.*','users.id as user_id','users.name as user_name','users.email as user_email','users.uid as user_uid',)
                    //show all students marks with all marks title and marks_title like assign_marks and given_marks
                    // ->groupBy('assigncoursemarks.student_id')
                    // ->get();
                   

                    // ->groupBy('assigncoursemarks.marks_title')
                    //assign_marks and given_marks 
                    

                    ->orderBy('users.uid', 'asc')
                    ->get();
        if($data->count() > 0){
            return response()->json([
                'status' => 'success',
                'data' => $data,
                
                
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }



    public function specificMarkSystem($id){
        $data = Marksystem::where('section_name','=',$id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }

    public function updateSpecificMarkSystem(Request $request,$id){
        $data = Marksystem::where('section_name','=',$id)
                        ->update([
                            'attendance' => intval($request->attendance),
                            'class_test' => intval($request->class_test),
                            'assignment_marks' => intval($request->assignment_marks),
                            'midterm' => intval($request->midterm),
                            'final' => intval($request->final),
                        ]);
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Marks updated successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }

    public function storeAssignMarks(Request $request){
        $teacher_id = $request->session()->get('userid');
        $student_id = $request->student_id;
        if(count($student_id) > 0){
            foreach($student_id as $student_id){
                $obj = new Assignmark();
                $obj->section_name = $request->section_name;
                $obj->teacher_id = $teacher_id;
                $obj->student_id = $student_id;
                $obj->attendance = intval($request->attendance);
                $obj->class_test = intval($request->class_test);
                $obj->assignment_marks = intval($request->assignment_marks);
                $obj->midterm = intval($request->midterm);
                $obj->final = intval($request->final);
                $obj->total = intval($request->total);
                $obj->done = intval($request->done);
                $obj->save();
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Assign Marks created successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Assign Marks creation failed'
            ]);
        }
        

    }

    public function storeAssignMarksList($id){
        return view('teacher.pages.storeAssignMarksList',['section_name' => $id]);
    }

    public function storeAssignMarksView($id){
        $data = DB::table('assignmarks')
                    ->where('assignmarks.section_name','=',$id)
                    ->join('sections','assignmarks.section_name','=','sections.id')
                    ->join('users','assignmarks.student_id','=','users.id')
                    ->select('assignmarks.*','sections.*','users.id as user_id','users.name as user_name','users.email as user_email','users.uid as user_uid',)
                    ->orderBy('users.uid', 'asc')
                    ->get();
        if($data->count() > 0){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }

    public function editStoreAssignMarks($id){
        $data = Assignmark::where('student_id','=',$id)->first();
        if($data){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }

    public function updateStoreAssignMarks(Request $request,$id){
        $data = Assignmark::where('student_id','=',$id)
                        ->update([
                            'attendance' => intval($request->attendance),
                            'class_test' => intval($request->class_test),
                            'assignment_marks' => intval($request->assignment_marks),
                            'midterm' => intval($request->midterm),
                            'final' => intval($request->final),
                            'total' => intval($request->total),
                        ]);
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Assign Marks updated successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }

    public function deleteStoreAssignMarks($id){
        $data = Assignmark::where('student_id','=',$id)->delete();
        if($data){
            return response()->json([
                'status' => 'success',
                'message' => 'Assign Marks deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }
}
