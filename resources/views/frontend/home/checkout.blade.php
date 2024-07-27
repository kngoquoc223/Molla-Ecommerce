<script>
    @if($message = session('succes_message'))
    Swal.fire({
        title: "{{ $message }}",
        icon: "success"
        });
    @endif
</script>
<main class="main">
    <div class="page-header text-center" style="background-image: url('/frontend/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 style="font-family: Be VietNam" class="page-title">Trang Thanh Toán<span style="font-family: Be VietNam">Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.index')}}">Trang Chủ</a></li>
                <li class="breadcrumb-item"><a style="font-family: Be VietNam"  href="{{route('cart.index')}}">Giỏ Hàng</a></li>
                <li style="font-family: Be VietNam" class="breadcrumb-item active" aria-current="page">Trang Thanh Toán</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <div class="page-content">
        <div class="checkout">
            <div class="container">
                <div class="checkout-discount">
                </div><!-- End .checkout-discount -->
                <form id="checkoutValidate" action="{{route('checkout.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-9">
                            <a style="font-family: Be VietNam" href="{{route('cart.index')}}"class="btn btn-outline-primary-2"><i class="icon-long-arrow-left"></i>Quay về trang giỏ hàng</a>
                            <h2 style="font-family: Be VietNam" class="checkout-title">Thông tin giao hàng</h2><!-- End .checkout-title -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input value="{{old('name',Session::get('customer')->name??'')}}" name="name" placeholder="Họ và tên" type="text" class="form-control">
                                        @if ($errors->has('name'))
                                        <label id="name-error" class="error" for="name">{{ $errors->first('name') }}</label>
                                        @endif
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input value="{{old('email',Session::get('customer')->email??'')}}" name="email" placeholder="Email" type="text" class="form-control">
                                        @if ($errors->has('email'))
                                        <label id="email-error" class="error" for="email">{{ $errors->first('email') }}</label>
                                        @endif
                                    </div><!-- End .col-sm-6 -->
                                    <div class="col-sm-6">
                                        <input value="{{old('phone',Session::get('customer')->phone??'')}}" name="phone" placeholder="Số điện thoại" type="text" class="form-control">
                                        @if ($errors->has('phone'))
                                        <label id="phone-error" class="error" for="phone">{{ $errors->first('phone') }}</label>
                                        @endif
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="select-custom">
                                            <select name="province_id" class="form-control province location" data-target="districts">
                                                <option value="0">[Chọn Thành Phố]</option>
                                                @if (isset($provinces))
                                                @foreach($provinces as $province)
                                                <option value="{{$province->code}}">{{$province->name}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div><!-- End .col-sm-6 -->
                                    @if ($errors->has('province_id'))
                                    <label id="province_id" class="error" for="province_id">{{ $errors->first('province_id') }}</label>
                                    @endif
                                    <div class="col-sm-4">
                                        <div class="select-custom">
                                            <select name="district_id" class="form-control districts location" data-target="wards">
                                                <option value="0">[Chọn Quận/Huyện]</option>
                                              </select>
                                        </div>
                                        @if ($errors->has('district_id'))
                                        <label id="district_id" class="error" for="district_id">{{ $errors->first('district_id') }}</label>
                                        @endif
                                    </div><!-- End .col-sm-6 -->
                                    <div class="col-sm-4">
                                        <div class="select-custom">
                                            <select name="ward_id" class="form-control wards">
                                                <option value="0">[Chọn Phường/Xã]</option>
                                              </select>
                                        </div>
                                        @if ($errors->has('ward_id'))
                                        <label id="ward_id" class="error" for="ward_id">{{ $errors->first('ward_id') }}</label>
                                        @endif
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                                <input value="{{old('address',Session::get('customer')->address??'')}}" name="address" placeholder="Địa chỉ cụ thể" type="text" class="form-control">
                                @if ($errors->has('address'))
                                <label id="address" class="error" for="address">{{ $errors->first('address') }}</label>
                                @endif
                                {{-- <button type="button" class="btn btn-outline-primary-2 btn-order btn-block checkout-delivery">
                                    <span class="btn-text">Xem phí vận chuyển</span>
                                    <span class="btn-hover-text">Nhấn để xem phí vận chuyển</span>
                                </button> --}}
                                <div>
                                    <label style="font-family: Be VietNam">Ghi chú đơn hàng</label>
                                <textarea name="note" class="form-control" cols="30" rows="4" placeholder="Ghi chú cho shop hoặc người giao hàng">{{old('note')}}</textarea>
                                </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="select-custom">
                                                <select name="method_payment" class="form-control method-payment">
                                                    <option value="0">[Chọn Hình Thức Thanh Toán]</option>
                                                    <option value="1">Thanh toán khi nhận hàng(COD)</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('method_payment'))
                                            <label id="method_payment" class="error" for="method_payment">{{ $errors->first('method_payment') }}</label>
                                            @endif
                                        </div><!-- End .col-sm-6 -->
                                        <div class="col-sm-6">
                                            <div class="select-custom">
                                                <select name="method_delivery" class="form-control method-delivery">
                                                    <option value="0">[Chọn Phương Thức Vận Chuyển]</option>
                                                    <option value="1">Giao hàng nhanh</option>
                                                    <option value="2">Giao hàng tiết kiệm</option>
                                                    <option value="3">Hỏa tốc</option>
                                                </select>
                                            </div>
                                            @if ($errors->has('method_delivery'))
                                            <label id="method_delivery" class="error" for="method_delivery">{{ $errors->first('method_delivery') }}</label>
                                            @endif
                                        </div><!-- End .col-sm-6 -->
                                    </div>
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
                                                    <input disabled name="cart_qty[{{$item['session_id']}}]" data-session_id={{$item['session_id']}} data-price="{{$item['product_price']}}" value="{{$item['product_qty']}}" type="number" class="form-control update-sub-total" min="1" max="10" step="1" data-decimals="0" >
                                                </div><!-- End .cart-product-quantity -->
                                            </td>
                                            <td value="{{$subtotal}}" id="total-col-{{$item['session_id']}}" class="total-col">{{number_format($subtotal, 0, ',', '.')}}đ</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td style="font-family: Be VietNam" colspan="5"><center><?php echo "Giỏ Hàng Rỗng. Hãy Tích Cực Mua Sắm!" ?></center></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table><!-- End .table table-wishlist -->
                        </div><!-- End .col-lg-9 -->
                        <aside class="col-lg-3">
                            <div class="summary">
                                <h3 style="font-family: Be VietNam" class="summary-title">Đơn hàng của bạn</h3><!-- End .summary-title -->
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
                                                <label class="custom-control-label">{{$item['coupon_code']}}</label>
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
                                        <tr class="summary-subtotal">
                                            @php
                                            $temp_total=$total-$total_coupon;
                                            @endphp
                                            <td style="font-family: Be VietNam">Phí tạm tính:</td>
                                            <td data-value="{{($temp_total<0)?0:$temp_total}}" id="temp-total-checkout">{{ $temp_total < 0 ? "0đ" : number_format($temp_total, 0, ',', '.').'đ'}}</td>
                                        </tr><!-- End .summary-subtotal -->
                                        <tr>
                                            <td>Phí Vận Chuyển:</td>
                                            <td id="cost"></td>
                                            
                                        </tr>
                                        <tr class="summary-total">
                                            <td>Tổng cộng:</td>
                                            <td id="total-checkout"></td>
                                        </tr><!-- End .summary-total -->
                                    </tbody>
                                </table><!-- End .table table-summary -->
                                <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block checkout">
                                    <span class="btn-text">Thanh Toán</span>
                                    <span class="btn-hover-text">Nhấn Để Thanh Toán</span>
                                </button>
                            </div><!-- End .summary -->
                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </form>
            </div><!-- End .container -->
        </div><!-- End .checkout -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
<script>
    var province_id = '{{(isset(Session::get('customer')->province_id)) ? Session::get('customer')->province_id : old('province_id') }}'
    var district_id = '{{(isset(Session::get('customer')->district_id)) ? Session::get('customer')->district_id : old('district_id') }}'
    var ward_id = '{{(isset(Session::get('customer')->ward_id)) ? Session::get('customer')->ward_id : old('ward_id') }}'
    var method_payment='{{old('method_payment')}}'
</script>