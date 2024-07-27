<footer class="footer footer-2">
    <div class="container">
        <hr class="mb-0">
    </div>
    <div class="icon-boxes-container bg-transparent">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-rocket"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 style="font-family: Be VietNam" class="icon-box-title">Free ship</h3><!-- End .icon-box-title -->
                            <p style="font-family: Be VietNam">đơn hàng 1.5 Triệu</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-sm-6 col-lg-3 -->
                
                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-rotate-left"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 style="font-family: Be VietNam" class="icon-box-title">Đổi trả hàng</h3><!-- End .icon-box-title -->
                            <p style="font-family: Be VietNam">trong vòng 7 ngày</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-info-circle"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 style="font-family: Be VietNam" class="icon-box-title">Bảo hành</h3><!-- End .icon-box-title -->
                            <p style="font-family: Be VietNam">trong vòng 06 tháng</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-sm-6 col-lg-3 -->

                <div class="col-sm-6 col-lg-3">
                    <div class="icon-box icon-box-side">
                        <span class="icon-box-icon text-primary">
                            <i class="icon-life-ring"></i>
                        </span>

                        <div class="icon-box-content">
                            <h3 style="font-family: Be VietNam" class="icon-box-title">Hỗ trợ</h3><!-- End .icon-box-title -->
                            <p>24/7</p>
                        </div><!-- End .icon-box-content -->
                    </div><!-- End .icon-box -->
                </div><!-- End .col-sm-6 col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .icon-boxes-container -->

    <div class="footer-newsletter bg-image" style="background-image: url(/frontend/assets/images/demos/demo-10/bg-5.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-8 col-lg-6">
                    <div class="cta-heading text-center">
                        <h3 style="font-family: Be VietNam" class="cta-title text-white">Đăng ký bản tin</h3><!-- End .cta-title -->
                        <p style="font-family: Be VietNam" class="cta-desc text-white">Thông tin mới từ Molla cũng như các chương trình khuyến mãi hấp dẫn</p><!-- End .cta-desc -->
                    </div><!-- End .text-center -->
                    <form id="sign_up_">
                        <div class="input-group input-group-round">
                            <input id="email_sign_up" type="email" class="form-control form-control-white" placeholder="Vui lòng nhập email của bạn" aria-label="Email Adress" required>
                            <div class="input-group-append">
                                <button class="btn btn-white" type="submit"><span>Đăng ký</span><i class="icon-long-arrow-right"></i></button>
                            </div><!-- .End .input-group-append -->
                        </div><!-- .End .input-group -->
                    </form>
                </div><!-- End .col-sm-10 col-md-8 col-lg-6 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .cta -->
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="widget widget-about">
                        <a href="{{route('home.index')}}"><img src="{{asset('frontend/assets/images/demos/demo-10/logo-footer.png')}}" class="footer-logo" alt="Footer Logo" width="105" height="25"></a>
                        <a style="font-size: 1.7rem;font-family: Open Sans" href="#" onClick="return false;">Ngô Quốc Khánh</a><br>
                        <a style="font-size: 1.7rem;font-family: Open Sans" href="#" onClick="return false;">Sđt: 076 4211 220</a><br>
                        <a style="font-size: 1.7rem;font-family: Open Sans" href="#" onClick="return false;">Email: Kngoquoc223@gmail.com</a><br>
                        <a style="font-size: 1.7rem;font-family: Open Sans" href="{{route('home.contact.index')}}">Liên hệ</a><br>
                        <br>
                        <div class="social-icons">
                            <a href="#" onClick="return false;" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                            <a href="#" onClick="return false;" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                            <a href="#" onClick="return false;" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                            <a href="#" onClick="return false;" class="social-icon" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                            <a href="#" onClick="return false;" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                        </div><!-- End .soial-icons -->
                    </div><!-- End .widget about-widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->
                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 style="font-size: 2rem;font-family: Open Sans" class="widget-title">Bài Viết</h4><!-- End .widget-title -->
                        <ul class="widget-list">
                            @if(@isset($category_posts) && !empty($category_posts))
                            @foreach ($category_posts as $category)
                            <li><a style="font-size: 1.7rem;font-family: Open Sans" href="{{route('home.category.posts.index',$category->slug)}}">{{$category->name}}</a></li>
                            @endforeach
                            @endif
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->
                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 style="font-size: 2rem;font-family: Open Sans" class="widget-title">Sản phẩm</h4><!-- End .widget-title -->
                        <ul class="widget-list">
                            @if(@isset($category_products) && !empty($category_products))
                            @foreach ($category_products as $category)
                            <li><a style="font-size: 1.7rem;font-family: Open Sans" href="{{route('home.category.index',$category->slug)}}">{{$category->name}}</a></li>
                            @endforeach
                            @endif
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->
                <div class="col-sm-6 col-lg-3">
                    <div class="widget">
                        <h4 style="font-size: 2rem;font-family: Open Sans" class="widget-title">Tài khoản</h4><!-- End .widget-title -->

                        <ul class="widget-list">
                            <li><a style="font-size: 1.7rem;font-family: Open Sans" href="{{route('home.user.showForm')}}">Đăng nhập</a></li>
                            <li><a style="font-size: 1.7rem;font-family: Open Sans" href="{{route('home.user.myUser')}}">Thông tin tài khoản</a></li>
                        </ul><!-- End .widget-list -->
                    </div><!-- End .widget -->
                </div><!-- End .col-sm-6 col-lg-3 -->


            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .footer-middle -->

    <div class="footer-bottom">
        <div class="container">
            <p class="footer-copyright">Copyright © 2019 Molla Store. All Rights Reserved.</p><!-- End .footer-copyright -->
            <figure class="footer-payments">
                <img src="{{asset('frontend/assets/images/payments.png')}}" alt="Payment methods" width="272" height="20">
            </figure><!-- End .footer-payments -->
        </div><!-- End .container -->
    </div><!-- End .footer-bottom -->
</footer><!-- End .footer -->