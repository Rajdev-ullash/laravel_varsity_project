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
