@extends('admin.layouts.default')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Create Course</h1>
        <p class="mb-2"></a>.</p>

        <div class="card o-hidden border-0 shadow-lg my-3">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row d-flex justify-content-center">
                    {{-- <div class="col-lg-6 d-none d-lg-block bg-password-image"></div> --}}
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-5">Create Course</h1>
                                <div id="reg">

                                </div>

                            </div>
                            <form class="user">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="course_code"
                                        placeholder="Enter Course Code...">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="course_title"
                                        placeholder="Enter Course Tittle...">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user" id="course_credit"
                                        placeholder="Enter Course Credit...">
                                </div>
                                <div class="form-group">
                                    <select class="form-select form-control-user py-3 w-100 px-3" name="course_semester"
                                        id="course_semester">


                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-select form-control-user py-3 w-100 px-3" name="course_session"
                                        id="course_session">

                                    </select>
                                </div>
                                <a href="#" id="submit" class="btn btn-primary btn-user btn-block">
                                    Create Course
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.js"
        integrity="sha512-NXopZjApK1IRgeFWl6aECo0idl7A+EEejb8ur0O3nAVt15njX9Gvvk+ArwgHfbdvJTCCGC5wXmsOUXX+ZZzDQw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function() {
            getAllSemesters();
            //get all semsester
            function getAllSemesters() {
                var str = ""
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/show-semester-list',
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var str = '<option selected>Selected Course Semester</option>';
                            var data = result.data;
                            console.log(data);
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                console.log(data[i].id);
                                str +=
                                    `<option value="${data[i].id}">${data[i].semester_name}</option>`
                            }
                            $("#course_semester").append(str);

                        } else if (result.status == 'error') {
                            str +=
                                `<option>${result.message}</option>`;
                            $("#course_semester").append(str);
                        }
                    }
                });
            }

            getAllSessions();
            //get all sessions
            function getAllSessions() {
                var str = ""
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/show-session-list',
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data;
                            console.log(data);
                            var str = '<option selected>Selected Course Session</option>';
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                console.log(data[i].id);
                                str +=
                                    `<option value="${data[i].id}">${data[i].session_name}</option>`
                            }
                            $("#course_session").append(str);

                        } else if (result.status == 'error') {
                            str +=
                                `<option>${result.message}</option>`;
                            $("#course_session").append(str);
                        }
                    }
                });
            }
            $('#submit').click(function() {

                var course_code = $('#course_code').val();
                console.log(course_code);

                var course_title = $('#course_title').val();
                console.log(course_title);
                var course_credit = $('#course_credit').val();
                console.log(course_credit);
                var course_semester = $('#course_semester').val();
                console.log(course_semester);
                var course_session = $('#course_session').val();
                console.log(course_session);
                var str = ''
                $("#reg").empty();
                if (course_code == '' || course_title == '' || course_credit == '' || course_semester ==
                    '' || course_session == '') {
                    alert('Please fill all fields');
                } else {

                    $.ajax({
                        url: 'http://127.0.0.1:8000/api/store-course',
                        type: 'POST',
                        dataType: "json",
                        data: {
                            course_code: course_code,
                            course_title: course_title,
                            course_credit: course_credit,
                            course_semester: course_semester,
                            course_session: course_session,
                        },
                        success: function(result) {
                            console.log(result);
                            if (result.status == 'success') {
                                str +=
                                    `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
                                $("#reg").append(str);
                                setTimeout(() => {
                                    window.location.href =
                                        "http://127.0.0.1:8000/admin-course-list"
                                }, 1000);
                            } else if (result.status == 'error') {
                                str +=
                                    `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
                                $("#reg").append(str);
                            } else if (result.status == 'err') {
                                str +=
                                    `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
                                $("#reg").append(str);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
