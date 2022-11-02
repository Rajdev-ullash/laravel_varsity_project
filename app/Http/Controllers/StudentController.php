<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;
use App\Models\Enroll;
use App\Models\Marksystem;
use App\Models\Assignmark;
use App\Models\AssignCourseTeacher;
use Illuminate\Support\Facades\DB;


class StudentController extends Controller
{
    public function home(){
        return view('student.pages.home');
    }

    public function sessionList(){
        return view('student.pages.sessionList');
    }

    public function sessionListView(){
        $data = Session::all();
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

    public function courseList($id){
        $data = session()->get('userid');
        return view('student.pages.courseList',['session_id' => $id, 'student_id' => $data]);
    }

    public function courseListView($id){
       

        $data = DB::table('sections')
                    ->where('sections.session_name','=',$id)
                    ->join('courses','sections.course_code','=','courses.id')
                    ->select('sections.*','courses.course_code as course_code','courses.course_title as course_title','courses.course_credit as course_credit','courses.course_semester as course_semester',)
                    ->orderBy('courses.course_semester', 'asc')
                    ->orderBy('courses.course_credit', 'asc')
                    ->orderBy('section_name', 'asc')
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

    public function sectionListView(){
         $data = DB::table('sections')
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

    public function enrollCourse(Request $request){
        $student_id = $request->session()->get('userid');
        $section = $request->section_name;
        
        if(count($section) > 0){
            foreach($section as $sec){
                $data = new Enroll();
                $data->student_id = $student_id;
                $data->section_name = $sec;
                $data->save();
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Enrollment created successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Enrollment creation failed'
            ]);
        }
        
        
    }

    public function enrollCourseList(){
        return view('student.pages.enrollCourseList');
    }

    public function enrollCourseListView(){
        $student_id = session()->get('userid');
        $data = DB::table('enrolls')
                    ->where('enrolls.student_id','=',$student_id)
                    ->join('sections','enrolls.section_name','=','sections.id')
                    ->join('courses','sections.course_code','=','courses.id')
                    ->select('enrolls.*','sections.*','courses.course_code as course_code','courses.course_title as course_title','courses.course_credit as course_credit','courses.course_semester as course_semester', 'sections.id as section_id')
                    ->orderBy('courses.course_semester', 'asc')
                    ->orderBy('courses.course_credit', 'asc')
                    ->orderBy('sections.section_name', 'asc')
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

    public function enrollCourseDelete($id){
        $data = Enroll::where('id','=',$id)
                        ->delete();
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Enroll Course Deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
    }

    public function markSystem(){
        return view('student.pages.markSystem');
    }

    public function specificStudentAssignMarksView(Request $request){
        $student_id = $request->session()->get('userid');
        $data = DB::table('assignmarks')
                    ->where('assignmarks.student_id','=',$student_id)
                    ->join('sections','assignmarks.section_name','=','sections.id')
                    ->join('courses','sections.course_code','=','courses.id')
                    ->join('users','assignmarks.student_id','=','users.id')
                    ->select('assignmarks.*','sections.*','courses.course_code as course_code','courses.course_title as course_title','courses.course_credit as course_credit','courses.course_semester as course_semester','users.id as user_id','users.name as user_name','users.email as user_email','users.uid as user_uid',)
                    ->orderBy('courses.course_semester', 'asc')
                    ->orderBy('courses.course_credit', 'asc')
                    ->orderBy('sections.section_name', 'asc')
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



}
