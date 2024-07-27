<main class="main">
    <div class="page-header text-center" style="background-image: url('/frontend/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 style="font-family: Be VietNam" class="page-title">Giỏ Hàng<span>Sản Phẩm</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.index')}}">Trang Chủ</a></li>
                <li style="font-family: Be VietNam" class="breadcrumb-item active" aria-current="page">Giỏ Hàng</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th style="font-family: Be VietNam">Sản Phẩm</th>
                                    <th style="font-family: Be VietNam">Size</th>
                                    <th style="font-family: Be VietNam">Giá Sản Phẩm</th>
                                    <th style="font-family: Be VietNam">Số Lượng</th>
                                    <th style="font-family: Be VietNam">Thành Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total=0;
                                @endphp
                                @if(Session::get('cart') == true)
                                @foreach (Session::get('cart') as $item)
                                @php
                                $subtotal=$item['product_price'] * $item['product_qty'];
                                $total+=$subtotal;
                                // echo $price * $item['product_qty'];
                                @endphp
                                <tr id="product-id-session-{{$item['session_id']}}">
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="/storage/{{$item['product_thumb']}}">
                                                    <img src="/storage/{{$item['product_thumb']}}" alt="Product image">
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a style="font-family: Be VietNam" href="{{route('home.product.index',["id" => $item['product_id'],"name"=> $item['product_name']])}}">{{$item['product_name']}}</a>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td class="price-col">{{$item['product_size']}}
                                    </td>
                                    <td class="price-col">{{number_format($item['product_price'], 0, ',', '.')}}đ</td>
                                    <td class="quantity-col">
                                        <div class="cart-product-quantity">
                                            <input name="cart_qty[{{$item['session_id']}}]" data-session_id={{$item['session_id']}} data-price="{{$item['product_price']}}" value="{{$item['product_qty']}}" type="number" class="form-control update-sub-total" min="1" max="10" step="1" data-decimals="0" >
                                        </div><!-- End .cart-product-quantity -->
                                    </td>
                                    <td value="{{$subtotal}}" id="total-col-{{$item['session_id']}}" class="total-col">{{number_format($subtotal, 0, ',', '.')}}đ</td>
                                    <td class="remove-col"><button data-session_id={{$item['session_id']}} class="btn-remove delete-cart"><i class="icon-close"></i></button></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="5"><center><?php echo "Hiện chưa có sản phẩm!" ?></center></td>
                                </tr>
                                @endif
                            </tbody>
                        </table><!-- End .table table-wishlist -->
                        <div class="cart-bottom">
                            <div class="cart-discount">
                                <form action="{{route('cart.checkCoupon')}}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input name="coupon" type="text" class="form-control" required placeholder="Nhập mã giảm giá">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
                                        </div><!-- .End .input-group-append -->
                                    </div><!-- End .input-group -->
                                </form>
                            </div><!-- End .cart-discount -->
                            <button data-toggle="modal" data-target="#exampleModalCenter" type="button" class="btn btn-outline-primary-2" ><span>Danh sách mã Coupon</span></button>
                        </div><!-- End .cart-bottom -->
                        <a style="font-family: Be VietNam" href="{{route('home.index')}}" class="btn btn-outline-dark-2 btn-block mb-3"><span>TIẾP TỤC MUA SẮM</span><i class="icon-long-arrow-left"></i></a>
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title --> 

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td style="font-family: Be VietNam">Tổng tiền hàng:</td>
                                        <td id="total">{{number_format($total, 0, ',', '.')}}đ</td>
                                    </tr><!-- End .summary-subtotal -->
                                    <tr class="summary-shipping">
                                        <td style="font-family: Be VietNam">Mã giảm:</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    @php
                                    $total_coupon=0;
                                    @endphp
                                    @if(Session::get('coupon'))
                                    @foreach (Session::get('coupon') as $item)
                                    <tr class="summary-shipping-row">
                                        <td>
                                            <label class="custom-control-label"><button data-coupon_code="{{$item['coupon_code']}}" class="btn-remove delete-coupon"><i class="icon-close"></i></button>{{$item['coupon_code']}}</label>
                                        </td>
                                        @if($item['coupon_condition'] == 1)
                                        <td class="coupon" data-value="{{$item['coupon_number']}}" data-condition="{{$item['coupon_condition']}}">Giảm {{$item['coupon_number']}}%</td>
                                        @php 
                                        $total_coupon=($total*$item['coupon_number'])/100;
                                        @endphp
                                        @else
                                        <td class="coupon" data-value="{{$item['coupon_number']}}" data-condition="{{$item['coupon_condition']}}">Giảm {{number_format($item['coupon_number'], 0, ',', '.')}}đ</td>
                                        @php 
                                        $total_coupon=$item['coupon_number'];
                                        @endphp
                                        @endif
                                    </tr><!-- End .summary-shipping-row -->
                                    @endforeach
                                    @endif
                                    @php
                                    @endphp
                                    <tr class="summary-subtotal">
                                        <td style="font-family: Be VietNam">Tổng giảm:</td>
                                        <td data-total_coupon={{$total_coupon}} id="total-coupon">{{number_format($total_coupon, 0, ',', '.')}}đ</td>
                                    </tr><!-- End .summary-subtotal -->

                                    <tr class="summary-total">
                                        @php
                                        $total_checkout=$total-$total_coupon;
                                        @endphp
                                        <td style="font-family: Be VietNam">Tổng Thanh Toán:</td>
                                        <td id="total-checkout">{{ $total_checkout < 0 ? "0đ" : number_format($total_checkout, 0, ',', '.').'đ'}}</td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->
                            <a href="{{!empty(Session::get('cart'))?route('checkout.index'):'#'}}" style="font-family: Be VietNam" class="btn btn-outline-primary-2 btn-order btn-block">ĐẾN TRANG THANH TOÁN</a>
                        </div><!-- End .summary -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 style="font-family: Be VietNam" class="text-center"><b>Danh sách mã khuyến mãi:</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <br>
        <div class="modal-body">
            @if(@isset($coupons) && is_object($coupons) )
            @foreach ($coupons as $key => $coupon)
            <div class="row">
            <div class="col"></div>
            <div class="col-md-10">
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
                                <button type="button" onclick="copy(this,'#copyToClipboard{{$key}}')" style="font-family: Be VietNam"
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
            <hr>
            @endforeach
            @endif
            <script src="/frontend/library/script.js"></script>
        </div>
      </div>
    </div>
  </div>


