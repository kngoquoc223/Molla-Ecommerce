<main class="main">
    <div class="page-header text-center" style="background-image: url('/frontend/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 style="font-family: Be VietNam" class="page-title">Tài khoản</h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.index')}}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a style="font-family: Be VietNam" href="{{route('home.user.myUser')}}">Tài khoản</a></li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row">
                    <aside class="col-md-4 col-lg-3">
                        <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                            <li class="nav-item">
                                <a style="font-family: Be VietNam" class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Tổng quan</a>
                            </li>
                            <li class="nav-item">
                                <a style="font-family: Be VietNam" class="nav-link" id="tab-account-link" data-toggle="tab" href="#tab-account" role="tab" aria-controls="tab-account" aria-selected="false">Thông tin tài khoản</a>
                            </li>
                            <li class="nav-item">
                                <a style="font-family: Be VietNam" class="nav-link" id="tab-orders-link" data-toggle="tab" href="#tab-orders" role="tab" aria-controls="tab-orders" aria-selected="false">Xem đơn hàng</a>
                            </li>
                            <li class="nav-item">
                                <a style="font-family: Be VietNam" class="nav-link" id="tab-email-link" data-toggle="tab" href="#tab-email" role="tab" aria-controls="tab-email" aria-selected="false">Thay đổi Email</a>
                            </li>
                            <li class="nav-item">
                                <a style="font-family: Be VietNam" class="nav-link" id="tab-password-link" data-toggle="tab" href="#tab-password" role="tab" aria-controls="tab-password" aria-selected="false">Thay đổi mật khẩu</a>
                            </li>
                            <li class="nav-item">
                                <a style="font-family: Be VietNam" class="nav-link" href="{{route('home.user.logout')}}">Đăng xuất</a>
                            </li>
                        </ul>
                    </aside><!-- End .col-lg-3 -->

                    <div class="col-md-8 col-lg-9">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel" aria-labelledby="tab-dashboard-link">
                                <p style="font-family: Be VietNam">Xin chào <span class="font-weight-normal text-dark">{{Session::get('customer')->name}}</span> (không phải <span class="font-weight-normal text-dark">{{Session::get('customer')->name}}</span>? <a href="{{route('home.user.logout')}}">Đăng xuất</a>) 
                                <br>
                                Từ đây, bạn có thể <a style="font-family: Be VietNam" href="#tab-orders" class="tab-trigger-link link-underline">xem đơn hàng</a> gần đây, 
                                quản lý địa chỉ giao hàng và thanh toán cũng như 
                                <a style="font-family: Be VietNam" href="#tab-password" class="tab-trigger-link link-underline">chỉnh sửa mật khẩu </a>
                                 và <a style="font-family: Be VietNam" href="#tab-account" class="tab-trigger-link link-underline">chi tiết tài khoản của mình</a>.
                                </p>
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="tab-account" role="tabpanel" aria-labelledby="tab-account-link">
                                <form id="updateUser">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Họ và tên</label>
                                            <input name="name" type="text" class="form-control" value="{{old('name', Session::get('customer')->name ?? '')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Email</label>
                                            <input readonly type="text" class="form-control" value="{{old('email',Session::get('customer')->email ?? '')}}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Ngày sinh</label>
                                            <input id="birthday" name="birthday" type="date" class="form-control" value="{{old('birthday',(isset(Session::get('customer')->birthday)) ? date('Y-m-d',strtotime(Session::get('customer')->birthday)):'')}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Số điện thoại</label>
                                            <input name="phone" type="text" class="form-control" value="{{old('phone',Session::get('customer')->phone ?? '')}}">
                                        </div>
                                    </div>

                                    <label>Địa chỉ <span class="text-danger">(*)</span></label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="select-custom">
                                                <select name="province_id" class="form-control province location" data-target="districts">
                                                    <option value="0">[Chọn Thành Phố]</option>
                                                    @if (isset($provinces))
                                                    @foreach($provinces as $province)
                                                    <option @if(old('province_id') == $province->code) selected @endif value="{{$province->code}}">{{$province->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div><!-- End .col-sm-6 -->
                                        <div class="col-sm-4">
                                            <div class="select-custom">
                                                <select name="district_id" class="form-control districts location" data-target="wards">
                                                    <option value="0">[Chọn Quận/Huyện]</option>
                                                  </select>
                                            </div>
                                        </div><!-- End .col-sm-6 -->
                                        <div class="col-sm-4">
                                            <div class="select-custom">
                                                <select name="ward_id" class="form-control wards">
                                                    <option value="0">[Chọn Phường/Xã]</option>
                                                  </select>
                                            </div>
                                        </div><!-- End .col-sm-6 -->
                                    </div><!-- End .row -->
                                    <script>
                                        var user_id = '{{Session::get('customer')->id??''}}'
                                        var province_id = '{{ (isset(Session::get('customer')->province_id)) ? Session::get('customer')->province_id : old('province_id') }}'
                                        var district_id = '{{ (isset(Session::get('customer')->district_id)) ? Session::get('customer')->district_id : old('district_id') }}'
                                        var ward_id = '{{ (isset(Session::get('customer')->ward_id)) ? Session::get('customer')->ward_id : old('ward_id') }}'
                                    </script>

                                    <label>Địa chỉ cụ thể <span class="text-danger">(*)</span></label>
                                    <input name="address" type="text" class="form-control" value="{{old('address',Session::get('customer')->address ?? '')}}">

                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>Cập nhật</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </form>
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="tab-orders" role="tabpanel" aria-labelledby="tab-orders-link">
                                @if(!$orders->isEmpty())
                                <p style="font-family: Open Sans;font-size: 2rem"><b>Bạn hiện có {{count($orders)}} đơn hàng</b></p>
                                @foreach($orders as $v)
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 style="font-family: Open Sans" class="card-title">Thông tin vận chuyển hàng</h3><!-- End .card-title -->
                                                <p style="font-family: Open Sans">
                                                <b>Mã đơn hàng: </b>{{$v->order_code}}<br>
                                                <b>Tên: </b>{{$v->name}}<br>
                                                <b>Email: </b>{{$v->email}}<br>
                                                <b>Số điện thoại: </b>{{$v->phone}}<br>
                                                <b>Địa chỉ giao hàng: </b>{{$v->address}} p.{!! \App\Models\Ward::find($v->ward_id)->name !!} Quận {!! \App\Models\District::find($v->district_id)->name !!} Tp.{!! \App\Models\Province::find($v->province_id)->name !!}<br>
                                                <b>Ghi chú: </b>{{$v->note}}<br>
                                                <b>Phương thức thanh toán:</b> Thanh toán khi nhận hàng<br>
                                                @php 
                                                $method_shipping='';
                                                $status='';
                                                if($v->method_delivery == 1){
                                                    $method_shipping='Giao hàng nhanh';
                                                }else if ($v->method_delivery == 2){
                                                    $method_shipping='Giao hàng tiết kiệm';
                                                }else if ($v->method_delivery == 3){
                                                    $method_shipping='Giao hàng hỏa tốc';
                                                }
                                                if($v->status == 1){
                                                    $status='Chờ xác nhận';
                                                }else if($v->status == 2){
                                                    $status='Xác nhận';
                                                }else if($v->status == 3){
                                                    $status='Đang vận chuyển';
                                                }else if($v->status == 4){
                                                    $status='Đã giao hàng';
                                                }else if($v->status == 5){
                                                    $status='Hủy đơn hàng';
                                                }
                                                @endphp
                                                <b>Phương thức vận chuyển:</b> {{$method_shipping}}<br>
                                                <b>Trạng thái đơn hàng: </b><span class="text-success">{{$status}}</span><br>
                                                <a href="#" onClick="return false;">Edit <i class="icon-edit"></i></a></p>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->

                                    <div class="col-lg-6">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                @php
                                                $data=\App\Models\OrderDetail::where('order_code',$v->order_code)->get();
                                                $subtotal=0;
                                                $total_coupon=0;
                                                if($v->method_delivery==1){
                                                    $feeship=15000;
                                                }else if($v->method_delivery==2){
                                                    $feeship=10000;
                                                }else if($v->method_delivery==3){
                                                    $feeship=30000;
                                                }
                                                $shipping=\App\Models\Feeship::where('province_id',$v->province_id)->where('district_id',$v->district_id)->where('ward_id',$v->ward_id)->first();
                                                $feeship+=$shipping->cost??0;
                                                @endphp
                                                @if($data != '')
                                                <h3 style="font-family: Open Sans" class="card-title">Chi tiết đơn hàng</h3><!-- End .card-title -->
                                                <table class="table table-cart table-mobile">
                                                    <tbody>
                                                        @foreach($data as $value)
                                                        @php 
                                                        $subtotal+=$value->product_price*$value->product_sales_qty;
                                                        @endphp
                                                        <tr>
                                                            <td style="padding-right: 10px;font-family: Open Sans">{{$value->product_name}}</td>
                                                            <td style="padding-right: 10px;font-family: Open Sans">{{$value->product_size}}</td>
                                                            <td style="padding-right: 10px;font-family: Open Sans">{{$value->product_sales_qty}}</td>
                                                            <td style="padding-right: 10px;font-family: Open Sans">{{number_format($value->product_price*$value->product_sales_qty, 0, ',', '.')}}đ</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                @php
                                                if($v->coupon != ''){
                                                $coupon=\App\Models\Coupon::where('coupon_code',$v->coupon)->first();
                                                    if($coupon->coupon_condition == 1){
                                                    $total_coupon=($subtotal*$coupon->coupon_number)/100;
                                                    }
                                                    else{
                                                    $total_coupon=$coupon->coupon_number;
                                                    }
                                                }
                                                $total=$subtotal - $total_coupon;
                                                if($total<0){
                                                    $total=0;
                                                }
                                                @endphp
                                                <p style="font-family: Open Sans">
                                                    <b>Phí giảm: </b>{{number_format($total_coupon, 0, ',', '.')}}đ<br>
                                                    <b>Phí vận chuyển: </b>{{number_format($feeship, 0, ',', '.')}}đ<br>
                                                    <b>Tổng tiền: </b>{{number_format($total+$feeship, 0, ',', '.')}}đ<br>
                                                    <a href="#" onClick="return false;">Edit <i class="icon-edit"></i></a>
                                                </p>
                                                @endif
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                                @endforeach
                                @else
                                <div class="row">
                                    <p style="font-family: Be VietNam">Bạn chưa có đơn hàng</p>
                                </div>
                                @endif
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="tab-email" role="tabpanel" aria-labelledby="tab-email-link">
                                <form id="changeEmail">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Nhập Email mới <span class="text-danger">(*)</span></label>
                                            <input name="email" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>Thay đổi</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </form>
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="tab-password" role="tabpanel" aria-labelledby="tab-password-link">
                                <form id="changePassword">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Mật khẩu cũ <span class="text-danger">(*)</span></label>
                                            <input id="password_old" name="password_old" type="password" class="form-control showPassword">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Mật khẩu mới <span class="text-danger">(*)</span></label>
                                            <input id="password" name="password" type="password" class="form-control showPassword">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Nhập lại mật khẩu mới <span class="text-danger">(*)</span></label>
                                            <input id="re_password" name="re_password" type="password" class="form-control showPassword">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="checkbox" onclick="myFunction()">
                                            <label style="font-family: Open Sans">Hiển thị mật khẩu</label>
                                        </div>
                                    </div>
                                    <script>
                                        function myFunction() {
                                            var x = document.getElementsByClassName("showPassword");
                                            for (var i = 0; i < x.length; i++) {
                                            if (x[i].type === "password") {
                                                x[i].type = "text";
                                            } else {
                                                x[i].type = "password";
                                            }
                                            }
                                            }
                                    </script>
                                    <button type="submit" class="btn btn-outline-primary-2">
                                        <span>Thay đổi</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </form>
                            </div><!-- .End .tab-pane -->
                        </div>
                    </div><!-- End .col-lg-9 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
</main><!-- End .main -->