@extends('student.layouts.default')
@section('contents')
    <div class="container-fluid">

        <!-- Page Heading -->
        {{-- <h1 class="h3 mb-2 text-gray-800">Section List</h1> --}}
        <p class="mb-4"></a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4 m-5">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Select Session</h6>
            </div>
            <div class="card o-hidden border-0 shadow-lg my-3">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row d-flex justify-content-center">
                        {{-- <div class="col-lg-6 d-none d-lg-block bg-password-image"></div> --}}
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-5">Select Session</h1>
                                    <div id="reg">

                                    </div>

                                </div>
                                <form class="user">
                                    <div class="form-group">
                                        <select class="form-select form-control-user py-3 w-100 px-3" name="session_name"
                                            id="session_name">

                                        </select>
                                    </div>
                                    <div id="course_submit"></div>
                                    {{-- <a id="submit" class="btn btn-primary btn-user btn-block mt-5">
                                        Select
                                    </a> --}}
                                </form>
                            </div>
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
            getAllSessions();
            //get all sessions
            function getAllSessions() {
                var str = ""
                $.ajax({
                    url: 'http://127.0.0.1:8000/api/show-student-session',
                    type: 'GET',
                    dataType: "json",
                    success: function(result) {
                        console.log(result);
                        if (result.status == 'success') {
                            var data = result.data;
                            console.log(data);
                            var str = '<option selected>Selected Session</option>';
                            var lent = result.data.length;
                            for (var i = 0; i < lent; i++) {
                                console.log(data[i].id);
                                str +=
                                    `<option value="${data[i].id}">${data[i].session_name}</option>`
                            }
                            $("#session_name").append(str);

                        } else if (result.status == 'error') {
                            str +=
                                `<option>${result.message}</option>`;
                            $("#session_name").append(str);
                        }
                    }
                });
            }

            //select onchange
            $("#session_name").change(function() {
                var session_id = $(this).val();
                console.log(session_id);
                $("#course_submit").empty();
                // ("#submit").attr("href", "{{ url('student-course-list') }}" + '/' + session_id);
                $("#course_submit").append(
                    $("<a></a>").attr("href", "{{ url('student-course-list') }}/" + session_id).attr(
                        "class",
                        "btn btn-primary btn-user btn-block mt-5").text("Select")
                )
            });

            //select session
            // specific teacher info
            // $("#submit").click(function() {

            //     sessionStorage.setItem("session_name", $("#session_name").val());
            // })
        });
    </script>
@endsection
