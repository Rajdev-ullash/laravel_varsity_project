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
                <div class="col-md-9 col-lg-6 col-xl-5 merge">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 merge">
                    <h5>Admin Login</h5>
                    <div id="reg">

                    </div>
                    <form class="mt-3">
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="">Email address</label>
                            <input type="email" id="email" class="form-control form-control-lg"
                                placeholder="Enter a valid email address" />

                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label" for="">Password</label>
                            <input type="password" id="password" class="form-control form-control-lg"
                                placeholder="Enter password" />

                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">

                            </div>
                            <a href="#!" class="text-body">Forgot password?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="button" id="submit" class="btn d-grid gap-2 col-12 btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
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

                var email = $('#email').val();
                console.log(email);

                var password = $('#password').val();
                console.log(password);
                var str = ''
                $("#reg").empty();
                if (email == '' || password == '') {
                    alert('Please fill all fields');
                } else {

                    $.ajax({
                        url: 'http://127.0.0.1:8000/api/store-admin',
                        type: 'POST',
                        dataType: "json",
                        data: {
                            email: email,
                            password: password,
                        },
                        success: function(result) {
                            console.log(result);
                            if (result.status == 'success') {
                                str +=
                                    `<div class="alert alert-success" role="alert" id="reg"><strong>${result.message}</strong></div>`;
                                $("#reg").append(str);
                                setTimeout(() => {
                                    window.location.href =
                                        "http://127.0.0.1:8000/admin-home"
                                }, 1000);
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
</body>

</html>
