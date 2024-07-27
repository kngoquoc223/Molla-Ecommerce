<table class="table table-bordered" id="dataTable" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Mã đơn hàng</th>
            <th class="text-center">Tình trạng đơn hàng</th>
            <th class="text-center">Ngày tạo</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody> 
        @if(@isset($orders) && is_object($orders) )
        @foreach ($orders as $order)
        @php
        $html='';
        if($order->status==1){
            $html='<button type="button" class="btn btn-warning btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        <span class="text">Chờ xác nhận</span>
                  </button>';
        }else if($order->status==2){
            $html='<button type="button" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="text">Xác nhận</span>
                  </button>';
        }else if($order->status==3){
            $html='<button type="button" href="#" class="btn btn-primary btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-truck"></i>
                                        </span>
                                        <span class="text">Đang vận chuyển</span>
                  </button>';
        }else if($order->status==4){
            $html='<button type="button" href="#" class="btn btn-success btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-check"></i>
                                        </span>
                                        <span class="text">Đã giao hàng</span>
                  </button>';
        }else if($order->status==5){
            $html='<button type="button" class="btn btn-danger btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Hủy đơn hàng</span>
                  </button>';
        }
        @endphp
        <tr>
            <td>
            <input type="checkbox" value="{{$order->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td class="text-center">{{$order->order_code}}</td>
            <td class="text-center">
                @php
                echo $html;
                @endphp
            </td>
            <td class="text-center">{{$order->created_at}}</td>
            <td class="text-center">
                <a href="{{route('order.detail.index',$order->order_code)}}" title="Chi tiết đơn hàng" class="btn btn-info btn-circle"><i class="fa fa-eye"></i></a>
                <button data-shipping_id="{{$order->shipping_id}}" data-code="{{$order->order_code}}" class="btn btn-danger btn-circle order-remove"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{
    $orders->links('pagination::bootstrap-4')
}}
<script>
    $('.order-remove').on('click',function(){
        Swal.fire({
            icon: "question",
            title: "Xóa đơn hàng?",
            text: 'Mã đơn hàng: '+$(this).data('code'),
            showCancelButton: true,
            showDenyButton:true,
            showConfirmButton:false,
            denyButtonText:"Xóa",
            cancelButtonText:"Đóng",
            }).then((result) => {
                if (result.isDenied) {
                    let _this=$(this)
                    let option = {
                        'order_code' : _this.data('code'),
                        'shipping_id' : _this.data('shipping_id'),
                    }
                    $.ajax({
                    url:'/admin/order/ajax/destroy',
                    type:'POST',
                    data:option,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(res){
                        if(res.flag == true){
                            Swal.fire({
                                title: "Xóa bản ghi thành công",
                                icon: "success"
                                });
                                location.reload();
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: "Xóa bản ghi không thành công.Vui lòng thử lại",
                                });
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        //Xử lý dữ liệu khi gặp lỗi 
                        console.log('Lỗi:' + textStatus + ' '+ errorThrown);
        
                    }
                })
                }
            });
    })
</script>
