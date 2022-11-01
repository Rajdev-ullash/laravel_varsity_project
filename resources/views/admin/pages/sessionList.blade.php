@extends('admin.layouts.default')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Session List</h1>
        <p class="mb-4"></a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">List of Sessions</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Session Name</th>
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
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                console.log(data[i].id);
                                str += `<tr>
                                <td>${data[i].id}</td>
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
                                            <h4 class="modal-title">Update Sessions</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="user">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control form-control-user" id="session_name"
                                                                placeholder="Enter Session Name">
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
                                            Are you sure to delete <b>${data[i].session_name}</b> account?
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

            //specific session information
            $(document).on('click', '#edit', function() {
                var id = $(this).attr('value');
                console.log(id);
                $.ajax({
                    url: `http://127.0.0.1:8000/api/show-session-edit/${id}`,
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data;
                            console.log(data);
                            $("#session_name").val(data.session_name);
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

            //update session information
            $(document).on('click', '#update', function() {
                var id = $(this).attr('value');
                var session_name = $("#session_name").val();
                console.log(id);
                $.ajax({
                    url: `http://127.0.0.1:8000/api/session-update/${id}`,
                    type: 'POST',
                    dataType: "json",
                    data: {
                        session_name: session_name,
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
                            }, 5000);
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

            // Delete sessions
            $(document).on('click', '#submit', function() {
                var id = $(this).attr('value');
                $.ajax({
                    url: `http://127.0.0.1:8000/api/session-list-delete/${id}`,
                    type: 'POST',
                    dataType: "json",
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
                            }, 5000);
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
