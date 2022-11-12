@extends('admin.layouts.default')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Create Semester</h1>
        <p class="mb-2"></a>.</p>

        <div class="card o-hidden border-0 shadow-lg my-3">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row d-flex justify-content-center">
                    {{-- <div class="col-lg-6 d-none d-lg-block bg-password-image"></div> --}}
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-5">Create Semester</h1>
                                <div id="reg">

                                </div>

                            </div>
                            <form class="user">
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user" id="semester_name"
                                        placeholder="Enter Semester Name...">
                                </div>
                                <a href="#" id="submit" class="btn btn-primary btn-user btn-block">
                                    Create Semester
                                </a>
                            </form>
                        </div>
                    </div>
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
            $('#submit').click(function() {

                var semester_name = $('#semester_name').val();
                console.log(semester_name);
                var str = ''
                $("#reg").empty();
                if (semester_name == '') {
                    alert('Please fill all fields');
                } else {

                    $.ajax({
                        url: 'http://127.0.0.1:8000/api/store-semester',
                        type: 'POST',
                        dataType: "json",
                        data: {
                            semester_name: semester_name,
                        },
                        success: function(result) {
                            console.log(result);
                            if (result.status == 'success') {
                                str +=
                                    `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
                                $("#reg").append(str);
                                setTimeout(() => {
                                    window.location.href =
                                        "http://127.0.0.1:8000/admin-semester-list"
                                }, 1000);
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
            });


        });
    </script>
@endsection
