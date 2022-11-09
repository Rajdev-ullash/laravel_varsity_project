<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//student login registration routes
Route::get('/student-login', [UsersController::class, 'studentLogin']);
Route::get('/student-register', [UsersController::class, 'studentRegister']);

//teacher login routes
Route::get('/teacher-login', [UsersController::class, 'teacherLogin']);
Route::get('/teacher-register', [UsersController::class, 'teacherRegister']);

//admin login routes
Route::get('/admin-login', [UsersController::class, 'adminLogin']);

Route::get('/', [UsersController::class, 'home']);

//protected routes
Route::middleware(['CheckLogin'])->group(function () {
    Route::get('/home', [UsersController::class, 'home']);
    Route::middleware(['CheckAdmin'])->group(function () {
        //Admin Routes
        Route::get('admin-home',[AdminController::class, 'home']);

        Route::get('admin-student-req',[AdminController::class, 'studentReq']);
        Route::get('admin-student-list',[AdminController::class, 'studentList']);

        Route::get('admin-teacher-req',[AdminController::class, 'teacherReq']);
        Route::get('admin-teacher-list',[AdminController::class, 'teacherList']);

        Route::get('admin-course-create',[AdminController::class, 'createCourse']);
        Route::get('admin-course-list',[AdminController::class, 'courseList']);

        Route::get('admin-session-create',[AdminController::class, 'createSession']);
        Route::get('admin-session-list',[AdminController::class, 'sessionList']);

        Route::get('admin-semester-create',[AdminController::class, 'createSemester']);
        Route::get('admin-semester-list',[AdminController::class, 'semesterList']);

        Route::get('admin-section-create',[AdminController::class, 'createSection']);
        Route::get('admin-section-list',[AdminController::class, 'sectionList']);

        Route::get('admin-assignCourseTeacher-create',[AdminController::class, 'assignCourseTeacher']);
        Route::get('admin-assignCourseTeacher-list',[AdminController::class, 'assignCourseTeacherList']);


    });
    Route::middleware(['CheckStudent'])->group(function () {
        //Student routes
        Route::get('/student-home', [StudentController::class, 'home']);
        Route::get('/student-session-list', [StudentController::class, 'sessionList']);
        Route::get('/student-course-list/{id}', [StudentController::class, 'courseList']);
        Route::get('/student-enroll-list', [StudentController::class, 'enrollCourseList']);
        Route::get('/student-course-result', [StudentController::class, 'markSystem']);
    });
    Route::middleware(['CheckTeacher'])->group(function () {
        //Teacher routes
        Route::get('/teacher-home', [TeacherController::class, 'home']);
        Route::get('/teacher-assign-course-list', [TeacherController::class, 'assignCourseList']);
        Route::get('/teacher-enroll-student-list/{id}', [TeacherController::class, 'enrollStudentList']);
        Route::get('/teacher-store-assign-mark-list/{id}', [TeacherController::class, 'storeAssignMarksList']);
        Route::get('/teacher-assign-mark-list-update/{id}', [TeacherController::class, 'assignMarksList']);
        Route::get('/teacher-assign-mark-list-course/{id}', [TeacherController::class, 'specificCourseMarksStoreView']);
        Route::get('/teacher-assign-student-mark-list-course/{id}', [TeacherController::class, 'studentCourseMarksList']);


    });
});





