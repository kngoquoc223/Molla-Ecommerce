<table class="table table-bordered" id="dataTable" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Thumb</th>
            <th class="text-center">Tên sản phẩm</th>
            <th class="text-center">Size</th>
            @if($order->status==1)
            <th class="text-center">Số lượng kho</th>
            @endif
            <th class="text-center">Giá sản phẩm</th>
            <th class="text-center">Số lượng đơn đặt</th>
            <th class="text-center">Thành Tiền</th>
        </tr>
    </thead>
    <tbody> 
        @php
        $subtotal=0;          
        if($shipping->method_delivery==1){
            $feeship=15000;
        }else if($shipping->method_delivery==2){
            $feeship=10000;
        }else if($shipping->method_delivery==3){
            $feeship=30000;
        }
        $feeship+=$shipping->getCost($shipping->province_id,$shipping->district_id,$shipping->ward_id)->cost??0;
        @endphp
        @if(@isset($order_details) && is_object($order_details))
        @foreach ($order_details as $order_detail)
        @if($order_detail->product != null)
        <tr>
            <td>
            <input type="checkbox" value="{{$order_detail->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td>
                <div style="width: 70px" class="gallery">
                <a target="_blank" >
                  <img src="/storage/{{$order_detail->product->thumb}}">
                </a>
              </div>
            </td>
            <td class="text-center"><a href="{{route('product.edit',$order_detail->product->id)}}">{{$order_detail->product_name}}</a></td>
            <td class="text-center">{{$order_detail->product_size}}</td>
            @if($order->status==1)
            @php
            $total=0;
            foreach ($order_detail->product->attr as $key => $v) {
                if($order_detail->product_size==$v->value){
                    $total+=$v->pivot->quantity;
                }
            }
            @endphp
            <td class="text-center">{{$total}}</td>
            @endif
            <td class="text-center">{{number_format($order_detail->product_price, 0, ',', '.')}}đ</td>
            <td class="text-center">{{$order_detail->product_sales_qty}}</td>
            <td class="text-center">{{number_format($order_detail->product_price*$order_detail->product_sales_qty, 0, ',', '.')}}đ</td>
            @php 
            $subtotal+=$order_detail->product_price*$order_detail->product_sales_qty;
            @endphp
        </tr>
        @else
        <tr>
            <td style="text-align: center" colspan="8"><p>Sản phẩm đã xóa</p></td>
        </tr>
        @endif
        @endforeach
        @endif
        <tr>
            @php
                $total_coupon=0;
                if(isset($coupon)){
                    if($coupon->coupon_condition == 1)
                $total_coupon=($subtotal*$coupon->coupon_number)/100;
                else{
                    $total_coupon=$coupon->coupon_number;
                }
                }
                $total=($subtotal-$total_coupon);
                if($total<0){
                    $total=0;
                }
            @endphp
            <td style="text-align: right" colspan="8">
                <p><i>Mã giảm: {{$coupon->coupon_code??''}} </i></p>
                <p><i>Phí giảm: {{number_format($total_coupon, 0, ',', '.')}}đ</i></p>
                <p><i>Phí vận chuyển: {{number_format($feeship, 0, ',', '.')}}đ</i></p>
            </td>
        </tr>
        <tr>
            <td style="text-align: right" colspan="8">
                <p><b>Tổng Tiền: {{number_format($total+$feeship, 0, ',', '.')}}đ</b></p>
            </td>
        </tr>
    </tbody>
</table>

