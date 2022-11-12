@extends('admin.layouts.default')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Section List</h1>
        <p class="mb-4"></a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of sections</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Code</th>
                                <th>Course Title</th>
                                <th>Teacher ID</th>
                                <th>Teacher Name</th>
                                <th>Teacher Email</th>
                                <th>Section</th>
                                <th>Session</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id='t_data'>


                        </tbody>
                    </table>
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
            getAllAssignCourseTeacher();
            //get all assign course teacher
            function getAllAssignCourseTeacher() {
                var str = ""
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/show-assign-course-teacher-list',
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data;
                            console.log(data);
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                console.log(data[i].id);
                                str += `<tr>
                                <td>${data[i].id}</td>
                                <td>${data[i].course_code}</td>
                                <td>${data[i].course_title}</td>
                                <td>${data[i].teacher_id}</td>
                                <td>${data[i].teacher_name}</td>
                                <td>${data[i].teacher_email}</td>
                                <td>${data[i].section_name}</td>
                                <td>${data[i].session_name}</td>
                                <td>${( moment(data[i].created_at).format("DD-MM-YYYY"))}</td>
                                <td>
                                    <a id="edit" value="${data[i].id}" href="#" class="btn btn-success btn-circle btn-sm me-2" data-toggle="modal" data-target="#myModal${data[i].id}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <div class="modal" id="myModal${data[i].id}">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h4 class="modal-title">Update Assign Teacher</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="user">
                                                    <div class="form-group">
                                                        <select class="form-select form-control-user py-3 w-100 px-3" name="course_code"
                                                            id="course_code">


                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="course_title"
                                                            placeholder="Course Tittle..." disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-select form-control-user py-3 w-100 px-3" name="teacher_id"
                                                            id="teacher_id">


                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="teacher_name"
                                                            placeholder="Teacher Name..." disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control form-control-user" id="teacher_email"
                                                            placeholder="Teacher Email..." disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-select form-control-user py-3 w-100 px-3" name="section_name"
                                                            id="section_name">

                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-select form-control-user py-3 w-100 px-3" name="session_name"
                                                            id="session_name">

                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <a id="update" value="${data[i].id}" class="btn btn-success">Update</a>
                                            </div>

                                        </div>
                                        </div>
                                    </div>
                                    <a href="#" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#myModalone${data[i].id}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <div class="modal" id="myModalone${data[i].id}">
                                        <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h4 class="modal-title">Delete Confirmation</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                            Are you sure to delete <b>${data[i].course_title}</b> account?
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            <a id="submit" value="${data[i].id}" class="btn btn-success">Delete</a>
                                            </div>

                                        </div>
                                        </div>
                                    </div>
                                    
                                </td>
                            </tr>`
                            }
                            $("#t_data").append(str);

                        } else if (result.status == 'error') {
                            str +=
                                `<tr><td colspan="8" class="text-center">${result.message}</td></tr>`;
                            $("#t_data").append(str);
                        }
                    }
                });
            }



            //specific section information
            $(document).on('click', '#edit', function() {
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
                                var str = '<option selected>Selected Course Code</option>';
                                var data = result.data;
                                console.log(data);
                                var lent = result.data.length;
                                for (var i = 0; i < lent; i++) {
                                    console.log(data[i].course_code);
                                    str +=
                                        `<option value="${data[i].id}">${data[i].course_code}</option>`
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
                                var str = '<option selected>Selected Teacher Code</option>';
                                var data = result.data;
                                console.log(data);
                                var lent = result.data.length;
                                for (var i = 0; i < lent; i++) {
                                    console.log(data[i].uid);
                                    str +=
                                        `<option value="${data[i].id}">${data[i].uid}</option>`
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
                var id = $(this).attr('value');
                console.log(id);
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-assign-course-teacher-edit/${id}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data[0];
                            console.log(data.course_code);
                            $("#course_code").val(data.course_code);
                            $("#course_title").val(data.course_title);
                            $("#teacher_id").val(data.teacher_id);
                            $("#teacher_name").val(data.teacher_name);
                            $("#teacher_email").val(data.teacher_email);
                            $("#session_name").val(data.session_name);
                            $("#section_name").val(data.section_name);



                        } else if (result.status == 'error') {
                            Toastify({
                                text: result.message,
                                className: "danger",
                                duration: 3000,
                            }).showToast();
                        }
                    }
                });
            });

            //update assign teacher information
            $(document).on('click', '#update', function() {
                var id = $(this).attr('value');
                var course_code = $("#course_code").val();
                var teacher_id = $("#teacher_id").val();
                var session_name = $("#session_name").val();
                var section_name = $("#section_name").val();

                $.ajax({
                    url: `http://127.0.0.1:8000/api/section-update/${id}`,
                    type: 'POST',
                    dataType: "json",
                    data: {
                        course_code: course_code,
                        teacher_id: teacher_id,
                        session_name: session_name,
                        section_name: section_name,
                    },
                    success: function(result) {
                        $("#myModal" + id).modal('hide');
                        console.log(result);
                        if (result.status == 'success') {
                            Toastify({
                                text: result.message,
                                className: "succes",
                                duration: 3000,
                            }).showToast();
                            setTimeout(() => {
                                window.location.reload();
                                // getAllCourses();
                            }, 3000);
                        } else if (result.status == 'error') {
                            Toastify({
                                text: result.message,
                                className: "danger",
                                duration: 3000,
                            }).showToast();
                        }
                    }
                });

            });

            // Delete courses
            $(document).on('click', '#submit', function() {
                var id = $(this).attr('value');
                $.ajax({
                    url: `http://127.0.0.1:8000/api/section-list-delete/${id}`,
                    type: 'POST',
                    dataType: "json",
                    success: function(result) {
                        $("#myModalone" + id).modal('hide');
                        console.log(result);
                        if (result.status == 'success') {
                            Toastify({
                                text: result.message,
                                className: "succes",
                                duration: 3000,
                            }).showToast();
                            setTimeout(() => {
                                window.location.reload();
                                // getAllCourses();
                            }, 3000);
                        } else if (result.status == 'error') {
                            Toastify({
                                text: result.message,
                                className: "danger",
                                duration: 3000,
                            }).showToast();
                        }
                    }
                });
            });

        });
    </script>
@endsection
