@extends('student.layouts.default')
@section('contents')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Result</h1>
        <p class="mb-4"></a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of enrollment courses result</h6>
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
                                <th>Attendence</th>
                                <th>Class Test</th>
                                <th>Assignment</th>
                                <th>MidTerm</th>
                                <th>Final</th>
                                <th>Total</th>

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
                    url: 'http://127.0.0.1:8000/api/show-student-course-result',
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
                                <td>${data[i].attendance}</td>
                                <td>${data[i].class_test}</td>
                                <td>${data[i].assignment_marks}</td>
                                <td>${data[i].midterm}</td>
                                <td>${data[i].final}</td>
                                <td>${data[i].total}</td>
                               
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
        });
    </script>
@endsection
