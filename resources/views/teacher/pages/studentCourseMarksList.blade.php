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
                <h6 class="m-0 font-weight-bold text-primary">List of Marks</h6>
            </div>
            <div class="d-flex ml-auto me-2">



            </div>
            <div class="card-body">
                <div id="reg">

                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead id="table_head">

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
            getAllStudentMarks()

            function getAllStudentMarks() {

                var str = ""
                var str1 = ""
                var str2 = ""
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-teacher-assign-mark-student-list/${section_id}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data;
                            var title = data[0].marks_title;
                            console.log(title);
                            var parse = JSON.parse(title);
                            //table head with name and title
                            str += `<tr><th>Student Id</th><th>Name</th>`
                            console.log(parse);
                            for (var i = 0; i < parse.length; i++) {
                                str += `<th>${parse[i]}</th>`
                            }
                            str += `<th>Total</th><th>Action</th></tr>`
                            // console.log(data);
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                var student_uid = data[i].user_uid;
                                var student_id = data[i].user_id;
                                var student_name = data[i].user_name;
                                var student_marks = data[i].given_marks;
                                var assign_marks = data[i].assign_marks;
                                var total = data[i].total;
                                var parse = JSON.parse(student_marks);
                                console.log(parse);
                                str1 += `<tr><td>${student_uid}</td><td>${student_name}</td>`
                                for (var j = 0; j < parse.length; j++) {
                                    //show student  student_marks / assign_marks
                                    //json.parse(assign_marks)
                                    var assign = JSON.parse(assign_marks);
                                    str1 += `<td>${parse[j]} / ${assign[j]}</td>`
                                    // str1 += `<td>${parse[j]}</td>`
                                }
                                str1 +=
                                    `<td>${total}</td><td><button id="edit_marks" value="${student_id}" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#myModalone${student_id}">Edit</button>

                                    <div class="modal" id="myModalone${student_id}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Assign Marks Update</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="user" id="form_update">
                                                                
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            <button id="course_marks_update" value="" class="btn btn-success">Update</button>
                                                        </div>

                                                    </div>
                                                </div>
                                </div></td></tr>`





                            }
                            $("#table_head").append(str);

                            $("#t_data").append(str1);


                        } else if (result.status == 'error') {
                            str +=
                                `<tr><td colspan="8" class="text-center">${result.message}</td></tr>`;
                            $("#t_data").append(str);
                        }
                    }
                });
            }

            $(document).on('click', '#edit_marks', function() {
                var student_id = $(this).val();
                console.log(student_id);
                var str = ""
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-teacher-assign-mark-specific-student/${student_id}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data;
                            var title = data.marks_title;
                            var assign_marks = data.assign_marks;
                            var student_marks = data.given_marks;
                            var parse = JSON.parse(title);
                            var assign = JSON.parse(assign_marks);
                            var parse1 = JSON.parse(student_marks);
                            console.log(parse);
                            console.log(assign);
                            console.log(parse1);
                            for (var i = 0; i < parse.length; i++) {
                                str += `<div class="form-group">
                                            <label class="control-label">${parse[i]} : ${assign[i]}</label>
                                            <input type="number" class="form-control" name="marks[]" value="${parse1[i]}">
                                            <input type="hidden" class="form-control" name="marks_title[]" value="${parse[i]}">
                                            <input type="hidden" class="form-control" name="assign_marks[]" value="${assign[i]}">
                                        </div>`
                            }
                            $("#form_update").append(str);
                            $("#course_marks_update").val(student_id);
                        } else if (result.status == 'error') {
                            str +=
                                `<tr><td colspan="8" class="text-center">${result.message}</td></tr>`;
                            $("#t_data").append(str);
                        }
                    }
                })
            })

            //course marks update
            $(document).on('click', '#course_marks_update', function() {
                var student_id = $(this).val();
                var section_id = $('#st').attr('value');
                console.log(student_id);
                var assign_marks = [];
                var marks_title = [];
                var student_marks = [];

                //marks title
                var marks_title = $("input[name='marks_title[]']")
                    .map(function() {
                        return $(this).val();
                    }).get();
                console.log(marks_title);
                var assign_marks = $("input[name='assign_marks[]']")
                    .map(function() {
                        return $(this).val();
                    }).get();
                var student_marks = $("input[name='marks[]']")
                    .map(function() {
                        return $(this).val();
                    }).get();

                console.log(assign_marks);
                console.log(student_marks);

                //check if  given marks is greater than assign marks or not
                for (var i = 0; i < student_marks.length; i++) {

                    if (parseInt(student_marks[i]) > parseInt(assign_marks[i])) {
                        alert(
                            `Given marks ${student_marks[i]} is greater than ${assign_marks[i]} assign marks`
                        );
                        return false;
                    }
                }

                //sum of all student marks
                var sum = 0;
                for (var i = 0; i < student_marks.length; i++) {
                    sum += parseInt(student_marks[i]);
                }
                if (student_marks.length == 0) {
                    alert('Please enter marks');
                    return false;
                } else if (student_marks.length != assign_marks.length) {
                    alert('Please enter marks');
                    return false;
                } else {
                    $.ajax({
                        url: `http://127.0.0.1:8000/api/show-teacher-assign-mark-specific-student-update/${student_id}`,
                        type: 'POST',
                        dataType: "json",
                        data: {
                            marks_title: marks_title,
                            assign_marks: assign_marks,
                            given_marks: student_marks,
                            total: sum,
                            section_name: section_id
                        },
                        success: function(result) {
                            console.log(result);
                            if (result.status == 'success') {
                                alert(result.message);
                                location.reload();
                            } else if (result.status == 'error') {
                                alert(result.message);
                            }

                        }
                    })
                }

            })





        });
    </script>
@endsection
