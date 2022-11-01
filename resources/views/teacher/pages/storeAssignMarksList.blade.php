@extends('teacher.layouts.default')
@section('teacher_contents')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Student List</h1>
        <p class="mb-4"></a>.</p>
        <div id='st' value="{{ $section_name }}"></div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of Marks</h6>
            </div>
            <div class="d-flex ml-auto me-2">



            </div>
            <div class="card-body">
                <div id="reg">

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Attendence</th>
                                <th>Class Test</th>
                                <th>Assignment</th>
                                <th>Mid Term</th>
                                <th>Final</th>
                                <th>Total</th>
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

            var section_id = $('#st').attr('value');
            console.log(section_id);

            getAllMarksStudent();
            // get all courses

            function getAllMarksStudent() {

                var str = ""
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-teacher-assign-marks-all/${section_id}`,
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
                                        <td>${data[i].user_name}</td>
                                        <td>${data[i].user_uid}</td>
                                        <td>${data[i].attendance}</td>
                                        <td>${data[i].class_test}</td>
                                        <td>${data[i].assignment_marks}</td>
                                        <td>${data[i].midterm}</td>
                                        <td>${data[i].final}</td>
                                        <td>${data[i].total}</td>
                                        <td><button id="student_marks_edit" value="${data[i].student_id}" class="btn btn-primary"data-toggle="modal"
                                            data-target="#myModalone${data[i].student_id}" >Edit</button>
                                            <div class="modal" id="myModalone${data[i].student_id}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Assign Mark</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="user">
                                                                <div class="form-group">
                                                                    <label id="attendance_label" for="attendance"></label>
                                                                    <input type="number" class="form-control form-control-user" id="attendance"
                                                                        placeholder="Attendence Mark...">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label id="class_test_label" for="class_test"></label>
                                                                    <input type="number" class="form-control form-control-user" id="class_test"
                                                                        placeholder="Class Test Mark...">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label id="assignment_mark_label" for="assignment_mark"></label>
                                                                    <input type="number" class="form-control form-control-user"
                                                                        id="assignment_mark" placeholder="AssignMent Mark...">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label id="midterm_label" for="midterm"></label>
                                                                    <input type="number" class="form-control form-control-user" id="midterm"
                                                                        placeholder="Midterm Mark...">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label id="final_label" for="final"></label>
                                                                    <input type="number" class="form-control form-control-user" id="final"
                                                                        placeholder="Final Mark...">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            <button id="assign_marks_store" value="${data[i].student_id}" class="btn btn-success">Update</button>
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

            getAllMarks();

            function getAllMarks() {
                var str = ""
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-teacher-specific-mark/${section_id}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data;
                            console.log(data);
                            $("#attendance_label").text("Attendence Mark :" + data.attendance);

                            $("#class_test_label").text("Class Test Mark :" + data.class_test);
                            $("#assignment_mark_label").text("Assignment Mark :" + data
                                .assignment_marks);
                            $("#midterm_label").text("Mid Term Mark :" + data.midterm);
                            $("#final_label").text("Final Mark :" + data.final);



                        } else if (result.status == 'error') {
                            console.log(result.message);
                        }
                    }
                });
            }



            // edit student marks
            $(document).on('click', '#student_marks_edit', function() {
                var student_name = $(this).attr('value');
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-teacher-assign-marks-list/${student_name}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data;
                            console.log(data);
                            $('#attendance').val(data.attendance);
                            $('#class_test').val(data.class_test);
                            $('#assignment_mark').val(data.assignment_marks);
                            $('#midterm').val(data.midterm);
                            $('#final').val(data.final);
                        }
                    }
                })
            })

            //update marks student
            $(document).on('click', '#assign_marks_store', function() {
                var student_name = $(this).attr('value');
                var attendance_label = $("#attendance_label").text();
                var class_test_label = $("#class_test_label").text();
                var assignment_mark_label = $("#assignment_mark_label").text();
                var midterm_label = $("#midterm_label").text();
                var final_label = $("#final_label").text();
                var attendance = $("#attendance").val();
                var class_test = $("#class_test").val();
                var assignment_marks = $("#assignment_mark").val();
                var midterm = $("#midterm").val();
                var final = $("#final").val();
                var total = parseInt(attendance) + parseInt(class_test) + parseInt(assignment_marks) +
                    parseInt(midterm) + parseInt(final);

                if (attendance > parseInt(attendance_label.split(':')[1])) {
                    alert("Attendance Mark is not greater than " + attendance_label.split(':')[1]);
                } else if (class_test > parseInt(class_test_label.split(':')[1])) {
                    alert("Class Test Mark is not greater than " + class_test_label.split(':')[1]);
                } else if (assignment_marks > parseInt(assignment_mark_label.split(':')[1])) {
                    alert("Assignment Mark is not greater than " + assignment_mark_label.split(':')[1]);
                } else if (midterm > parseInt(midterm_label.split(':')[1])) {
                    alert("Midterm Mark is not greater than " + midterm_label.split(':')[1]);
                } else if (final > parseInt(final_label.split(':')[1])) {
                    alert("Final Mark is not greater than " + final_label.split(':')[1]);
                } else {
                    $.ajax({
                        url: `http://127.0.0.1:8000/api/show-teacher-assign-marks-update/${student_name}`,
                        type: 'POST',
                        dataType: "json",
                        data: {
                            attendance: parseInt(attendance),
                            class_test: parseInt(class_test),
                            assignment_marks: parseInt(assignment_marks),
                            midterm: parseInt(midterm),
                            final: parseInt(final),
                            total: total,

                        },
                        success: function(result) {
                            console.log(result);
                            $("#myModalone" + student_name).modal('hide');
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
                    })

                }
            })

        });
    </script>
@endsection
