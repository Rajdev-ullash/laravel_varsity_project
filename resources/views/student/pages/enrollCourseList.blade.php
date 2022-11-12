@extends('student.layouts.default')
@section('contents')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Enroll Course List</h1>
        <p class="mb-4"></a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of enrollment courses</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Title</th>
                                <th>Course Credit</th>
                                <th>Course Semester</th>
                                <th>Section</th>
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
            getAllEnrollCourses();
            //get all Enroll Courses
            function getAllEnrollCourses() {
                var str = ""
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/show-student-enroll-course',
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
                                <td>${data[i].course_code}</td>
                                <td>${data[i].course_title}</td>
                                <td>${data[i].course_credit}</td>
                                <td>${data[i].course_semester}th</td>
                                <td>${data[i].section_name}</td>
                                <td>${( moment(data[i].created_at).format("DD-MM-YYYY"))}</td>
                                <td>
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


            // Delete courses
            $(document).on('click', '#submit', function() {
                var id = $(this).attr('value');
                $.ajax({
                    url: `http://127.0.0.1:8000/api/student-enroll-course-delete/${id}`,
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
