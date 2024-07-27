@foreach ($productMostSellings as $key =>$v)
<div class="col-6 col-md-4 col-lg-3 col-xl-5col">
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
                <img src="/storage/{{$v->thumb}}" alt="{{$v->thumb}}" class="product-image">
            </a>
            <input type="hidden" class="cart_product_id_{{$v->id}}" value="{{$v->id}}">
            <input type="hidden" class="cart_product_name_{{$v->id}}" value="{{$v->name}}">
            <input type="hidden" class="cart_product_thumb_{{$v->id}}" value="{{$v->thumb}}">
            @if($v->discount != '')
            <input type="hidden" class="cart_product_price_{{$v->id}}" value="{{$v->discount}}">
            @else
            <input type="hidden" class="cart_product_price_{{$v->id}}" value="{{$v->price}}">
            @endif
                        <div class="product-action-vertical">
                            <a href="#" onClick="return false;" data-id_product="{{$v->id}}" style="font-family: Be VietNam" class="btn-product-icon btn-wishlist btn-expandable btn-wishlist-top-selling" title="Wishlist"><span>Thêm Danh Sách Yêu Thích</span></a>
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
                    <a href="#" data-product_id="{{$v->id}}" data-toggle="modal" data-target="#quick_view" class="btn-product btn-quickview" title="Quick view"><span style="display: inline-block;padding-left: 5px">Xem nhanh</span></a>
                    <a href="{{route('home.product.index',["id" => $v->id,"name"=>$v->name])}}" class="btn-product btn-compare" title="Detail"><span style="display: inline-block;padding-left: 5px">Chi tiết</span></a>
                </div><!-- End .product-action -->
        </div><!-- End .product-footer -->
    </div><!-- End .product -->
</div><!-- End .col-6 col-md-4 col-lg-3 -->
@endforeach
