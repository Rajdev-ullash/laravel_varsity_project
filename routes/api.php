<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('store-user',[UsersController::class,'store']);
Route::post('user-login',[UsersController::class,'userLogin']);
Route::post('store-admin',[UsersController::class,'adminLoginStore']);
Route::get('dashboard-data',[AdminController::class,'dashboardCount']);

//students
Route::get('show-student-req',[AdminController::class,'studentReqView']);
Route::post('student-req-activate/{id}',[AdminController::class,'studentReqActivate']);
Route::get('show-student-list',[AdminController::class,'studentListView']);
Route::post('student-list-delete/{id}',[AdminController::class,'studentListDelete']);

//teachers
Route::get('show-teacher-req',[AdminController::class,'teacherReqView']);
Route::post('teacher-req-activate/{id}',[AdminController::class,'teacherReqActivate']);
Route::get('show-teacher-list',[AdminController::class,'teacherListView']);
Route::get('show-teacher-edit/{id}',[AdminController::class,'teacherEdit']);
Route::post('teacher-list-delete/{id}',[AdminController::class,'teacherListDelete']);

//courses
Route::post('store-course',[AdminController::class,'storeCourse']);
Route::get('show-course-list',[AdminController::class,'courseListView']);
Route::get('show-course-edit/{id}',[AdminController::class,'courseEdit']);
Route::post('course-update/{id}',[AdminController::class,'courseUpdate']);
Route::post('course-list-delete/{id}',[AdminController::class,'courseListDelete']);

//sessions
Route::post('store-session',[AdminController::class,'storeSession']);
Route::get('show-session-list',[AdminController::class,'sessionListView']);
Route::get('show-session-edit/{id}',[AdminController::class,'sessionEdit']);
Route::post('session-update/{id}',[AdminController::class,'sessionUpdate']);
Route::post('session-list-delete/{id}',[AdminController::class,'sessionListDelete']);

//semesters
Route::post('store-semester',[AdminController::class,'storeSemester']);
Route::get('show-semester-list',[AdminController::class,'semesterListView']);
Route::get('show-semester-edit/{id}',[AdminController::class,'semesterEdit']);
Route::post('semester-update/{id}',[AdminController::class,'semesterUpdate']);
Route::post('semester-list-delete/{id}',[AdminController::class,'semesterListDelete']);

//sections
Route::post('store-section',[AdminController::class,'storeSection']);
Route::get('show-section-list',[AdminController::class,'sectionListView']);
Route::get('show-section-edit/{id}',[AdminController::class,'sectionEdit']);
Route::post('section-update/{id}',[AdminController::class,'sectionUpdate']);
Route::post('section-list-delete/{id}',[AdminController::class,'sectionListDelete']);

//assign course teacher
Route::post('store-assign-course-teacher',[AdminController::class,'storeAssignCourseTeacher']);
Route::get('show-assign-course-teacher-list',[AdminController::class,'assignCourseTeacherListView']);
Route::get('show-assign-course-teacher-edit/{id}',[AdminController::class,'assignCourseTeacherEdit']);
Route::post('assign-course-teacher-update/{id}',[AdminController::class,'assignCourseTeacherUpdate']);
Route::post('assign-course-teacher-list-delete/{id}',[AdminController::class,'assignCourseTeacherListDelete']);
Route::get('show-assign-course-section/{id}',[AdminController::class,'assignCourseSection']);

//student course
Route::get('show-student-session',[StudentController::class,'sessionListView']);
Route::get('show-student-course/{id}',[StudentController::class,'courseListView']);
Route::get('show-student-section',[StudentController::class,'sectionListView']);
Route::post('store-student-enroll-course',[StudentController::class,'enrollCourse']);
Route::get('show-student-enroll-course',[StudentController::class,'enrollCourseListView']);
Route::post('student-enroll-course-delete/{id}',[StudentController::class,'enrollCourseDelete']);
Route::get('show-student-course-result',[StudentController::class,'specificStudentAssignMarksView']);
Route::get('show-student-all-course-result',[StudentController::class,'specificStudentTeacherGivenMarksView']);

//teacher course
Route::get('show-teacher-course',[TeacherController::class,'assignCourseListView']);
Route::get('show-teacher-enroll-student/{id}',[TeacherController::class,'getEnrollStudentList']);
Route::get('show-teacher-specific-mark/{id}',[TeacherController::class,'specificMarkSystem']);
Route::post('store-teacher-mark/{id}',[TeacherController::class,'updateSpecificMarkSystem']);
Route::post('delete-store-teacher-mark/{id}',[TeacherController::class,'deleteCourseSpecificMarkSystem']);
Route::post('teacher-mark-system',[TeacherController::class,'storeTeacherMarkSystem']);
Route::post('store-teacher-assign-marks',[TeacherController::class,'storeAssignMarks']);
Route::get('show-teacher-assign-marks-all/{id}',[TeacherController::class,'storeAssignMarksView']);
Route::get('show-teacher-assign-marks-list/{id}',[TeacherController::class,'editStoreAssignMarks']);
Route::post('show-teacher-assign-marks-update/{id}',[TeacherController::class,'updateStoreAssignMarks']);
Route::post('teacher-assign-course-marks-store',[TeacherController::class,'courseMarksStoreAction']);
Route::get('show-teacher-assign-course-specific-mark/{id}',[TeacherController::class,'courseSpecificMarkSystem']);
Route::post('show-teacher-assign-mark-store-course',[TeacherController::class,'storeStudentCourseMarks']);
Route::post('show-teacher-assign-mark-store-course-json',[TeacherController::class,'jsonStudentCourseMarks']);
Route::get('show-teacher-assign-mark-student-list/{id}',[TeacherController::class,'getStudentCourseMarks']);
Route::get('show-teacher-assign-mark-specific-student/{id}',[TeacherController::class,'getSpecificJsonStudentCourseMarks']);
Route::post('show-teacher-assign-course-specific-mark-update/{id}',[TeacherController::class,'updateCourseSpecificMarkSystem']);
Route::post('show-teacher-assign-mark-specific-student-update/{id}',[TeacherController::class,'updateSpecificJsonStudentCourseMarks']);
