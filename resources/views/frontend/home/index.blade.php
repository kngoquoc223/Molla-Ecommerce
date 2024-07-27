<main class="main">
    <div class="container-fluid">
        <div class="intro-slider-container slider-container-ratio mb-2">
            <div class="intro-slider owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{"nav": false}'>
                @if(@isset($sliders) && !empty($sliders))
                @foreach ($sliders as $item)
                <div class="intro-slide">
                    <figure class="slide-image">
                        <picture>
                            <img src="/storage/{{$item->thumb}}" alt="Image Desc">
                        </picture>
                    </figure><!-- End .slide-image -->
                </div><!-- End .intro-slide -->
                @endforeach
                @endif
            </div><!-- End .intro-slider owl-carousel owl-simple -->
            <span class="slider-loader"></span><!-- End .slider-loader -->
        </div><!-- End .intro-slider-container -->
    </div><!-- End .container -->

    <div class="bg-light pt-5 pb-10 mb-3">
        <div class="container">
            <div class="heading heading-center mb-3">
                <h2 style="font-family: Be Vietnam; text-transform: uppercase" class="title-lg mb-2">-Flash Sale-</h2><!-- End .title -->
            </div><!-- End .heading -->
            <div class="tab-content tab-content-carousel">
                <div class="tab-pane tab-pane-shadow p-0 fade show active" id="new-all-tab" role="tabpanel" aria-labelledby="new-all-link">
                    <div class="owl-carousel owl-simple carousel-equal-height" data-toggle="owl" 
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 0,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":2
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true
                                }
                            }
                        }'>
                        @if(@isset($productSales) && !empty($productSales))
                        @foreach ($productSales as $v)
                        <div class="product product-3 text-center">
                            <figure class="product-media">
                                @php
                                $today=Carbon\Carbon::today();
                                $today->subWeek();
                                $res=$today->lt($v->created_at);
                                if($v->quantity == 0){
                                    echo '<span class="product-label label-out">Out of Stock</span>';
                                }
                                if($v->discount != ''){
                                $sale=(($v->price-$v->discount)/$v->price)*100;
                                echo '<span class="product-label label-primary">Sale</span><span class="product-label label-sale">'.(int)$sale.'%</span>';
                                }else{
                                    if($res==true){
                                    echo '<span class="product-label label-new">New</span>';
                                }
                                }
                                @endphp
                                <a href="{{route('home.product.index',["id" => $v->id,"name"=>$v->name])}}">
                                <img src="/storage/{{$v->thumb}}" alt="Product image" class="product-image">
                                </a>
                                <input type="hidden" class="cart_product_id_{{$v->id}}" value="{{$v->id}}">
                                <input type="hidden" class="cart_product_name_{{$v->id}}" value="{{$v->name}}">
                                <input type="hidden" class="cart_product_thumb_{{$v->id}}" value="{{$v->thumb}}">
                                @if($v->discount != '')
                                @php
                                $datetime = new DateTime('tomorrow');
                                $day = $datetime->format('d'); 
                                $month = $datetime->format('m'); 
                                $year = $datetime->format('Y');
                                @endphp
                                <div class="product-countdown-container">
                                    <span style="font-family: Be VietNam" class="product-contdown-title">Kết thúc sau:</span>
                                    <div class="product-countdown countdown-compact" data-until="{{$year}}, {{$month}}, {{$day}}" data-compact="true"></div><!-- End .product-countdown -->
                                </div><!-- End .product-countdown-container -->
                                <input type="hidden" class="cart_product_price_{{$v->id}}" value="{{$v->discount}}">
                                @else
                                <input type="hidden" class="cart_product_price_{{$v->id}}" value="{{$v->price}}">
                                @endif
                                <div class="product-action-vertical">
                                <a href="#" onClick="return false;" data-id_product="{{$v->id}}" style="font-family: Be VietNam" class="btn-product-icon btn-wishlist btn-expandable btn-wishlist-flash-sale" title="Wishlist"><span>Thêm Danh Sách Yêu Thích</span></a>
                                </div><!-- End .product-action-vertical -->
                            </figure><!-- End .product-media -->
                            <div class="product-body">
                                <div class="product-cat">
                                    <a style="font-family: Be VietNam" href="{{route('home.category.index',$v->parentCategory_products->slug)}}">{{$v->parentCategory_products->name}},</a>
                                    <a style="font-family: Be VietNam" href="{{route('home.category.index',$v->category_products->slug)}}">{{$v->category_products->name}}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a style="font-family: Be VietNam" href="{{route('home.product.index',["id" => $v->id,"name"=>$v->name])}}">{{$v->name}}</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    @if($v->discount != '')
                                    <span class="new-price">{{number_format($v->discount, 0, ',', '.')}}đ</span>
                                    <span class="old-price">{{number_format($v->price, 0, ',', '.')}}đ</span>
                                    @else
                                    {{number_format($v->price, 0, ',', '.')}}đ
                                    @endif
                                </div><!-- End .product-price -->
                            </div><!-- End .product-body -->
                            <div class="product-footer">
                                <div class="ratings-container">
                                    @php 
                                    $count=0;
                                    $rating=0;
                                    foreach ($v->comment as $comment) {
                                        if($comment->parent_id == 0){
                                            $count++;
                                            $rating+=$comment->rating;
                                        }
                                    }
                                    if($rating != 0 && $count !=0){
                                        $rating_val=$rating/$count;
                                    }else{
                                        $rating_val=0;
                                    }
                                    @endphp
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: {{$rating_val*20}}%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( {{$count}} Đánh giá )</span>
                                </div><!-- End .rating-container -->
                    
                                <div class="product-action">
                                    <a href="#" data-product_id="{{$v->id}}" data-toggle="modal" data-target="#quick_view" class="btn-product btn-quickview" title="Quick view"><span>Xem nhanh</span></a>
                                    <a href="{{route('home.product.index',["id" => $v->id,"name"=>$v->name])}}" class="btn-product btn-compare" title="Detail"><span>Chi tiết</span></a>
                                </div><!-- End .product-action -->
                        </div><!-- End .product-footer -->
                        </div><!-- End .product -->
                        @endforeach
                        @endif
                    </div><!-- End .owl-carousel -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
        </div><!-- End .container -->
    </div>
    @if($category_products)
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($category_products as $key => $item)
            @if($key>=4)
            @break
            @endif
            <div class="col-md-6 col-lg-3">
                <div class="banner banner-cat">
                    <a href="{{route('home.category.index',$item->slug)}}">
                        <img src="/storage/{{$item->banner}}" alt="Banner">
                    </a>

                    <div class="banner-content banner-content-overlay text-center">
                        <h3 style="font-family: Be VietNam" class="banner-title font-weight-normal">{{$item->name}}</h3><!-- End .banner-title -->
                        @php
                        $total=0;
                        foreach ($item->child as $v) {
                            $total+=$v->products->count();
                        }
                        @endphp
                        <h4 class="banner-subtitle">{{$total}}</h4><!-- End .banner-subtitle -->
                        <a href="{{route('home.category.index',$item->slug)}}" class="banner-link">Mua Ngay</a>
                    </div><!-- End .banner-content -->
                </div><!-- End .banner -->
            </div><!-- End .col-md-4 -->
            @endforeach
        </div><!-- End .row -->
    </div><!-- End .container -->
    @endif


    <div class="mb-4"></div><!-- End .mb-4 -->
        <div class="container">
            <div class="heading heading-center mb-3">
                <h2 style="font-family: Be Vietnam; text-transform: uppercase" class="title-lg mb-2">Sản Phẩm Mới</h2><!-- End .title-lg text-center -->
                @if(@isset($category_products) && !empty($category_products))
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <button data-slug="all" type="button" data-catId=all style="font-family: Be Vietnam" class="nav-link active new-product">Tất cả</button>
                    </li>
                    @foreach ($category_products as $key => $v)
                    <li class="nav-item">
                        <button data-slug="{{$v->slug}}" type="button" data-catId={{$v->id}} style="font-family: Be Vietnam" class="nav-link new-product">{{$v->name}}</button>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div><!-- End .heading -->
            <div class="tab-content">
                <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
                    <div class="products just-action-icons-sm">
                        <div class="row" id="loadNewArrival">
                            @include('frontend.home.pages.new-arrival')
                        </div><!-- End .row -->
                    </div><!-- End .products -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
            <div class="more-container text-center mt-5">
                <a style="display: none" class="btn btn-outline-lightgray btn-more btn-round moreNewProduct"><span>Xem Thêm</span><i class="icon-long-arrow-right"></i></a>
            </div><!-- End .more-container -->
        </div><!-- End .container -->
    <div class="container">
        <div class="heading heading-center mb-3">
            <h2 style="font-family: Be Vietnam; text-transform: uppercase" class="title-lg mb-2">Sản Phẩm Bán Chạy</h2><!-- End .title-lg text-center -->
            @if(@isset($category_products) && !empty($category_products))
            <ul class="nav nav-pills justify-content-center" role="tablist">
                <li class="nav-item">
                    <button data-slug="all" type="button" data-catId=all style="font-family: Be Vietnam" class="nav-link active top-selling-product">Tất cả</button>
                </li>
                @foreach ($category_products as $key => $v)
                <li class="nav-item">
                    <button data-slug="{{$v->slug}}" type="button" data-catId={{$v->id}} style="font-family: Be Vietnam" class="nav-link top-selling-product">{{$v->name}}</button>
                </li>
                @endforeach
            </ul>
            @endif
        </div><!-- End .heading -->
        <div class="tab-content">
            <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
                <div class="products just-action-icons-sm">
                    <div class="row" id="loadTopSelling">
                        @include('frontend.home.pages.top-selling')
                    </div><!-- End .row -->
                </div><!-- End .products -->
            </div><!-- .End .tab-pane -->
        </div><!-- End .tab-content -->
        <div class="more-container text-center mt-5">
            <a style="display: none" class="btn btn-outline-lightgray btn-more btn-round moreTopSelling"><span>Xem Thêm</span><i class="icon-long-arrow-right"></i></a>
        </div><!-- End .more-container -->
    </div><!-- End .container -->

    <div class="mb-5"></div><!-- End .mb5 -->


    <div class="blog-posts">
        <div class="container">
            <h2 style="font-family: Be Vietnam; text-transform: uppercase" class="title-lg text-left mb-4">Tin tức</h2><!-- End .title-lg text-center -->
            <div class="owl-carousel owl-simple mb-4" data-toggle="owl" 
                data-owl-options='{
                    "nav": false, 
                    "dots": true,
                    "items": 3,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
                        },
                        "520": {
                            "items":2
                        },
                        "768": {
                            "items":3
                        },
                        "992": {
                            "items":4
                        }
                    }
                }'>
                @foreach ($posts as $item)
                <article class="entry entry-grid">
                    <figure class="entry-media">
                        <a href="{{route('home.posts.single.index',['slug' => $item->slug])}}">
                            <img src="/storage/{{$item->image}}" alt="image desc">
                        </a>
                    </figure><!-- End .entry-media -->

                    <div class="entry-body">
                        <div class="entry-meta">
                            <a href="#" onClick="return false;">{{$item->created_at}}</a>
                            <span class="meta-separator">|</span>
                            @php
                            $count=0;
                            foreach ($item->comment as $v) {
                                if($v->parent_id == 0){
                                    $count++;
                                }
                            }
                            @endphp
                            <a style="font-family: Be VietNam" href="#" onClick="return false;">{{$count}} Bình luận</a>
                        </div><!-- End .entry-meta -->

                        <h2 class="entry-title">
                            <a style="font-family: Be VietNam" href="{{route('home.posts.single.index',['slug' => $item->slug])}}">{{$item->title}}.</a>
                        </h2><!-- End .entry-title -->

                        <div class="entry-cats">
                            in <a style="font-family: Be VietNam" href="{{route('home.category.posts.index',['slug' => $item->category->slug])}}">{{$item->category->name}}</a>,
                        </div><!-- End .entry-cats -->
                    </div><!-- End .entry-body -->
                </article><!-- End .entry -->
                @endforeach
            </div><!-- End .owl-carousel -->

            <div class="more-container text-center mt-1">
                <a style="font-family: Be Vietnam; text-transform: uppercase" href="{{route('home.posts.index')}}" class="btn btn-outline-lightgray btn-more btn-round"><span>Xem Thêm</span><i class="icon-long-arrow-right"></i></a>
            </div><!-- End .more-container -->
        </div><!-- End .container -->
    </div><!-- End .blog-posts -->
</main><!-- End .main -->