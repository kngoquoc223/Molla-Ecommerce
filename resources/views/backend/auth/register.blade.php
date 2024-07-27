<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('backend/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image" style="background: url('https://images.unsplash.com/photo-1515965885361-f1e0095517ea?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=3300&q=80'); background-size: cover; background-position: center center;"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Đăng ký</h1>
                            </div>
                            <form class="user" method="post" action="{{route('register')}}">
                                @if(Session::has('Success'))
                                <div class="alert alert-success">{{session::get('Success')}}</div>
                                @endif
                                @if(session::has('Fail'))
                                <div class="alert alert-danger">{{session::get('Fail')}}</div>
                                @endif
                                @csrf
                                <div class="form-group">
                                    <input name="name" type="text" class="form-control form-control-user" 
                                        placeholder="Tên người dùng" value="{{ old('name') }}">
                                        <span class="text-danger">@error('name')  {{$message}} @enderror </span>
                                </div>
                                <div class="form-group">
                                        <input name="phone" type="text" class="form-control form-control-user" 
                                            placeholder="Số điện thoại" value="{{ old('phone') }}">
                                        <span class="text-danger">@error('phone')  {{$message}} @enderror </span>
                                </div>
                                <div class="form-group">
                                    <input name="email" type="text" class="form-control form-control-user" 
                                        placeholder="Email" value="{{ old('email') }}">
                                        <span class="text-danger">@error('email')  {{$message}} @enderror </span>
                                </div>
                                <div class="form-group ">
                                    <input name="password" type="password" class="form-control form-control-user showPassword" 
                                        placeholder="Mật khẩu">
                                        <span class="text-danger">@error('password')  {{$message}} @enderror </span>
                                </div>
                                <div class="form-group ">
                                    <input name="re_password" type="password" class="form-control form-control-user showPassword"
                                        placeholder="Nhập Lại Mật khẩu">
                                        <span class="text-danger">@error('re_password')  {{$message}} @enderror </span>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck" onclick="myFunction()">
                                        <label class="custom-control-label" for="customCheck">Hiển thị mật khẩu</label>
                                    </div>
                                </div>
                                <script>
                                    function myFunction() {
                                        var x = document.getElementsByClassName("showPassword");
                                        for (var i = 0; i < x.length; i++) {
                                        if (x[i].type === "password") {
                                            x[i].type = "text";
                                        } else {
                                            x[i].type = "password";
                                        }
                                        }
                                        }
                                </script>
                                <button type="submit" class="btn btn-primary btn-user btn-block"> Đăng ký </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{route('show-from-login')}}">Bạn đã có tài khoản? Đăng nhập</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('backend/js/sb-admin-2.min.js')}}"></script>

</body>

</html>