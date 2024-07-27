
        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container d-flex align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.index')}}">Trang Chủ</a></li>
                        <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.category.index',$product->parentCategory_products->slug)}}">{{$product->parentCategory_products->name}}</a></li>
                        <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.category.index',$product->category_products->slug)}}">{{$product->category_products->name}}</a></li>
                        <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.product.index',["id" => $product->id,"name"=>$product->name])}}">{{$product->name}}</a></li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="page-content">
                <div class="container">
                    <div class="product-details-top">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery product-gallery-vertical">
                                    <div class="row">
                                        <figure class="product-main-image">
                                            @php
                                            $today=Carbon\Carbon::today();
                                            $today->subWeek();
                                            $res=$today->lt($product->created_at);
                                            if($product->quantity == 0){
                                            echo '<span class="product-label label-out">Out of Stock</span>';
                                            }
                                            if($res==true){
                                                echo '<span class="product-label label-new">New</span>';
                                            }
                                            @endphp
                                            <img id="product-zoom" src="/storage/{{$product->thumb}}"  alt="product image">
                                            <a  id="btn-product-gallery" class="btn-product-gallery">
                                                <i class="icon-arrows"></i>
                                            </a>
                                        </figure><!-- End .product-main-image -->
                                        <div id="product-zoom-gallery" class="product-image-gallery">
                                            @foreach($product->images as $key => $v)
                                            <a class="product-gallery-item"  data-image="/storage/{{$v->image}}" >
                                                <img src="/storage/{{$v->image}}" alt="product side">
                                            </a>
                                            @endforeach
                                        </div><!-- End .product-image-gallery -->
                                    </div><!-- End .row -->
                                </div><!-- End .product-gallery -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <div class="product-details">
                                    <h1 style="font-family: Be VietNam" class="product-title">{{$product->name}}</h1><!-- End .product-title -->
                                    <div class="ratings-container">
                                        @php 
                                        $count=0;
                                        $rating=0;
                                        foreach ($product->comment as $v) {
                                            if($v->parent_id == 0){
                                                $count++;
                                                $rating+=$v->rating;
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
                                        <a class="ratings-text" href="#product-review-link" id="review-link">( {{$count}} đánh giá )</a>
                                        <a style="font-family: Be VietNam" class="ratings-text" id="">Tình trạng:<span class="text-success quantity"></span></a>
                                    </div><!-- End .rating-container -->
                                    <div class="product-price">
                                        @if($product->discount != '')
                                        <span class="new-price">{{number_format($product->discount, 0, ',', '.')}}đ </span>
                                        <span class="old-price">{{number_format($product->price, 0, ',', '.')}}đ </span>
                                        <input type="hidden" class="cart_product_price_{{$product->id}}" value="{{$product->discount}}">
                                        @php 
                                        // $price=preg_replace("/[^0-9]/", "", $product->price);
                                        // $discount=preg_replace("/[^0-9]/", "", $product->discount);
                                        $sale=(($product->price-$product->discount)/$product->price)*100;
                                        @endphp
                                        <span class="sale-price">-{{(int)$sale}}%</span>
                                        @else
                                        {{number_format($product->price, 0, ',', '.')}}đ
                                        <input type="hidden" class="cart_product_price_{{$product->id}}" value="{{$product->price}}">
                                        @endif
                                    </div><!-- End .product-price -->
                                    <div class="product-content">
                                        <p style="font-family: Be VietNam">{{$product->content}}</p>
                                    </div><!-- End .product-content -->

                                    <div class="details-filter-row details-row-size">
                                        <label for="size">Size:</label>
                                        <div class="product-size">
                                            @foreach($product->attr as $key => $v)
                                            <a href="#" onClick="return false;" value="{{$v->value}}" data-quantity="{{$v->pivot->quantity}}" data-value="{{$v->id}}" class="item-size {{$v->pivot->quantity==0 ? 'disabled' : ''}}" title="{{$v->value}}">{{$v->value}}</a>
                                            @endforeach
                                            <input type="hidden" class="cart_product_size_active">
                                            {{-- <select name="size" id="size" class="form-control">
                                                <option value="#" selected="selected">--Chọn Size--</option>
                                                @foreach($product->attr as $key => $v)
                                                <option value="{{$v->id}}">{{$v->value}}</option>
                                                @endforeach
                                            </select> --}}
                                        </div><!-- End .select-custom -->
                                        <a type="button" style="font-family: Be VietNam" class="size-guide" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="icon-th-list"></i>(Cách chọn size)</a>
                                    </div><!-- End .details-filter-row -->
                                    <div class="details-filter-row details-row-size">
                                        <div class="product-details-quantity">
                                            <input type="number" id="qty" class="form-control cart_product_qty_{{$product->id}}" value="1" min="1" max="10" step="1" data-decimals="0" required>
                                        </div><!-- End .product-details-quantity -->
                                    </div><!-- End .details-filter-row -->
                                    <input type="hidden" class="cart_product_id_{{$product->id}}" value="{{$product->id}}">
                                    <input type="hidden" class="cart_product_name_{{$product->id}}" value="{{$product->name}}">
                                    <input type="hidden" class="cart_product_thumb_{{$product->id}}" value="{{$product->thumb}}">
                                    
                                    <div class="product-details-action">
                                        <a href="#" onClick="return false;" data-id_product="{{$product->id}}" style="font-family: Be VietNam" class="btn-product btn-cart"><span>Thêm Giỏ Hàng</span></a>
                                        <div class="details-action-wrapper">
                                            <a href="#" onClick="return false;" data-id_product="{{$product->id}}" style="font-family: Be VietNam" class="btn-product btn-wishlist" title="Wishlist"><span>Thêm Danh Sách Yêu Thích</span></a>
                                        </div><!-- End .details-action-wrapper -->
                                    </div><!-- End .product-details-action -->

                                    <div class="product-details-footer">
                                        <div class="social-icons social-icons-sm">
                                            <span class="social-label">Share:</span>
                                            <a href="#" onClick="return false;" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                            <a href="#" onClick="return false;" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                            <a href="#" onClick="return false;" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                            <a href="#" onClick="return false;" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                        </div>
                                    </div><!-- End .product-details-footer -->
                                </div><!-- End .product-details -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-details-top -->

                    <div class="product-details-tab">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            @if($product->description!='')
                            <li class="nav-item">
                                <a style="font-family: Be VietNam" class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" onClick="return false;" role="tab" aria-controls="product-desc-tab" aria-selected="true">Mô tả sản phẩm</a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a style="font-family: Be VietNam" class="nav-link {{($product->description!=''?'':'active')}}" id="product-review-link" data-toggle="tab" href="#product-review-tab" onClick="return false;" role="tab" aria-controls="product-review-tab" aria-selected="false">Đánh giá ({{$count}})</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            @if($product->description!='')
                            <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                                <div class="product-desc-content">
                                    {!!$product->description!!}
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            @endif
                            <div class="tab-pane fade {{($product->description!=''?'':'show active')}}" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                                <div class="comments">
                                    <h3 style="font-family: OpenSans" class="title">{{$count}} Bình luận</h3><!-- End .title -->
                                    <ul>
                                        @foreach ($comments as $key => $item)
                                        <li>
                                            <div class="comment">
                                                <figure class="comment-media">
                                                    <div class="col-auto">
                                                        <h4></h4>
                                                        <div class="ratings-container">
                                                            <div class="ratings">
                                                                <div class="ratings-val" style="width: {{$item->rating*20}}%;"></div>
                                                            </div>
                                                        </div>
                                                        <span></span>
                                                        @if(Session::get('customer')!=null)
                                                        @if(Session::get('customer')->user_catalogue_id==1)<a data-key="{{$item->id}}" href="#" onClick="return false;" class="remove-comment"><i class="icon-close"></i></a>@endif
                                                        @endif
                                                    </div>
                                                </figure>
                                                <div class="comment-body">
                                                    <div style="padding-left: 50px" class="col">
                                                        @if(Session::get('customer')!=null)
                                                        @if(Session::get('customer')->user_catalogue_id==1)<a style="font-family: OpenSans" href="#" onClick="return false;" data-key="{{$item->id}}" class="comment-reply">Trả lời</a>@endif
                                                        @endif
                                                        <div class="comment-user">
                                                            <h4><a style="font-family: Be VietNam" href="#" onClick="return false;">{{$item->user->name}}</a></h4>
                                                            @if ($item->created_at->isToday())
                                                                    <span class="comment-date">Today</span>
                                                            @elseif($item->created_at->isYesterday())
                                                                <span class="comment-date">Yesterday</span>
                                                            @else
                                                            <span class="comment-date">{{ $item->created_at->diffForHumans()}}</span>
                                                            @endif
                                                        </div><!-- End .comment-user -->
                                                        <div class="comment-content">
                                                            <p style="font-family: Be VietNam">{{$item->comment}}</p>
                                                        </div><!-- End .comment-content -->
                                                    </div>
                                                </div><!-- End .comment-body -->
                                            </div><!-- End .comment -->
                                            @foreach ($item->child as $v)
                                            <ul>
                                                <li>
                                                    <div class="comment">
                                                        <figure class="comment-media">
                                                            <a href="#">
                                                                <img src="/storage/{{$v->user->avatar}}">
                                                            </a>
                                                            @if(Session::get('customer')!=null)
                                                            @if(Session::get('customer')->user_catalogue_id==1)<a data-key="{{$v->id}}" href="#" onClick="return false;" class="remove-comment"><i class="icon-close"></i></a>@endif
                                                            @endif
                                                        </figure>
                                                        <div class="comment-body">
                                                            @if(Session::get('customer')!=null)
                                                            @if(Session::get('customer')->user_catalogue_id==1)<a style="font-family: OpenSans" href="#" onClick="return false;" data-key="{{$item->id}}" class="comment-reply">Trả lời</a>@endif
                                                            @endif
                                                            <div class="comment-user">
                                                                <h4><a style="font-family: Be VietNam" href="#" onClick="return false;">{{$v->user->name}}</a></h4>
                                                                @if ($item->created_at->isToday())
                                                                <span class="comment-date">Today</span>
                                                        @elseif($item->created_at->isYesterday())
                                                            <span class="comment-date">Yesterday</span>
                                                        @else
                                                        <span class="comment-date">{{ $item->created_at->diffForHumans()}}</span>
                                                        @endif
                                                            </div><!-- End .comment-user -->
                                                            <div class="comment-content">
                                                                <p style="font-family: Be VietNam">{{$v->comment}}</p>
                                                            </div><!-- End .comment-content -->
                                                        </div><!-- End .comment-body -->
                                                    </div><!-- End .comment -->
                                                </li>
                                            </ul>
                                            @endforeach
                                            @if(Session::get('customer')!=null)
                                            @if(Session::get('customer')->user_catalogue_id==1)
                                            <ul class="comment-reply-key" id="comment-reply-{{$item->id}}" style="display: none">
                                                <li>
                                                    <div class="reply">
                                                        <form>
                                                            <textarea name="comment" id="reply-comment-{{$item->id}}" cols="30" rows="4" class="form-control" placeholder="Viết đánh giá *"></textarea>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input value="{{Session::get('customer')->name??''}}" readonly type="text" class="form-control" id="reply-name-{{$item->id}}" name="reply_user_name_{{$item->id}}" placeholder="Tên *">
                                                                </div><!-- End .col-md-6 -->
                                                                <input type="hidden" name="reply_product_id_{{$item->id}}" value="{{$product->id}}">
                                                                <input type="hidden" name="reply_user_id_{{$item->id}}" value="{{Session::get('customer')->id??''}}">
                                                                <div class="col-md-6">
                                                                    <input value="{{Session::get('customer')->email??''}}" readonly type="text" class="form-control" id="reply-email-{{$item->id}}" name="reply_user_email_{{$item->id}}" placeholder="Email *">
                                                                </div><!-- End .col-md-6 -->
                                                            </div><!-- End .row -->
                                                            <button data-key="{{$item->id}}" type="button" class="btn btn-outline-primary-2 reply-comment">
                                                                <span>Gửi</span>
                                                                <i class="icon-long-arrow-right"></i>
                                                            </button>
                                                        </form>
                                                    </div><!-- End .reply -->
                                                </li>
                                            </ul>
                                            @endif
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div><!-- End .comments -->
                                <div class="reply">
                                    <div class="heading">
                                        <h3 style="font-family: Be VietNam" class="title">Để lại đánh giá</h3><!-- End .title -->
                                        <p style="font-family: Be VietNam;font-size: 1.5rem" class="title-desc">Địa chỉ email của bạn sẽ không được công bố. Các trường bắt buộc được đánh dấu <span class="text-danger">(*)</span></p>
                                    </div><!-- End .heading -->
                                    <form id="comment">
                                        <div style="padding-bottom: 80px;" class="rate">
                                                <input type="radio" id="star5" name="rate" value="5" />
                                                <label for="star5" title="5 stars">5 stars</label>
                                                <input type="radio" id="star4" name="rate" value="4" />
                                                <label for="star4" title="4 stars">4 stars</label>
                                                <input type="radio" id="star3" name="rate" value="3" />
                                                <label for="star3" title="3 stars">3 stars</label>
                                                <input type="radio" id="star2" name="rate" value="2" />
                                                <label for="star2" title="2 stars">2 stars</label>
                                                <input type="radio" id="star1" name="rate" value="1" />
                                                <label for="star1" title="1 star">1 star</label>
                                        </div>
                                        <textarea name="comment" id="comment-comment" cols="30" rows="4" class="form-control" placeholder="Hãy chia sẻ đánh giá của bạn *"></textarea>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input value="{{Session::get('customer')->name??''}}" readonly type="text" class="form-control" id="comment-name" name="user_name" placeholder="Tên *">
                                            </div><!-- End .col-md-6 -->
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <input type="hidden" name="user_id" value="{{Session::get('customer')->id??''}}">
                                            <div class="col-md-6">
                                                <input value="{{Session::get('customer')->email??''}}" readonly type="text" class="form-control" id="comment-email" name="user_email" placeholder="Email *">
                                            </div><!-- End .col-md-6 -->
                                        </div><!-- End .row -->
                                          <div class="row">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>Gửi</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                          </div>
                                    </form>
                                </div><!-- End .reply -->
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .product-details-tab -->

                    <h2 style="font-family: Be Vietnam; text-transform: uppercase" class="title text-center mb-4">Sản Phẩm Liên Quan</h2><!-- End .title text-center -->

                    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                        data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
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
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>
                        @foreach ($products as $v)
                        <div class="product product-7 text-center">
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
                                <input type="hidden" class="cart_product_price_{{($v->product_id??$v->id)}}" value="{{$v->discount}}">
                                @else
                                <input type="hidden" class="cart_product_price_{{($v->product_id??$v->id)}}" value="{{$v->price}}">
                                @endif
                                <div class="product-action-vertical">
                                    <a href="#" onClick="return false;" data-id_product="{{($v->product_id??$v->id)}}" style="font-family: Be VietNam" class="btn-product-icon btn-wishlist btn-expandable btn-wishlist-product" title="Wishlist"><span>Thêm Danh Sách Yêu Thích</span></a>
                                </div><!-- End .product-action-vertical -->
                                <div class="product-action">
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
                        @endforeach
                    </div><!-- End .owl-carousel -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->