<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('users/login.css') }}">

    <title>Document</title>
</head>

<body>
    <section class="vh-100 bgColor">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5 ">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 mt-5">
                    <h5>Student Registration</h5>
                    <div id="reg">

                    </div>
                    <form class="mt-3">
                        <div class="form-outline mb-2">
                            <label class="form-label" for="form3Example3">Name</label>
                            <input type="text" id="name" class="form-control form-control-lg"
                                placeholder="Enter your name" />
                        </div>
                        <div class="form-outline mb-2">
                            <label class="form-label" for="form3Example3">ID</label>
                            <input type="number" id="uid" class="form-control form-control-lg"
                                placeholder="Enter your ID" />
                        </div>
                        <!-- Email input -->
                        <div class="form-outline mb-2">
                            <label class="form-label" for="">Email address</label>
                            <input type="email" id="email" class="form-control form-control-lg"
                                placeholder="Enter a valid email address" />

                        </div>

                        <div class="form-outline mb-2">
                            <label class="form-label" for="">Password</label>
                            <input type="password" id="password" class="form-control form-control-lg"
                                placeholder="Enter password" />
                        </div>
                        <div class="form-outline">
                            <label class="form-label" for="">Confirm Password</label>
                            <input type="password" id="confirmPassword" class="form-control form-control-lg"
                                placeholder="Enter your confirm password" />
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="button" id="submit" class="btn d-grid gap-2 col-12 btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Registration</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a
                                    href="{{ url('/student-login') }}" class="link-danger">Login</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#submit').click(function() {
                var name = $('#name').val();
                var uid = $('#uid').val();
                var email = $('#email').val();
                var role = 'student';
                var password = $('#password').val();
                var confirmPassword = $('#confirmPassword').val();
                var str = ''
                $("#reg").empty();
                if (name == '' || uid == '' || email == '' || role == '' || password == '' ||
                    confirmPassword == '') {
                    alert('Please fill all fields');
                } else if (password != confirmPassword) {
                    alert('Password not match');
                } else {
                    // $("#reg").hide();
                    $.ajax({
                        url: 'http://127.0.0.1:8000/api/store-user',
                        method: "POST",
                        data: {
                            name: name,
                            uid: uid,
                            email: email,
                            role: role,
                            password: password,
                        },
                        success: function(result) {
                            if (result.status == 'success') {
                                str +=
                                    `<div class="alert alert-success" role="alert" id="reg"><strong>Account Created Successfully. Please Wait for admin approvel. </strong></div>`;
                                $("#reg").append(str);
                                // $("#submit").reset();
                                // alert('Registration success');
                                // window.location.href = "{{ url('/login') }}";
                            } else {
                                str +=
                                    `<div class="alert alert-success" role="alert" id="reg"><strong>Account Not Created</strong></div>`;
                                $("#reg").append(str);
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
