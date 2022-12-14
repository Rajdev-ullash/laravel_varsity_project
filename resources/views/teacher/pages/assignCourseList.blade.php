@extends('teacher.layouts.default')
@section('teacher_contents')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Course List</h1>
        <p class="mb-4"></a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of courses</h6>
            </div>
            <div class="card-body">
                <div id="reg">

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Title</th>
                                <th>Course Credit</th>
                                <th>Course Semester</th>
                                <th>Section</th>
                                <th>Assign</th>
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
            getAllCourses();
            //get all courses
            function getAllCourses() {
                var str = ""
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-teacher-course`,
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
                                <td><a href="{{ url('teacher-enroll-student-list/${data[i].section_id}') }}" class="btn btn-primary" id="assign">Enter</a></td>
                                
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

            // $("#submit").click(function() {


            //     var str = ''
            //     $("#reg").empty();
            //     if (section_id.length === 0) {
            //         alert('Please select at least one course');
            //     } else {

            //         $.ajax({
            //             url: 'http://127.0.0.1:8000/api/store-student-enroll-course',
            //             type: 'POST',
            //             dataType: "json",
            //             data: {
            //                 section_name: section_id,
            //             },
            //             success: function(result) {
            //                 console.log(result);
            //                 if (result.status == 'success') {
            //                     str +=
            //                         `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
            //                     $("#reg").append(str);
            //                     setTimeout(() => {
            //                         window.location.href =
            //                             "http://127.0.0.1:8000/student-enroll-list"
            //                     }, 3000);
            //                 } else if (result.status == 'error') {
            //                     str +=
            //                         `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
            //                     $("#reg").append(str);
            //                 } else if (result.status == 'err') {
            //                     str +=
            //                         `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
            //                     $("#reg").append(str);
            //                 }
            //             }
            //         });
            //     }
            // })
        });
    </script>
@endsection
