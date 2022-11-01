@extends('admin.layouts.default')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pending Teacher Request</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="teacherReqCount"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pending Student Request</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="studentReqCount"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Teacher</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="teacherActiveCount"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Student</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="studentActiveCount"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Request -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Courses</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="courseCount"></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            getAllUsers();
            //get all users
            function getAllUsers() {
                var teacherActiveCount = ""
                var studentActiveCount = ""
                var studentReqCount = ""
                var teacherReqCount = ""
                var courseCount = ""
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/dashboard-data',
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        var user = result;
                        teacherActiveCount = user.teacherActiveCount;
                        $('#teacherActiveCount').html(teacherActiveCount);
                        studentActiveCount = user.studentActiveCount;
                        $('#studentActiveCount').html(studentActiveCount);
                        studentReqCount = user.studentReqCount;
                        $('#studentReqCount').html(studentReqCount);
                        teacherReqCount = user.teacherReqCount;
                        $('#teacherReqCount').html(teacherReqCount);
                        courseCount = user.courseCount;
                        $('#courseCount').html(courseCount);


                    }
                });
            }
        });
    </script>
@endsection
