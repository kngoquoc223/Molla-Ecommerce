<html>
    <head>
        <meta>
        <title>Gửi mail</title>
    </head>
    <body>
        @php 
        $method_shipping='';
        if($method_delivery == 1){
            $method_shipping='Giao hàng nhanh';
        }else if ($method_delivery == 2){
            $method_shipping='Giao hàng tiết kiệm';
        }else if ($method_delivery == 3){
            $method_shipping='Giao hàng hỏa tốc';
        }
        @endphp
        <h4><b>Đơn hàng của bạn được đặt thành công</b></h4>
        <p>Xin chào <b>{{$name}}</b></p>
        <p>Chúng tôi đã tiếp nhận và xử lý đơn hàng: <b>{{$order_code}}</b></p>
        <p>(Sử dụng mã đơn hàng để kiểm tra tình trạng đơn hàng trên website)</p>
        <h1>Thông tin khách hàng</h1>
        <p><b>Tên: </b>{{$name}}</p>
        <p><b>Email: </b>{{$email}}</p>
        <p><b>Số điện thoại: </b>{{$phone}}</p>
        <p><b>Địa chỉ giao hàng: </b>{{$address}} p.{{$ward}} Quận {{$district}} Tp.{{$province}}</p>
        <h1>Thông tin giao hàng</h1>
        <p><b>Phương thức thanh toán:</b> Thanh toán khi nhận hàng</p>
        <p><b>Phương thức vận chuyển:</b> {{$method_shipping}}</p>
        <p><b>Ghi chú:</b> {{$note}}</p>
        <p><b>Trạng thái:</b> Chờ xác nhận</p>
        <h1>Chi tiết đơn hàng</h1>
        <p>Cảm ơn bạn đã tin tưởng và ủng hộ chúng tôi.</p>
    </body>
</html>