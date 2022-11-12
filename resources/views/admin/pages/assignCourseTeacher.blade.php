@extends('admin.layouts.default')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Assign Course Teacher</h1>
        <p class="mb-2"></a>.</p>

        <div class="card o-hidden border-0 shadow-lg my-3">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row d-flex justify-content-center">
                    {{-- <div class="col-lg-6 d-none d-lg-block bg-password-image"></div> --}}
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-5">Assign Course Teacher</h1>
                                <div id="reg">

                                </div>

                            </div>
                            <form class="user">
                                <div class="form-group">
                                    <select class="form-select form-control-user py-3 w-100 px-3" name="session_name"
                                        id="session_name">

                                    </select>
                                </div>
                                <div class="form-group">
                                    <select class="form-select form-control-user py-3 w-100 px-3" name="course_code"
                                        id="course_code">


                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control form-control-user" id="course_title"
                                        placeholder="Course Tittle..." disabled>
                                </div>
                                <div class="form-group">
                                    <select class="form-select form-control-user py-3 w-100 px-3" name="teacher_id"
                                        id="teacher_id">


                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control form-control-user" id="teacher_name"
                                        placeholder="Teacher Name..." disabled>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" class="form-control form-control-user" id="teacher_email"
                                        placeholder="Teacher Email..." disabled>
                                </div>
                                <div class="form-group">
                                    <select class="form-select form-control-user py-3 w-100 px-3" name="section_name"
                                        id="section_name">

                                    </select>
                                </div>

                                <a href="#" id="submit" class="btn btn-primary btn-user btn-block">
                                    Assign Course Teacher
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
            getAllCourses();
            //get all semsester
            function getAllCourses() {
                var str = ""
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/show-course-list',
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var str = '<option selected>Selected Course Title</option>';
                            var data = result.data;
                            console.log(data);
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                console.log(data[i].course_code);
                                str +=
                                    `<option value="${data[i].id}">${data[i].course_title}</option>`
                            }
                            $("#course_code").append(str);

                        } else if (result.status == 'error') {
                            str +=
                                `<option>${result.message}</option>`;
                            $("#course_code").append(str);
                        }
                    }
                });
            }

            //get all teacher
            getAllTeacher();

            function getAllTeacher() {
                var str = ""
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/show-teacher-list',
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var str = '<option selected>Selected Teacher Name</option>';
                            var data = result.data;
                            console.log(data);
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                console.log(data[i].uid);
                                str +=
                                    `<option value="${data[i].id}">${data[i].name}</option>`
                            }
                            $("#teacher_id").append(str);

                        } else if (result.status == 'error') {
                            str +=
                                `<option>${result.message}</option>`;
                            $("#teacher_id").append(str);
                        }
                    }
                });
            }

            // specific course info
            $("#course_code").change(function() {
                var id = $(this).val();
                console.log(id);
                var str = ""
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-course-edit/${id}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data;
                            console.log(data);
                            // $("#course_code").val(data.course_code);
                            $("#course_title").val(data.course_title);
                            // $("#course_credit").val(data.course_credit);
                            // $("#course_semester").val(data.course_semester);
                            // $("#course_session").val(data.course_session);


                        } else if (result.status == 'error') {
                            Toastify({
                                text: result.message,
                                className: "danger",
                                duration: 3000,
                            }).showToast();
                        }
                    }
                });
                //get all section
                var str = ""
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-assign-course-section/${id}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var str = '<option selected>Select Section</option>';
                            var data = result.data;
                            console.log(data);
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                console.log(data[i].section_name);
                                str +=
                                    `<option value="${data[i].id}">${data[i].section_name}</option>`
                            }
                            $("#section_name").append(str);

                        } else if (result.status == 'error') {
                            str +=
                                `<option>${result.message}</option>`;
                            $("#section_name").append(str);
                        }
                    }
                });
            });



            // specific teacher info
            $("#teacher_id").change(function() {
                var id = $(this).val();
                console.log(id);
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-teacher-edit/${id}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data;
                            console.log(data);
                            $("#teacher_name").val(data.name);
                            $("#teacher_email").val(data.email);



                        } else if (result.status == 'error') {
                            Toastify({
                                text: result.message,
                                className: "danger",
                                duration: 3000,
                            }).showToast();
                        }
                    }
                });
            })

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
                            var str = '<option selected>Selected Session</option>';
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                console.log(data[i].id);
                                str +=
                                    `<option value="${data[i].id}">${data[i].session_name}</option>`
                            }
                            $("#session_name").append(str);

                        } else if (result.status == 'error') {
                            str +=
                                `<option>${result.message}</option>`;
                            $("#session_name").append(str);
                        }
                    }
                });
            }
            $('#submit').click(function() {

                var course_code = $('#course_code').val();
                console.log(course_code);

                var teacher_id = $('#teacher_id').val();
                console.log(teacher_id);

                var session_name = $('#session_name').val();
                console.log(session_name);

                var section_name = $('#section_name').val();
                console.log(section_name);

                var str = ''
                $("#reg").empty();
                if (course_code == '') {
                    alert('Please fill all fields');
                } else {

                    $.ajax({
                        url: 'http://127.0.0.1:8000/api/store-assign-course-teacher',
                        type: 'POST',
                        dataType: "json",
                        data: {
                            course_code: course_code,
                            teacher_id: teacher_id,
                            session_name: session_name,
                            section_name: section_name,
                        },
                        success: function(result) {
                            console.log(result);
                            if (result.status == 'success') {
                                str +=
                                    `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
                                $("#reg").append(str);
                                setTimeout(() => {
                                    window.location.href =
                                        "http://127.0.0.1:8000/admin-assignCourseTeacher-list"
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
