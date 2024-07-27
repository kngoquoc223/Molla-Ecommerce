<main class="main">
    <div class="page-header text-center" style="background-image: url('/frontend/assets/images/page-header-bg.jpg')">
        <div class="container-fluid">
            <h1 style="text-transform: uppercase;font-family: Be VietNam" class="page-title">Nhóm Khuyến Mãi<span>Shop</span></h1>
        </div><!-- End .container-fluid -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.index')}}">Trang chủ</a></li>
                <li style="font-family: Be VietNam" class="breadcrumb-item active" aria-current="page">Khuyến mãi</li>
            </ol>
        </div><!-- End .container-fluid -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="toolbox">
                <div class="toolbox-left">
                    <a href="#" class="sidebar-toggler"></a>
                </div><!-- End .toolbox-left -->

                <div class="toolbox-center">
                </div><!-- End .toolbox-center -->

                <div class="toolbox-right">
                    <div class="toolbox-sort">
                    </div><!-- End .toolbox-sort -->
                </div><!-- End .toolbox-right -->
            </div><!-- End .toolbox -->
            <div class="products">
                @if(!$products->isEmpty())
                <div class="row">
                    @foreach ($products as $key => $v)
                    <div class="col-6 col-md-4 col-lg-4 col-xl-3 col-xxl-2">
                        <div class="product">
                            <figure class="product-media">
                                @php
                                $today=Carbon\Carbon::today();
                                $today->subWeek();
                                $res=$today->lt($v->created_at);
                                if($v->quantity == 0){
                                echo '<span class="product-label label-out">Out of Stock</span>';
                                }
                                if($v->discount != ''){
                                // $price=preg_replace("/[^0-9]/", "", $v->price);
                                // $discount=preg_replace("/[^0-9]/", "", $v->discount);
                                $sale=(($v->price-$v->discount)/$v->price)*100;
                                echo '<span class="product-label label-primary">Sale</span><span class="product-label label-sale">'.(int)$sale.'%</span>';
                                }else{
                                    if($res==true){
                                    echo '<span class="product-label label-new">New</span>';
                                }
                                }
                                @endphp
                                {{-- @if($product->discount != '')
                                <span class="new-price">{{$product->discount}} </span>
                                <span class="old-price">{{$product->price}} </span>
                                @php 
                                $price=preg_replace("/[^0-9]/", "", $product->price);
                                $discount=preg_replace("/[^0-9]/", "", $product->discount);
                                $sale=(($price-$discount)/$price)*100;
                                @endphp
                                <span class="sale-price">-{{$sale}}%</span>
                                @else
                                {{$product->price}} 
                                @endif --}}
                                <a href="{{route('home.product.index',["id" => $v->product_id??$v->id,"name"=>$v->name])}}">
                                    <img src="/storage/{{$v->thumb}}" alt="Product image" class="product-image">
                                </a>
                    
                                <input type="hidden" class="cart_product_id_{{($v->product_id??$v->id)}}" value="{{($v->product_id??$v->id)}}">
                                <input type="hidden" class="cart_product_name_{{($v->product_id??$v->id)}}" value="{{$v->name}}">
                                <input type="hidden" class="cart_product_thumb_{{($v->product_id??$v->id)}}" value="{{$v->thumb}}">
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
                                                <a href="#" onClick="return false;" data-id_product="{{($v->product_id??$v->id)}}" style="font-family: Be VietNam" class="btn-product-icon btn-wishlist btn-expandable btn-wishlist-product" title="Wishlist"><span>Thêm Danh Sách Yêu Thích</span></a>
                                            </div><!-- End .product-action-vertical -->
                                <div class="product-action action-icon-top">
                                    <a href="#" data-product_id="{{($v->product_id??$v->id)}}" data-toggle="modal" data-target="#quick_view" class="btn-product btn-quickview" title="Quick view"><span>Xem nhanh</span></a>
                                    <a href="{{route('home.product.index',["id" => $v->id,"name"=>$v->name])}}" class="btn-product btn-compare" title="Detail"><span>Chi tiết</span></a>
                                </div><!-- End .product-action -->
                            </figure><!-- End .product-media -->
                    
                            <div class="product-body">
                                <div class="product-cat">
                                    <a style="font-family: Be VietNam" href="{{route('home.category.index',$v->parentCategory_products->slug)}}">{{$v->parentCategory_products->name}},</a>
                                    <a style="font-family: Be VietNam" href="{{route('home.category.index',$v->category_products->slug)}}">{{$v->category_products->name}}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a style="font-family: Be VietNam" href="{{route('home.product.index',["id" => $v->product_id??$v->id,"name"=>$v->name])}}">{{$v->name}}</a></h3><!-- End .product-title -->
                                <div class="product-price">
                                    @if($v->discount != '')
                                    <span class="new-price">{{number_format($v->discount, 0, ',', '.')}}đ </span>
                                    <span class="old-price">{{number_format($v->price, 0, ',', '.')}}đ </span>
                                    @else
                                    {{number_format($v->price, 0, ',', '.')}}đ
                                    @endif
                                </div><!-- End .product-price -->
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
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-lg-4 col-xl-3 -->
                    @endforeach
                </div><!-- End .row -->
                @endif
            </div><!-- End .products -->

            <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
        </div><!-- End .container-fluid -->
    </div><!-- End .page-content -->
</main><!-- End .main -->