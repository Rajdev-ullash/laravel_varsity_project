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
                <h6 class="m-0 font-weight-bold text-primary">List of Assign Marks</h6>
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

            getAllCourseMarksStudent();
            // get all courses

            function getAllCourseMarksStudent() {

                var str = ""
                var str1 = ""
                var str2 = ""
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-teacher-assign-course-specific-mark/${section_id}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data

                            console.log(data);
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                //table headers
                                var header = data[i].marks_title;
                                str += `<th>${header}</th>`
                                //table data
                                var data1 = data[i].marks;
                                str1 += `<td>${data1}</td>`
                                //edit button
                                // var edit = data[i].id;


                            }
                            $("#table_head").append(str);
                            var str3 = ""
                            str3 += `<th>Actions</th>`
                            $("#table_head").append(str3);
                            $("#t_data").append(str1);
                            str2 +=
                                `<td><button id="edit_marks" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#myModalone">Edit</button>
                                    <button id="delete_marks" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#myModaltwo">Delete</button>        

                                    <div class="modal" id="myModalone">
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
                                </div>
                                <div class="modal" id="myModaltwo">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Assign Marks Update</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Ares you sure to delete this marks?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            <button id="course_marks_delete" value="" class="btn btn-danger">Delete</button>
                                                        </div>

                                                    </div>
                                                </div>
                                </div>
                                
                                </td>`
                            $("#t_data").append(str2);


                        } else if (result.status == 'error') {
                            str +=
                                `<tr><td colspan="8" class="text-center">${result.message}</td></tr>`;
                            $("#t_data").append(str);
                        }
                    }
                });
            }
            // edit student marks
            $(document).on('click', '#edit_marks', function() {
                var str = ""
                var str1 = ""
                var str2 = ""
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-teacher-assign-course-specific-mark/${section_id}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {

                            var data = result.data
                            console.log(data);
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                var header = data[i].marks_title;

                                var data1 = data[i].marks;
                                var data2 = data[i].id;

                                //dynamic label & input fields
                                str += `<div class="row">
                                                <div class="col-md-5 mb-3">
                                                    <label for="marks_title">Mark Tittle</label>
                                                    <input type="text" class="form-control" id="marks_title[]" value="${header}"
                                                        name="marks_title[]" placeholder="Marks Tittle" required />
                                                </div>
                                                <div class="col-md-0">
                                                    <input type="hidden" class="form-control" id="marks_id[]" value="${data2}"
                                                        name="marks_id[]" placeholder="Marks Tittle" required />
                                                </div>
                                                <div class="col-md-5 mb-3">
                                                    <label for="marks_number">Mark</label>
                                                    <input type="number" class="form-control" id="marks_number[]"
                                                        name="marks_number[]" placeholder="Marks" minlength="0" value="${data1}"
                                                        required />
                                                </div>
                    

                                            </div>`


                            }
                            $("#form_update").append(str);



                        } else if (result.status == 'error') {
                            str +=
                                `<tr><td colspan="8" class="text-center">${result.message}</td></tr>`;
                            $("#t_data").append(str);
                        }
                    }
                });
            })

            //update course marks
            $(document).on('click', '#course_marks_update', function(e) {
                e.preventDefault();
                var marks_title = [];
                var marks_number = [];
                var marks_id = [];
                var section_id = $('#st').attr('value');
                var marks_title = $("input[name='marks_title[]']").map(function() {
                    return $(this).val();
                }).get();
                //marks_id as integer
                var marks_id = $("input[name='marks_id[]']").map(function() {
                    return parseInt($(this).val());
                }).get();
                var marks_number = $("input[name='marks_number[]']").map(function() {
                    return $(this).val();
                }).get();
                console.log(marks_title);
                console.log(marks_number);
                console.log(section_id);
                var marks_all = marks_number.reduce((a, b) => a += parseInt(b), Number(0));
                console.log(marks_all);

                if (marks_title.length == 0 || marks_number.length == 0) {
                    Toastify({
                        text: "Please fill up the form",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                        stopOnFocus: true,
                        onClick: function() {}
                    }).showToast();
                } else if (marks_title.length != marks_number.length) {
                    Toastify({
                        text: "Please fill up the form",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                        stopOnFocus: true,
                    }).showToast();
                }
                //mark number total out of 100 then error
                else if (marks_all > 100) {
                    Toastify({
                        text: "Total Marks out of 100",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                        stopOnFocus: true,
                    }).showToast();
                } else {
                    $.ajax({
                        url: `http://127.0.0.1:8000/api/show-teacher-assign-course-specific-mark-update/${section_id}`,
                        type: "POST",
                        data: {
                            marks_title: marks_title,
                            marks_number: marks_number,
                            marks_id: marks_id,

                        },
                        success: function(data) {
                            console.log(data);
                            if (data.status == 'success') {
                                Toastify({
                                    text: "Marks Updated Successfully",
                                    duration: 3000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                    stopOnFocus: true,
                                }).showToast();
                                $("#myModalone").modal('hide');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2000);

                            } else {
                                Toastify({
                                    text: "Marks Not Assigned",
                                    duration: 3000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                    stopOnFocus: true,
                                }).showToast();
                            }
                        }


                    })
                }
            })

            //delete course marks
            $(document).on('click', '#course_marks_delete', function(e) {
                e.preventDefault();
                var section_id = $('#st').attr('value');

                $.ajax({
                    url: `http://127.0.0.1:8000/api/delete-store-teacher-mark/${section_id}`,
                    type: "POST",
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'success') {
                            Toastify({
                                text: "Marks Deleted Successfully",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                stopOnFocus: true,
                            }).showToast();
                            $("#myModaltwo").modal('hide');
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);

                        } else {
                            Toastify({
                                text: "Marks Not Assigned",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                                stopOnFocus: true,
                            }).showToast();
                        }
                    }


                })

            })





        });
    </script>
@endsection
