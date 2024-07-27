<!DOCTYPE html>
<html lang="en">
<!-- molla/index-10.html  22 Nov 2019 09:58:04 GMT -->
@include('frontend.home.component.head')

<body>
    <div class="page-wrapper">
        @if ($template != 'frontend.home.checkout')
            <header class="header header-2 header-intro-clearance">
                <div class="header-top">
                    <div class="container">
                        <div class="header-left">
                            <div class="header-dropdown">
                                <a style="font-family: Open Sans" href="#" onClick="return false;">Tiếng Việt</a>
                                <div class="header-menu">
                                    <ul>
                                        <li><a style="font-family: Open Sans" href="#" onClick="return false;">Tiếng
                                                Việt</a></li>
                                    </ul>
                                </div><!-- End .header-menu -->
                            </div>
                        </div><!-- End .header-left -->
                        <div class="header-right">
                            <ul class="top-menu">
                                <li>
                                    <a style="font-family: Open Sans" href="#" onClick="return false;">Đăng nhập</a>
                                    <ul>
                                        <li><a style="font-family: Open Sans" href="{{route('show-dashboard')}}"><i class="icon-user"></i>Admin</a></li>
                                        <li><a style="font-family: Open Sans" href="#" onClick="return false;"><i class="icon-phone"></i>Call: 076 4211 220</a></li>                                       
                                        <li>
                                            <a style="font-family: Open Sans"
                                                href="{{ route('home.showFormCheckOrder') }}">Kiểm Tra Đơn Hàng</a>
                                        </li>
                                        @php
                                            if (Session::get('customer') == true) {
                                                echo '<li><a style="font-family: Open Sans" href="' .
                                                    route('home.user.logout') .
                                                    '">Đăng xuất</a></li>';
                                            }else{
                                                echo '<li><a style="font-family: Open Sans" href="' .
                                                    route('home.user.showForm') .
                                                    '">Đăng nhập</a></li>';
                                            }
                                        @endphp
                                    </ul>
                                </li>
                            </ul><!-- End .top-menu -->
                        </div><!-- End .header-right -->

                    </div><!-- End .container -->
                </div><!-- End .header-top -->
                @include('frontend.home.component.nav')
            </header><!-- End .header -->
        @endif
        @include($template)
        <div class="modal fade" id="quick_view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div style="border-bottom: none;" class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="quickView-content">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="product-left product_quickview_gallery">
                                    </div>
                                    <div id="product_quickview_slide" class="product-right">
                                        <div class="owl-carousel owl-theme owl-nav-inside owl-light mb-0"
                                            data-toggle="owl"
                                            data-owl-options='{
                                        "dots": false,
                                        "nav": false, 
                                        "URLhashListener": true,
                                        "responsive": {
                                            "900": {
                                                "nav": true,
                                                "dots": true
                                            }
                                        }
                                    }'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="product-details">
                                    <h1 id="product_quickview_title" style="font-family: Be VietNam"
                                        class="product-title"></h1><!-- End .product-title -->
                                    <div class="ratings-container">
                                        <div class="ratings">
                                            <div id="product_quickvie_ratings-val" class="ratings-val"
                                                style="width: 80%;"></div><!-- End .ratings-val -->
                                            <a class="ratings-text" href="#" onClick="return false;"
                                                id="product_quickvie_review-link"></a>
                                        </div><!-- End .ratings -->
                                    </div><!-- End .rating-container -->
                                    <a style="font-family: Be VietNam" class="ratings-text" id="">Tình
                                        trạng:<span class="text-success quantity"></span></a>
                                    <div id="product_quickview_price" class="product-price">
                                    </div><!-- End .product-price -->
                                    <a type="button" style="font-family: Be VietNam" class="size-guide" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="icon-th-list"></i>(Cách chọn size)</a>
                                    <div class="details-filter-row details-row-size">
                                        <label style="font-family: Be VietNam" for="size">Size:</label>
                                        <div id="product_quickview_size" class="product-size">
                                        </div><!-- End .select-custom -->
                                    </div><!-- End .details-filter-row -->
                                    <div class="details-filter-row details-row-size">
                                        <div class="product-details-quantity">
                                            <input type="number" id="qty" class="form-control" value="1"
                                                min="1" max="10" step="1" data-decimals="0"
                                                required></span>
                                        </div><!-- End .product-details-quantity -->
                                    </div><!-- End .details-filter-row -->
                                    <span id="product_quickview_input">
                                    </span>
                                    <div class="product-details-action">
                                        <span id="product_quickview_btn-cart"><a href="#" onClick="return false;"
                                                data-id_product="" style="font-family: Be VietNam"
                                                class="btn-product btn-cart"><span>Thêm Giỏ Hàng</span></a></span>
                                        <span id="product_quickview_btn-wishlist"><a style="font-family: Be VietNam"
                                                href="#" onClick="return false;"
                                                class="btn-product btn-wishlist-quickview" title="Wishlist"><span>Thêm
                                                    Danh Sách Yêu Thích</span></a></span>
                                    </div><!-- End .product-details-action -->

                                    <div class="product-details-footer">
                                        <div class="social-icons social-icons-sm">
                                            <span class="social-label">Share:</span>
                                            <a href="#" onClick="return false;" class="social-icon" title="Facebook" target="_blank"><i
                                                    class="icon-facebook-f"></i></a>
                                            <a href="#" onClick="return false;" class="social-icon" title="Twitter" target="_blank"><i
                                                    class="icon-twitter"></i></a>
                                            <a href="#" onClick="return false;" class="social-icon" title="Instagram"
                                                target="_blank"><i class="icon-instagram"></i></a>
                                            <a href="#" onClick="return false;" class="social-icon" title="Pinterest"
                                                target="_blank"><i class="icon-pinterest"></i></a>
                                        </div>
                                    </div><!-- End .product-details-footer -->
                                </div><!-- End .product-details -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <img style="max-width: 100%;height: auto;" src="https://product.hstatic.net/1000230642/product/do_size_giay_92ba454dc5964dfab51bc2fb326eaee2.jpg">
              </div>
            </div>
          </div>
        @if ($template != 'frontend.home.checkout')
            @include('frontend.home.component.footer')
        @endif
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    
    <div class="mobile-menu-overlay"></div>

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <form action="{{route('home.search')}}" class="mobile-search">
                <label for="mobile-search" class="sr-only">Search</label>
                <input id="keywords" class="form-control" name="keywords" id="q" placeholder="Tìm kiếm sản phẩm ..." required>
                <input type="hidden" class="form-control" name="publish" value="2">
                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            </form>
            
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li>
                        <a style="font-family: Open Sans;font-size: 1.6rem;text-transform: none;" href="#" onClick="return false;">Menu</a>
                        <ul>
                            @if(@isset($menus) && !empty($menus))
                            @foreach ($menus as $menu)
                            <li>
                                <a style="font-family: Open Sans;font-size: 1.4rem;text-transform: none;" href="{{ url($menu->slug) }}">{{$menu->name}}</a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </li>
                    @if(@isset($category_products) && !empty($category_products))
                    @foreach ($category_products as $category)
                    <li>
                        <a style="font-family: Open Sans;font-size: 1.6rem;text-transform: none;" href="{{route('home.category.index',$category->slug)}}" class="sf-with-ul">{{$category->name}}</a>
                        @if(!$category->child->isEmpty())
                        <ul> 
                        @foreach ($category->child as $subCat)
                        @if($subCat->publish == 2)
                        <li><a style="font-family: Open Sans;font-size: 1.4rem;text-transform: none;" class="menu-title" href="{{route('home.category.index',$subCat->slug)}}">{{$subCat->name}}</a></li>
                        @endif
                        @endforeach
                        </ul>
                        @endif
                    </li>
                    @endforeach
                    @endif
                    <li>
                        <a style="font-family: Open Sans;font-size: 1.6rem;text-transform: none;" href="#" onClick="return false;" class="sf-with-ul">
                            Nhóm Sản Phẩm
                       </a>
                       <ul>
                        <li class="menu-title"><a style="font-family: Open Sans;font-size: 1.4rem;text-transform: none;" href="{{route('home.flash-sale.index')}}">Khuyến mãi</a></li>
                        <li class="menu-title"><a style="font-family: Open Sans;font-size: 1.4rem;text-transform: none;" href="{{route('home.top-selling.index')}}">Sản phẩm bán chạy</a></li>
                        <li class="menu-title"><a style="font-family: Open Sans;font-size: 1.4rem;text-transform: none;" href="{{route('home.new-arrival.index')}}">Sản phẩm mới phát hành</a></li>
                       </ul>
                    </li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                <a href="#" onClick="return false;" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                <a href="#" onClick="return false;" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                <a href="#" onClick="return false;" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                <a href="#" onClick="return false;" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div>

    @if ($template == 'frontend.home.index')
    <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        @if(@isset($coupons) && is_object($coupons) )
        @foreach ($coupons as $key => $coupon)
        <div class="row">
            <div class="col"></div>
            <div class="col-md-6">
                <div class="coupon bg-white rounded mb-3 d-flex justify-content-between">
                    <div class="kiri p-3">
                        <div class="icon-container ">
                            <div class="icon-container_box">
                            </div>
                        </div>
                    </div>
                    <div class="tengah py-3 d-flex w-100 justify-content-start">
                        <div>
                            <span style="font-family: Be VietNam" class="badge badge-danger">Giảm giá</span>
                            @php
                            if($coupon->coupon_condition==1){
                                echo '<h3 style="font-family: Be VietNam" class="lead">Giảm '.$coupon->coupon_number.'% tổng đơn hàng</h3>';
                            }else{
                                echo '<h3 style="font-family: Be VietNam" class="lead">Giảm '.number_format($coupon->coupon_number, 0, ',', '.').'đ</h3>';
                            }
                            @endphp
                            <p style="font-family: Be VietNam" class="text-muted mb-0">Mã: <b><span id="copyToClipboard{{$key}}" class="text-primary" style="font-size: 14px">{{$coupon->coupon_code}}</span></b></p>
                        </div>
                    </div>
                    <div class="kanan">
                        <div class="info m-3 d-flex align-items-center">
                            <div class="w-100">
                                <div class="block">
                                    <span class="time font-weight-light">
                                        <span style="font-family: Be VietNam">HSD:</span>
                                    </span>
                                </div>
                                <button style="min-width: 130px" type="button" onclick="copy(this,'#copyToClipboard{{$key}}')" style="font-family: Be VietNam"
                                    class="btn btn-sm btn btn-primary btn-block copyClipboard">
                                    Sao chép mã
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col"></div>
        </div>
        @endforeach
        @endif
        <script src="/frontend/library/script.js"></script>
    </div>
    @endif
    <!-- Plugins JS File -->
    @include('frontend.home.component.script')
</body>
<!-- molla/index-10.html  22 Nov 2019 09:58:22 GMT -->
</html>
