@if(@isset($orders) && !empty($orders))
<hr class="mt-3 mb-5 mt-md-1">
<div class="row">
    <div class="col-lg-6">
        <div class="card card-dashboard">
            <div class="card-body">
                <h3 style="font-family: Open Sans" class="card-title">Thông tin vận chuyển hàng</h3><!-- End .card-title -->
                <p style="font-family: Open Sans"><b>Tên: </b>{{$orders->name}}<br>
                <b>Email: </b>{{$orders->email}}<br>
                <b>Số điện thoại: </b>{{$orders->phone}}<br>
                <b>Địa chỉ giao hàng: </b>{{$orders->address}} p.{!! \App\Models\Ward::find($orders->ward_id)->name !!} Quận {!! \App\Models\District::find($orders->district_id)->name !!} Tp.{!! \App\Models\Province::find($orders->province_id)->name !!}<br>
                <b>Ghi chú: </b>{{$orders->note}}<br>
                <b>Phương thức thanh toán:</b> Thanh toán khi nhận hàng<br>
                @php 
                $method_shipping='';
                $status='';
                if($orders->method_delivery == 1){
                    $method_shipping='Giao hàng nhanh';
                }else if ($orders->method_delivery == 2){
                    $method_shipping='Giao hàng tiết kiệm';
                }else if ($orders->method_delivery == 3){
                    $method_shipping='Giao hàng hỏa tốc';
                }
                if($orders->status == 1){
                    $status='Chờ xác nhận';
                }else if($orders->status == 2){
                    $status='Xác nhận';
                }else if($orders->status == 3){
                    $status='Đang vận chuyển';
                }else if($orders->status == 4){
                    $status='Đã giao hàng';
                }else if($orders->status == 5){
                    $status='Hủy đơn hàng';
                }
                @endphp
                <b>Phương thức vận chuyển:</b> {{$method_shipping}}<br>
                <b>Trạng thái đơn hàng: </b><span class="text-success">{{$status}}</span><br>
            </div><!-- End .card-body -->
        </div><!-- End .card-dashboard -->
    </div><!-- End .col-lg-6 -->

    <div class="col-lg-6">
        <div class="card card-dashboard">
            <div class="card-body">
                @php
                $data=\App\Models\OrderDetail::where('order_code',$orders->order_code)->get();
                $subtotal=0;
                $total_coupon=0;
                if($orders->method_delivery==1){
                    $feeship=15000;
                }else if($orders->method_delivery==2){
                    $feeship=10000;
                }else if($orders->method_delivery==3){
                    $feeship=30000;
                }
                $shipping=\App\Models\Feeship::where('province_id',$orders->province_id)->where('district_id',$orders->district_id)->where('ward_id',$orders->ward_id)->first();
                $feeship+=$shipping->cost??0;
                @endphp
                @if($data != '')
                <h3 style="font-family: Open Sans" class="card-title">Chi tiết đơn hàng</h3><!-- End .card-title -->
                <table class="table table-cart table-mobile">
                    <tbody>
                        @foreach($data as $ordersalue)
                        @php 
                        $subtotal+=$ordersalue->product_price*$ordersalue->product_sales_qty;
                        @endphp
                        <tr>
                            <td style="padding-right: 10px;font-family: Open Sans">{{$ordersalue->product_name}}</td>
                            <td style="padding-right: 10px;font-family: Open Sans">{{$ordersalue->product_size}}</td>
                            <td style="padding-right: 10px;font-family: Open Sans">{{$ordersalue->product_sales_qty}}</td>
                            <td style="padding-right: 10px;font-family: Open Sans">{{number_format($ordersalue->product_price*$ordersalue->product_sales_qty, 0, ',', '.')}}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @php
                if($orders->coupon != ''){
                $coupon=\App\Models\Coupon::where('coupon_code',$orders->coupon)->first();
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
                    <b>Phí tạm tính: </b>{{number_format($subtotal, 0, ',', '.')}}đ<br>
                    <b>Phí giảm: </b>{{number_format($total_coupon, 0, ',', '.')}}đ<br>
                    <b>Phí vận chuyển: </b>{{number_format($feeship, 0, ',', '.')}}đ<br>
                    <b>Tổng tiền: </b>{{number_format($total+$feeship, 0, ',', '.')}}đ<br>
                </p>
                @endif
            </div><!-- End .card-body -->
        </div><!-- End .card-dashboard -->
    </div><!-- End .col-lg-6 -->
</div><!-- End .row -->
@endif
