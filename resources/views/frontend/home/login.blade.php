<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Open Sans" href="{{route('home.index')}}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a style="font-family: Open Sans" href="{{route('home.user.showForm')}}">Đăng nhập / đăng ký</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('/frontend/assets/images/backgrounds/login-bg.jpg')">
        <div class="container">
            <div class="form-box">
                <div class="form-tab">
                    <ul class="nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item">
                            <a style="font-family: Open Sans" class="nav-link" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="false">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a style="font-family: Open Sans" class="nav-link active" id="register-tab-2" data-toggle="tab" href="#register-2" role="tab" aria-controls="register-2" aria-selected="true">Đăng ký</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
                            <form action="{{route('home.user.login')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label style="font-family: Open Sans" for="singin-email-2">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div><!-- End .form-group -->
                                <div class="form-group">
                                    <label style="font-family: Open Sans" for="singin-password-2">Mật khẩu</label>
                                    <input type="password" class="form-control showPassword1" name="password" required>
                                </div><!-- End .form-group -->
                                <div class="custom-control custom-checkbox">
                                    <input onclick="showPassword1()" type="checkbox" class="custom-control-input" id="show-password1">
                                    <label style="font-family: Open Sans" class="custom-control-label" for="show-password1">Hiển thị mật khẩu</label>
                                </div><!-- End .custom-checkbox -->
                                <script>
                                    function showPassword1() {
                                        var x = document.getElementsByClassName("showPassword1");
                                        for (var i = 0; i < x.length; i++) {
                                        if (x[i].type === "password") {
                                            x[i].type = "text";
                                        } else {
                                            x[i].type = "password";
                                        }
                                        }
                                        }
                                </script>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span style="font-family: Open Sans">Đăng nhập</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </div><!-- End .form-footer -->
                            </form>
                        </div><!-- .End .tab-pane -->
                        <div class="tab-pane fade show active" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
                            <form action="{{route('home.user.register')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label style="font-family: Open Sans">Họ và tên</label>
                                    <input value="{{old('name')}}" type="text" class="form-control" name="name">
                                    @if ($errors->has('name'))
                                    <p style="font-family: Open Sans" class="text-danger">{{ $errors->first('name') }}</p>
                                    @endif
                                </div><!-- End .form-group -->

                                <div class="form-group">
                                    <label style="font-family: Open Sans" for="register-password-2">Email</label>
                                    <input value="{{old('email')}}" type="email" class="form-control" name="email">
                                    @if ($errors->has('email'))
                                    <p style="font-family: Open Sans" class="text-danger">{{ $errors->first('email') }}</p>
                                    @endif
                                </div><!-- End .form-group -->

                                <div class="form-group">
                                    <label style="font-family: Open Sans" for="register-password-2">Mật khẩu</label>
                                    <input value="{{old('password')}}" type="password" class="form-control showPassword2" name="password">
                                    @if ($errors->has('password'))
                                    <p style="font-family: Open Sans" class="text-danger">{{ $errors->first('password') }}</p>
                                    @endif
                                </div><!-- End .form-group -->
                                <div class="form-group">
                                    <label style="font-family: Open Sans" for="register-password-2">Nhập lại mật khẩu</label>
                                    <input value="{{old('re_password')}}" type="password" class="form-control showPassword2" name="re_password">
                                    @if ($errors->has('re_password'))
                                    <p style="font-family: Open Sans" class="text-danger">{{ $errors->first('re_password') }}</p>
                                    @endif
                                </div><!-- End .form-group -->
                                <div class="custom-control custom-checkbox">
                                    <input onclick="myFunction()" type="checkbox" class="custom-control-input" id="show-password2">
                                    <label style="font-family: Open Sans" class="custom-control-label" for="show-password2">Hiển thị mật khẩu</label>
                                </div><!-- End .custom-checkbox -->
                                <script>
                                    function myFunction() {
                                        var x = document.getElementsByClassName("showPassword2");
                                        for (var i = 0; i < x.length; i++) {
                                        if (x[i].type === "password") {
                                            x[i].type = "text";
                                        } else {
                                            x[i].type = "password";
                                        }
                                        }
                                        }
                                </script>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span style="font-family: Open Sans">Đăng ký</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </div><!-- End .form-footer -->
                            </form>
                        </div><!-- .End .tab-pane -->
                    </div><!-- End .tab-content -->
                </div><!-- End .form-tab -->
            </div><!-- End .form-box -->
        </div><!-- End .container -->
    </div><!-- End .login-page section-bg -->
</main><!-- End .main -->