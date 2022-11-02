@extends('teacher.layouts.default')
@section('teacher_contents')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Student List</h1>
        <p class="mb-4"></a>.</p>
        <div id='st' value="{{ $section_id }}"></div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of Student</h6>
            </div>
            <div class="d-flex ml-auto me-2">
                <div class="m-3">
                    <a id="assign_marks" value="" href="#" class="btn btn-success me-2" data-toggle="modal"
                        data-target="#myModalone">
                        Assign Marks
                    </a>
                    <div class="modal" id="myModalone">
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
                                    <button id="assign_marks_store" value="" class="btn btn-success">Update</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-3" id="mark_list">

                </div>
                <div class="m-3">
                    <a id="update_marks" value="" href="#" class="btn btn-success me-2" data-toggle="modal"
                        data-target="#myModaltwo">
                        Update Marks System Now
                    </a>
                    <div class="modal" id="myModaltwo">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Update Mark System</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form class="user">
                                        <div class="form-group">
                                            <label id="update_attendance_label" for="update_attendance"></label>
                                            <input type="number" class="form-control form-control-user"
                                                id="update_attendance" placeholder="Attendence Mark...">
                                        </div>
                                        <div class="form-group">
                                            <label id="update_class_test_label" for="update_class_test"></label>
                                            <input type="number" class="form-control form-control-user"
                                                id="update_class_test" placeholder="Class Test Mark...">
                                        </div>
                                        <div class="form-group">
                                            <label id="update_assignment_mark_label" for="update_assignment_mark"></label>
                                            <input type="number" class="form-control form-control-user"
                                                id="update_assignment_mark" placeholder="AssignMent Mark...">
                                        </div>
                                        <div class="form-group">
                                            <label id="update_midterm_label" for="update_midterm"></label>
                                            <input type="number" class="form-control form-control-user"
                                                id="update_midterm" placeholder="Midterm Mark...">
                                        </div>
                                        <div class="form-group">
                                            <label id="update_final_label" for="update_final"></label>
                                            <input type="number" class="form-control form-control-user"
                                                id="update_final" placeholder="Final Mark...">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <a id="update" value="" class="btn btn-success">Update</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div id="reg">

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Student Email</th>

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

            $("#mark_list").append(
                $("<a></a>").attr("href", "/teacher-store-assign-mark-list/" + section_id).attr("class",
                    "btn btn-success me-2").text("Mark List")
            )

            getAllEnrollStudent();
            //get all courses
            function getAllEnrollStudent() {
                var str = ""
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-teacher-enroll-student/${section_id}`,
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
                                <td>
                                    <input type="checkbox" name="student_id" id="section_id" value="${data[i].student_id}"> 
                                </td>
                                <td>${data[i].user_name}</td>
                                <td>${data[i].user_uid}</td>
                                <td>${data[i].user_email}</td>
                                
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
                            $("#update_attendance_label").text("Attendence Mark :" + data.attendance);
                            $("#update_class_test_label").text("Class Test Mark :" + data.class_test);
                            $("#update_assignment_mark_label").text("Assignment Mark :" + data
                                .assignment_marks);
                            $("#update_midterm_label").text("Mid Term Mark :" + data.midterm);
                            $("#update_final_label").text("Final Mark :" + data.final);
                            $("#update_attendance").val(data.attendance);
                            $("#update_class_test").val(data.class_test);
                            $("#update_assignment_mark").val(data.assignment_marks);
                            $("#update_midterm").val(data.midterm);
                            $("#update_final").val(data.final);



                        } else if (result.status == 'error') {
                            console.log(result.message);
                        }
                    }
                });
            }

            //update marks
            $("#update").click(function() {
                var attendance = $("#update_attendance").val();
                var class_test = $("#update_class_test").val();
                var assignment_mark = $("#update_assignment_mark").val();
                var midterm = $("#update_midterm").val();
                var final = $("#update_final").val();
                var section_id = $('#st').attr('value');
                var total = parseInt(attendance) + parseInt(class_test) + parseInt(assignment_mark) +
                    parseInt(midterm) + parseInt(final);
                if (total > 100) {
                    Toastify({
                        text: "Total Marks Can't be greater than 100",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #A40606,#A40606)",
                        stopOnFocus: true,
                        onClick: function() {}
                    }).showToast();
                } else {
                    $.ajax({
                        url: `http://127.0.0.1:8000/api/store-teacher-mark/${section_id}`,
                        type: 'POST',
                        dataType: "json",
                        data: {
                            attendance: parseInt(attendance),
                            class_test: parseInt(class_test),
                            assignment_marks: parseInt(assignment_mark),
                            midterm: parseInt(midterm),
                            final: parseInt(final),
                        },
                        success: function(result) {
                            $("#myModaltwo").modal('hide');
                            var str = "";
                            console.log(result);
                            if (result.status == 'success') {

                                str +=
                                    `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
                                $("#reg").append(str);
                                setTimeout(() => {
                                    window.location.reload();
                                }, 3000);
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

            })

            $("#assign_marks_store").click(function() {
                var section_name = $('#st').attr('value');
                var student_id = [];
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
                var done = '1';

                $(':checkbox:checked').each(function(i) {
                    student_id[i] = $(this).val();
                });

                var str = ''
                $("#reg").empty();
                if (student_id.length === 0) {
                    alert('Please select at least one student');
                } else if (attendance == '' || class_test == '' || assignment_marks == '' || midterm ==
                    '' || final == '') {
                    alert('Please fill all the fields');
                } else if (attendance > parseInt(attendance_label.split(':')[1])) {
                    alert('Attendance mark is greater than the total mark');
                } else if (class_test > parseInt(class_test_label.split(':')[1])) {
                    alert('Class test mark is greater than the total mark');
                } else if (assignment_marks > parseInt(assignment_mark_label.split(':')[1])) {
                    alert('Assignment mark is greater than the total mark');
                } else if (midterm > parseInt(midterm_label.split(':')[1])) {
                    alert('Midterm mark is greater than the total mark');
                } else if (final > parseInt(final_label.split(':')[1])) {
                    alert('Final mark is greater than the total mark');
                } else {
                    // console.log(student_id[])
                    $.ajax({
                        url: 'http://127.0.0.1:8000/api/store-teacher-assign-marks',
                        type: 'POST',
                        dataType: "json",
                        data: {
                            section_name: section_name,
                            student_id: student_id,
                            attendance: parseInt(attendance),
                            class_test: parseInt(class_test),
                            assignment_marks: parseInt(assignment_marks),
                            midterm: parseInt(midterm),
                            final: parseInt(final),
                            total: parseInt(total),
                            done: parseInt(done),


                        },
                        success: function(result) {
                            $("#myModalone").modal('hide');

                            console.log(result);
                            if (result.status == 'success') {

                                str +=
                                    `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
                                $("#reg").append(str);
                                setTimeout(() => {
                                    window.location.href =
                                        `http://127.0.0.1:8000/teacher-store-assign-mark-list/${section_id}`
                                }, 3000);
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

            })

            // if found course in course list then disable checkbox
            function disableCheckbox() {
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
                                // console.log(data[i].section_name);
                                var student_id = data[i].user_id;

                                function name($student_id) {
                                    var student_id = data[i].student_id;
                                    $.ajax({
                                        url: `http://127.0.0.1:8000/api/show-teacher-enroll-student/${section_id}`,
                                        type: 'GET',
                                        dataType: "json",
                                        success: function(result) {
                                            console.log(result);
                                            if (result.status == 'success') {
                                                var data = result.data;
                                                console.log(data);
                                                var lent = result.data.length;
                                                for (var i = 0; i < lent; i++) {
                                                    // console.log(data[i].id);
                                                    if (data[i].student_id == student_id) {
                                                        //disable checkbox
                                                        $(`input[value=${student_id}]`)
                                                            .attr(
                                                                'disabled', true);
                                                    }

                                                }


                                            } else if (result.status == 'error') {

                                            }
                                        }
                                    });

                                }
                                name();


                            }


                        } else if (result.status == 'error') {

                        }
                    }
                });
            }
            disableCheckbox();

            // mark
            // sessionStorage.setItem('executed', false);
            var markSystem = (function() {
                let data = sessionStorage.getItem('true');
                console.log(data)
                if (data == `${section_id}`) {
                    console.log('already executed');
                } else {
                    var executed = false;
                    return function() {
                        if (!executed) {
                            executed = true;
                            // sessionStorage.setItem('executed', 'true');
                            sessionStorage.setItem('true', `${section_id}`);
                            $.ajax({
                                url: 'http://127.0.0.1:8000/api/teacher-mark-system',
                                type: 'POST',
                                dataType: "json",
                                data: {
                                    section_name: section_id,
                                },
                                success: function(result) {
                                    console.log(result);

                                }
                            });

                        }
                    };
                }

            })();
            markSystem();

            getAllMarks();


            //assign mark
            // $('#assign_mark').click(function() {
            //     var section_id = $('#st').attr('value');

            // })

            //disable checkbox




        });
    </script>
@endsection
