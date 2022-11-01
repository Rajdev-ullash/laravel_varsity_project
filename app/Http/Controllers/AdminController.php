<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;
use App\Models\AssignCourseTeacher;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    public function home(){
        return view('admin.pages.home');
    }

    //dashboard count
    public function dashboardCount(){
        $studentReqCount = User::where('role','student')->where('active',0)->count();
        $teacherReqCount = User::where('role','teacher')->where('active',0)->count();
        $studentActiveCount = User::where('role','student')->where('active',1)->count();
        $teacherActiveCount = User::where('role','teacher')->where('active',1)->count();
        $courseCount = Course::count();
        return response()->json([
            'studentReqCount' => $studentReqCount,
            'teacherReqCount' => $teacherReqCount,
            'studentActiveCount' => $studentActiveCount,
            'teacherActiveCount' => $teacherActiveCount,
            'courseCount' => $courseCount,
        ]);
    }

    //student 
    public function studentReq(){
        return view('admin.pages.studentReq');
    }

    public function studentReqView(){
        $data = User::where('role','=','student')
                        ->where('active','=',0)
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
    public function studentReqActivate(Request $request, $id){
        $active = intval($request->activate);
        $data = User::where('role','=','student')
                        ->where('id','=',$id)
                        ->update([
                            'active' => $active
                        ]);
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Student activated successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }
    
    public function studentList(){
        return view('admin.pages.studentList');
    }
    
    public function studentListView(){
        $data = User::where('role','=','student')
        ->where('active','=',1)
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
    
    public function studentListDelete(Request $request, $id){
        $data = User::where('role','=','student')
                        ->where('id','=',$id)
                        ->delete();
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Student Deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    //teacher
    public function teacherReq(){
        return view('admin.pages.teacherReq');
    }

    public function teacherReqView(){
        $data = User::where('role','=','teacher')
                        ->where('active','=',0)
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
    public function teacherReqActivate(Request $request, $id){
        $active = intval($request->activate);
        $data = User::where('role','=','teacher')
                        ->where('id','=',$id)
                        ->update([
                            'active' => $active
                        ]);
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Student activated successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }


    public function teacherList(){
        return view('admin.pages.teacherList');
    }
    
    public function teacherListView(){
        $data = User::where('role','=','teacher')
        ->where('active','=',1)
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

    public function teacherEdit($id){
        $data = User::where('id','=',$id)->first();
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


    
    public function teacherListDelete(Request $request, $id){
        $data = User::where('role','=','teacher')
                        ->where('id','=',$id)
                        ->delete();
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Teacher Deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    //course
    public function createCourse(){
        return view('admin.pages.createCourse');
    }

    public function storeCourse(Request $request){
        $obj = new Course();
        $obj->course_code = $request->course_code;
        $obj->course_title = $request->course_title;
        $obj->course_credit = floatval($request->course_credit);
        $obj->course_semester = intval($request->course_semester);
        $obj->course_session = intval($request->course_session);
        if($obj->save()){
            return response()->json([
                'status' => 'success',
                'message' => 'Course created successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Course creation failed'
            ]);
        }

    }

    public function courseList(){
        return view('admin.pages.courseList');
    }

    public function courseListView(){
        // $data = Course::all()
        $data = DB::table('courses')
                    ->join('semesters','courses.course_semester','=','semesters.id')
                    ->join('sessions','courses.course_session','=','sessions.id')
                    ->select('courses.*','semesters.semester_name as semester_name','sessions.session_name as session_name')
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

    public function courseEdit($id){
        $data = Course::where('id','=',$id)->first();
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

    public function courseUpdate(Request $request, $id){
        $data = Course::where('id','=',$id)
                        ->update([
                            'course_code' => $request->course_code,
                            'course_title' => $request->course_title,
                            'course_credit' => floatval($request->course_credit),
                            'course_semester' => intval($request->course_semester),
                            'course_session' => intval($request->course_session)
                        ]);
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Course updated successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    public function courseListDelete(Request $request, $id){
        $data = Course::where('id','=',$id)
                        ->delete();
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Course Deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    // session
    public function createSession(){
        return view('admin.pages.createSession');
    }

    public function storeSession(Request $request){
        $obj = new Session();
        $obj->session_name = $request->session_name;
        if($obj->save()){
            return response()->json([
                'status' => 'success',
                'message' => 'Session created successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Session creation failed'
            ]);
        }

    }

    public function sessionList(){
        return view('admin.pages.sessionList');
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

    public function sessionEdit($id){
        $data = Session::where('id','=',$id)->first();
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

    public function sessionUpdate(Request $request, $id){
        $data = Session::where('id','=',$id)
                        ->update([
                            'session_name' => $request->session_name
                        ]);
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Session updated successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    public function sessionListDelete(Request $request, $id){
        $data = Session::where('id','=',$id)
                        ->delete();
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Session Deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    // semester
    public function createSemester(){
        return view('admin.pages.createSemester');
    }

    public function storeSemester(Request $request){
        $obj = new Semester();
        $obj->semester_name = intval($request->semester_name);
        if($obj->save()){
            return response()->json([
                'status' => 'success',
                'message' => 'Semester created successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Semester creation failed'
            ]);
        }

    }

    public function semesterList(){
        return view('admin.pages.semesterList');
    }

    public function semesterListView(){
        $data = Semester::all();
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

    public function semesterEdit($id){
        $data = Semester::where('id','=',$id)->first();
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

    public function semesterUpdate(Request $request, $id){
        $data = Semester::where('id','=',$id)
                        ->update([
                            'semester_name' => intval($request->semester_name)
                        ]);
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Semester updated successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    public function semesterListDelete(Request $request, $id){
        $data = Semester::where('id','=',$id)
                        ->delete();
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Semester Deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    //section
    public function createSection(){
        return view('admin.pages.createSection');
    }

    public function storeSection(Request $request){
        $obj = new Section();
        $obj->course_code = $request->course_code;
        $obj->session_name = $request->session_name; 
        $obj->section_name = $request->section_name;
        if($obj->save()){
            return response()->json([
                'status' => 'success',
                'message' => 'Section created successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Section creation failed'
            ]);
        }

    }

    public function sectionList(){
        return view('admin.pages.sectionList');
    }

    public function sectionListView(){
         $data = DB::table('sections')
                    ->join('courses','sections.course_code','=','courses.id')
                    ->join('sessions','sections.session_name','=','sessions.id')
                    ->select('sections.*','courses.course_code as course_code','courses.course_title as course_title','sessions.session_name as session_name')
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

    public function sectionEdit($id){
        $data = Section::where('id','=',$id)->first();
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

    public function sectionUpdate(Request $request, $id){
        $data = Section::where('id','=',$id)
                        ->update([
                            'course_code' => $request->course_code,
                            'session_name' => $request->session_name,
                            'section_name' => $request->section_name
                        ]);
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Section updated successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    public function sectionListDelete(Request $request, $id){
        $data = Section::where('id','=',$id)
                        ->delete();
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Section Deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    //assign course teacher

    public function assignCourseTeacher(){
        return view('admin.pages.assignCourseTeacher');
    }

    public function storeAssignCourseTeacher(Request $request){
        $obj = new AssignCourseTeacher();
        $obj->course_code = $request->course_code;
        $obj->session_name = $request->session_name; 
        $obj->section_name = $request->section_name;
        $obj->teacher_id = $request->teacher_id;
        if($obj->save()){
            return response()->json([
                'status' => 'success',
                'message' => 'Assign Course Teacher created successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Assign Course Teacher creation failed'
            ]);
        }

    }

    public function assignCourseTeacherList(){
        return view('admin.pages.assignCourseTeacherList');
    }

    public function assignCourseTeacherListView(){
         $data = DB::table('assign_course_teachers')
                    ->join('courses','assign_course_teachers.course_code','=','courses.id')
                    ->join('sessions','assign_course_teachers.session_name','=','sessions.id')
                    ->join('sections','assign_course_teachers.section_name','=','sections.id')
                    ->join('users','assign_course_teachers.teacher_id','=','users.id')
                    ->select('assign_course_teachers.*','courses.course_code as course_code','courses.course_title as course_title','sessions.session_name as session_name','sections.section_name as section_name','users.uid as teacher_id','users.name as teacher_name','users.email as teacher_email')
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

    public function assignCourseTeacherEdit($id){
        // $data = AssignCourseTeacher::where('id','=',$id)->first();
        $data = DB::table('assign_course_teachers')
                    ->where('assign_course_teachers.id','=',$id)
                    ->join('courses','assign_course_teachers.course_code','=','courses.id')
                    ->join('sessions','assign_course_teachers.session_name','=','sessions.id')
                    ->join('sections','assign_course_teachers.section_name','=','sections.id')
                    ->join('users','assign_course_teachers.teacher_id','=','users.id')
                    ->select('assign_course_teachers.*','courses.course_code as course_code','courses.course_title as course_title','sessions.session_name as session_name','sections.section_name as section_name','users.uid as teacher_uid','users.name as teacher_name','users.email as teacher_email')
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

    public function assignCourseTeacherUpdate(Request $request, $id){
        $data = AssignCourseTeacher::where('id','=',$id)
                        ->update([
                            'course_code' => $request->course_code,
                            'session_name' => $request->session_name,
                            'section_name' => $request->section_name,
                            'teacher_id' => $request->teacher_id
                        ]);
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Assign Course Teacher updated successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    public function assignCourseTeacherListDelete(Request $request, $id){
        $data = AssignCourseTeacher::where('id','=',$id)
                        ->delete();
        if($data){
            return response()->json([
                    'status' => 'success',
                    'message' => 'Assign Course Teacher Deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found'
            ]);
        }
            
    }

    public function assignCourseSection($id){
        $data = Section::where('course_code','=',$id)->get();
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

}
