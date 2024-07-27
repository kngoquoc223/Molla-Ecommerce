{{-- <div class="header-middle">
    <div class="container">
        <div class="header-left">
            <button class="mobile-menu-toggler">
                <span class="sr-only">Toggle mobile menu</span>
                <i class="icon-bars"></i>
            </button>
            
            <a href="{{route('home.index')}}" class="logo">
                <img src="{{asset('frontend/assets/images/demos/demo-10/logo.png')}}" alt="Molla Logo" width="105" height="25">
            </a>
        </div><!-- End .header-left -->

        <div class="header-center">
                <form action="{{route('home.search')}}">
                    <div style="width: 570px;" class="dropdown compare-dropdown">
                    <div class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
                        <div class="header-search-wrapper search-wrapper-wide">
                            <input id="keywords" class="form-control" name="keywords" id="q" placeholder="Tìm kiếm sản phẩm ..." required>
                            <input type="hidden" class="form-control" name="publish" value="2">
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                        </div><!-- End .header-search-wrapper -->
                    </div><!-- End .header-search -->
                    <div id="search-ajax"></div>
                    </div>
                </form>
        </div>

        <div class="header-right">
            <div class="dropdown compare-dropdown">
                <div class="wishlist">
                    <a href="#" onClick="return false;" title="Wishlist">
                        <div class="icon">
                            <i class="icon-heart-o"></i>
                            <span class="wishlist-count">{{(Session::get('wishlist_count')??0)}}</span>
                        </div>
                        <p style="font-family: Be VietNam">Yêu thích</p>
                    </a>
                </div>
                <div style="overflow: auto;width: 400px;height: 500px" class="dropdown-menu dropdown-menu-right">
                    <div class="compare-products">
                        @if(Session::get('wishlist') == true)
                        @foreach (Session::get('wishlist') as $item)
                        <div id="wishlist-product-id-session-{{$item['session_id']}}" style="display: inline-flex;" class="compare-product">
                            <a href="{{route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']])}}">
                                <img style="max-width: 90px;margin: revert" src="/storage/{{$item['product_thumb']}}" alt="product">
                            </a>
                            <div style="display: inline-flex;">
                                <h4 style="font-size: 1.5rem;" class="product-title">
                                    <a style="font-family: Be VietNam" href="{{route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']])}}">{{$item['product_name']}}</a>
                                </h4>
                                    <b style="color: #666">{{number_format($item['product_price'], 0, ',', '.')}}đ</b>
                            </div>
                            <button data-session_id={{$item['session_id']}} class="btn-remove remove-wishlist" title="Remove Product"><i class="icon-close"></i></button>
                        </div>
                        @endforeach
                        @else
                        <p style="font-size: 1.6rem;font-family: Be VietNam" class="text-center">Hiện chưa có sản phẩm!</p>
                        @endif
                    </div>
                    <div class="compare-actions">
                        <a style="font-family: Be VietNam" href="#" onClick="return false;" class="remove-wishlist-all">Xóa hết</a>
                    </div>
                </div><!-- End .dropdown-menu -->
            </div><!-- End .compare-dropdown -->
            <div class="dropdown cart-dropdown">
                <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                    <a href="{{route('cart.index')}}" class="dropdown-toggle">
                    <div class="icon">
                        <i class="icon-shopping-cart"></i>
                        <span class="cart-count">{{(Session::get('cart_count')??0)}}</span>
                    </div>
                    <p style="font-family: Be VietNam">Giỏ hàng</p>
                </a>
                <div style="overflow: auto;width: 400px;height: 500px" {{Request::segment(1)=='cart'?'hidden':''}}  class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-cart-products">
                        @php
                        $total=0;
                        @endphp
                        @if(Session::get('cart') == true)
                        @foreach (Session::get('cart') as $item)
                        @php 
                        $total+=$item['product_qty']*$item['product_price'];
                        @endphp
                        <div id="cart-product-id-session-{{$item['session_id']}}" class="product">
                            <div class="product-cart-details">
                                <h4 style="font-size: 1.5rem;" class="product-title">
                                    <a style="font-family: Be VietNam" href="{{route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']])}}">{{$item['product_name']}}</a>
                                </h4>
                                <p style="font-size: 1.3rem;">
                                    <b>Size:</b> {{$item['product_size']}}
                                </p>
                                <span class="cart-product-info">
                                    <span style="background: #f7f7f7;color: #252a2b" class="cart-product-qty">{{$item['product_qty']}}</span>
                                    x <b>{{number_format($item['product_price'], 0, ',', '.')}}đ</b>
                                </span>
                            </div><!-- End .product-cart-details -->

                            <figure style="max-width: 90px;margin: revert" class="product-image-container">
                                <a href="{{route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']])}}" class="product-image">
                                    <img src="/storage/{{$item['product_thumb']}}" alt="product">
                                </a>
                            </figure>
                            <button data-session_id={{$item['session_id']}} class="btn-remove remove-cart" title="Remove Product"><i class="icon-close"></i></button>
                        </div><!-- End .product -->
                        @endforeach
                        <div class="dropdown-cart-total">
                            <span style="font-size: 1.4rem">Tổng tiền:</span>
                            <span style="font-size: 1.6rem;color: #ef837b" id="cart-total" class="cart-total-price">{{number_format($total, 0, ',', '.')}}đ</span>
                        </div>
                        <div style="justify-content: center" class="dropdown-cart-action">
                            <a href="{{route('cart.index')}}" class="btn btn-primary">XEM GIỎ HÀNG</a>
                        </div><!-- End .dropdown-cart-total -->
                        @else
                            <p style="font-family: Be VietNam;font-size: 1.6rem" class="text-center">Hiện chưa có sản phẩm!</p>
                            <div class="dropdown-cart-total">
                                <span style="font-size: 1.4rem">Tổng tiền:</span>
                                <span style="font-size: 1.6rem;color: #ef837b" id="cart-total" class="cart-total-price">{{number_format($total, 0, ',', '.')}}đ</span>
                            </div>
                            <div style="justify-content: center" class="dropdown-cart-action">
                                <a href="{{route('cart.index')}}" class="btn btn-primary">XEM GIỎ HÀNG</a>
                            </div><!-- End .dropdown-cart-total -->
                        @endif
                    </div><!-- End .cart-product -->
                </div><!-- End .dropdown-menu -->
            </div><!-- End .cart-dropdown -->
            <div class="account">
                @php
                
                if(Session::get('customer') == true){
                        echo '<a href="'.route('home.user.myUser').'" title="My account">
                    <div class="icon">
                        <i class="icon-user"></i>
                    </div>
                    <p style="font-family: Be VietNam">'.Session::get('customer')->name.'</p>
                    </a>';
                }else{
                    echo '<a href="'.route('home.user.showForm').'" title="My account">
                    <div class="icon">
                        <i class="icon-user"></i>
                    </div>
                    <p style="font-family: Be VietNam">Tài khoản</p>
                </a>';
                }
                @endphp
            </div><!-- End .compare-dropdown -->
        </div><!-- End .header-right -->
    </div><!-- End .container -->
</div>

<div class="header-bottom sticky-header">
    <div class="container">
        <div class="header-left">
            <div class="dropdown category-dropdown">
                <a style="font-family: Open Sans;font-size: 1.8rem" href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Browse Categories">
                     Nhóm Sản Phẩm
                </a>
                <div class="dropdown-menu">
                    <nav class="side-nav">
                        <ul class="menu-vertical sf-arrows">
                            <li class="item-lead"><a style="font-family: Open Sans;font-size: 1.8rem" href="{{route('home.flash-sale.index')}}">Khuyến mãi</a></li>
                            <li class="item-lead"><a style="font-family: Open Sans;font-size: 1.8rem" href="{{route('home.top-selling.index')}}">Sản phẩm bán chạy</a></li>
                            <li><a style="font-family: Open Sans;font-size: 1.8rem" href="{{route('home.new-arrival.index')}}">Sản phẩm mới phát hành</a></li>
                        </ul><!-- End .menu-vertical -->
                    </nav><!-- End .side-nav -->
                </div>
            </div>
        </div>
        <div class="header-center">
            <nav class="main-nav">
                <ul class="menu sf-arrows">
                    @if(@isset($category_products) && !empty($category_products))
                    @foreach ($category_products as $category)
                    <?php
                    $segment2 =  Request::segment(2);
                    $posts=Strpos($segment2,$category->slug);
                    ?>
                    <li class="{{$posts!=''?'active':''}}">
                        <a style="font-family: Open Sans;font-size: 1.8rem" href="{{route('home.category.index',$category->slug)}}" class="sf-with-ul">{{$category->name}}
                        </a>
                        @if(!$category->child->isEmpty()) 
                        <div  class="megamenu megamenu-sm">
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <div class="menu-col">
                                        <ul>
                                        @foreach ($category->child as $subCat)
                                        @if($subCat->publish == 2)
                                        <li><a style="font-family: Open Sans;font-size: 1.8rem;text-transform: none;" class="menu-title" href="{{route('home.category.index',$subCat->slug)}}">{{$subCat->name}}</a></li>
                                        @endif
                                        @endforeach
                                        </ul>
                                    </div><!-- End .menu-col -->
                                </div><!-- End .col-md-6 -->
                                <div class="col-md-6">
                                    <div class="banner banner-overlay">
                                        <a href="{{route('home.category.index',$category->slug)}}">
                                            <img src="/storage/{{$category->banner}}" alt="Banner">
                                        </a>
                                    </div><!-- End .banner -->
                                </div><!-- End .col-md-6 -->
                            </div><!-- End .row -->
                        </div>
                        @endif
                    </li>
                    @endforeach
                    @endif
                </ul><!-- End .menu -->
            </nav>
        </div>
        <div class="header-right">
            <nav class="main-nav">
                <ul class="menu sf-arrows">
                    @if(@isset($menus) && !empty($menus))
                    @foreach ($menus as $menu)
                    <li class="{{Request::segment(1) == $menu->slug ? 'active': ''}}">
                        <a style="font-family: Open Sans;font-size: 1.8rem;text-transform: none;" href="{{ url($menu->slug) }}">{{$menu->name}}</a>
                    </li>
                    @endforeach
                    @endif
                </ul><!-- End .menu -->
            </nav>
        </div>
    </div>
</div> --}}

<div class="sticky-header">
    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>
                
                <a href="{{route('home.index')}}" class="logo">
                    <img src="{{asset('frontend/assets/images/demos/demo-10/logo.png')}}" alt="Molla Logo" width="105" height="25">
                </a>
            </div><!-- End .header-left -->
    
            <div class="header-center">
                    <form action="{{route('home.search')}}">
                        <div style="width: 570px;" class="dropdown compare-dropdown">
                        <div class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
                            <div class="header-search-wrapper search-wrapper-wide">
                                <input id="keywords" class="form-control" name="keywords" id="q" placeholder="Tìm kiếm sản phẩm ..." required>
                                <input type="hidden" class="form-control" name="publish" value="2">
                                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                            </div><!-- End .header-search-wrapper -->
                        </div><!-- End .header-search -->
                        <div id="search-ajax"></div>
                        </div>
                    </form>
            </div>
    
            <div class="header-right">
                <div class="dropdown compare-dropdown">
                    <div class="wishlist">
                        <a href="#" onClick="return false;" title="Wishlist">
                            <div class="icon">
                                <i class="icon-heart-o"></i>
                                <span class="wishlist-count">{{(Session::get('wishlist_count')??0)}}</span>
                            </div>
                            <p style="font-family: Be VietNam">Yêu thích</p>
                        </a>
                    </div>
                    <div style="overflow: auto;width: 400px;height: 500px" class="dropdown-menu dropdown-menu-right">
                        <div class="compare-products">
                            @if(Session::get('wishlist') == true)
                            @foreach (Session::get('wishlist') as $item)
                            <div id="wishlist-product-id-session-{{$item['session_id']}}" style="display: inline-flex;" class="compare-product">
                                <a href="{{route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']])}}">
                                    <img style="max-width: 90px;margin: revert" src="/storage/{{$item['product_thumb']}}" alt="product">
                                </a>
                                <div style="display: inline-flex;">
                                    <h4 style="font-size: 1.5rem;" class="product-title">
                                        <a style="font-family: Be VietNam" href="{{route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']])}}">{{$item['product_name']}}</a>
                                    </h4>
                                        <b style="color: #666">{{number_format($item['product_price'], 0, ',', '.')}}đ</b>
                                </div>
                                <button data-session_id={{$item['session_id']}} class="btn-remove remove-wishlist" title="Remove Product"><i class="icon-close"></i></button>
                            </div>
                            @endforeach
                            @else
                            <p style="font-size: 1.6rem;font-family: Be VietNam" class="text-center">Hiện chưa có sản phẩm!</p>
                            @endif
                        </div>
                        <div class="compare-actions">
                            <a style="font-family: Be VietNam" href="#" onClick="return false;" class="remove-wishlist-all">Xóa hết</a>
                        </div>
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .compare-dropdown -->
                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <a href="{{route('cart.index')}}" class="dropdown-toggle">
                        <div class="icon">
                            <i class="icon-shopping-cart"></i>
                            <span class="cart-count">{{(Session::get('cart_count')??0)}}</span>
                        </div>
                        <p style="font-family: Be VietNam">Giỏ hàng</p>
                    </a>
                    <div style="overflow: auto;width: 400px;height: 500px" {{Request::segment(1)=='cart'?'hidden':''}}  class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-cart-products">
                            @php
                            $total=0;
                            @endphp
                            @if(Session::get('cart') == true)
                            @foreach (Session::get('cart') as $item)
                            @php 
                            $total+=$item['product_qty']*$item['product_price'];
                            @endphp
                            <div id="cart-product-id-session-{{$item['session_id']}}" class="product">
                                <div class="product-cart-details">
                                    <h4 style="font-size: 1.5rem;" class="product-title">
                                        <a style="font-family: Be VietNam" href="{{route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']])}}">{{$item['product_name']}}</a>
                                    </h4>
                                    <p style="font-size: 1.3rem;">
                                        <b>Size:</b> {{$item['product_size']}}
                                    </p>
                                    <span class="cart-product-info">
                                        <span style="background: #f7f7f7;color: #252a2b" class="cart-product-qty">{{$item['product_qty']}}</span>
                                        x <b>{{number_format($item['product_price'], 0, ',', '.')}}đ</b>
                                    </span>
                                </div><!-- End .product-cart-details -->
    
                                <figure style="max-width: 90px;margin: revert" class="product-image-container">
                                    <a href="{{route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']])}}" class="product-image">
                                        <img src="/storage/{{$item['product_thumb']}}" alt="product">
                                    </a>
                                </figure>
                                <button data-session_id={{$item['session_id']}} class="btn-remove remove-cart" title="Remove Product"><i class="icon-close"></i></button>
                            </div><!-- End .product -->
                            @endforeach
                            <div class="dropdown-cart-total">
                                <span style="font-size: 1.4rem">Tổng tiền:</span>
                                <span style="font-size: 1.6rem;color: #ef837b" id="cart-total" class="cart-total-price">{{number_format($total, 0, ',', '.')}}đ</span>
                            </div>
                            <div style="justify-content: center" class="dropdown-cart-action">
                                <a href="{{route('cart.index')}}" class="btn btn-primary">XEM GIỎ HÀNG</a>
                            </div><!-- End .dropdown-cart-total -->
                            @else
                                <p style="font-family: Be VietNam;font-size: 1.6rem" class="text-center">Hiện chưa có sản phẩm!</p>
                                <div class="dropdown-cart-total">
                                    <span style="font-size: 1.4rem">Tổng tiền:</span>
                                    <span style="font-size: 1.6rem;color: #ef837b" id="cart-total" class="cart-total-price">{{number_format($total, 0, ',', '.')}}đ</span>
                                </div>
                                <div style="justify-content: center" class="dropdown-cart-action">
                                    <a href="{{route('cart.index')}}" class="btn btn-primary">XEM GIỎ HÀNG</a>
                                </div><!-- End .dropdown-cart-total -->
                            @endif
                        </div><!-- End .cart-product -->
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .cart-dropdown -->
                <div class="account">
                    @php
                    
                    if(Session::get('customer') == true){
                            echo '<a href="'.route('home.user.myUser').'" title="My account">
                        <div class="icon">
                            <i class="icon-user"></i>
                        </div>
                        <p style="font-family: Be VietNam">'.Session::get('customer')->name.'</p>
                        </a>';
                    }else{
                        echo '<a href="'.route('home.user.showForm').'" title="My account">
                        <div class="icon">
                            <i class="icon-user"></i>
                        </div>
                        <p style="font-family: Be VietNam">Tài khoản</p>
                    </a>';
                    }
                    @endphp
                </div><!-- End .compare-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="header-left">
                <div class="dropdown category-dropdown">
                    <a style="font-family: Open Sans;font-size: 1.8rem" href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Browse Categories">
                         Nhóm Sản Phẩm
                    </a>
                    <div class="dropdown-menu">
                        <nav class="side-nav">
                            <ul class="menu-vertical sf-arrows">
                                <li class="item-lead"><a style="font-family: Open Sans;font-size: 1.8rem" href="{{route('home.flash-sale.index')}}">Khuyến mãi</a></li>
                                <li class="item-lead"><a style="font-family: Open Sans;font-size: 1.8rem" href="{{route('home.top-selling.index')}}">Sản phẩm bán chạy</a></li>
                                <li><a style="font-family: Open Sans;font-size: 1.8rem" href="{{route('home.new-arrival.index')}}">Sản phẩm mới phát hành</a></li>
                            </ul><!-- End .menu-vertical -->
                        </nav><!-- End .side-nav -->
                    </div>
                </div>
            </div>
            <div class="header-center">
                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        @if(@isset($category_products) && !empty($category_products))
                        @foreach ($category_products as $category)
                        <?php
                        $segment2 =  Request::segment(2);
                        $posts=Strpos($segment2,$category->slug);
                        ?>
                        <li class="{{$posts!=''?'active':''}}">
                            <a style="font-family: Open Sans;font-size: 1.8rem" href="{{route('home.category.index',$category->slug)}}" class="sf-with-ul">{{$category->name}}
                            </a>
                            @if(!$category->child->isEmpty()) 
                            <div  class="megamenu megamenu-sm">
                                <div class="row no-gutters">
                                    <div class="col-md-6">
                                        <div class="menu-col">
                                            <ul>
                                            @foreach ($category->child as $subCat)
                                            @if($subCat->publish == 2)
                                            <li><a style="font-family: Open Sans;font-size: 1.8rem;text-transform: none;" class="menu-title" href="{{route('home.category.index',$subCat->slug)}}">{{$subCat->name}}</a></li>
                                            @endif
                                            @endforeach
                                            </ul>
                                        </div><!-- End .menu-col -->
                                    </div><!-- End .col-md-6 -->
                                    <div class="col-md-6">
                                        <div class="banner banner-overlay">
                                            <a href="{{route('home.category.index',$category->slug)}}">
                                                <img src="/storage/{{$category->banner}}" alt="Banner">
                                            </a>
                                        </div><!-- End .banner -->
                                    </div><!-- End .col-md-6 -->
                                </div><!-- End .row -->
                            </div>
                            @endif
                        </li>
                        @endforeach
                        @endif
                    </ul><!-- End .menu -->
                </nav>
            </div>
            <div class="header-right">
                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        @if(@isset($menus) && !empty($menus))
                        @foreach ($menus as $menu)
                        <li class="{{Request::segment(1) == $menu->slug ? 'active': ''}}">
                            <a style="font-family: Open Sans;font-size: 1.8rem;text-transform: none;" href="{{ url($menu->slug) }}">{{$menu->name}}</a>
                        </li>
                        @endforeach
                        @endif
                    </ul><!-- End .menu -->
                </nav>
            </div>
        </div>
    </div>
</div>