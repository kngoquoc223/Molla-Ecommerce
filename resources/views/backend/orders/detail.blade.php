@include('backend.dashboard.component.breadcrumb',['title'=> $config['seo']['index']['title']])
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="collapse show">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <a href="{{route('order.index')}}" class="btn btn-light btn-icon-split">
                            <span class="icon text-gray-600">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Danh sách đơn hàng</span>
                        </a>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <select class="form-control order-status">
                                @php 
                                if($order->status == 1){
                                    echo 
                                    '<option selected value="1">Chờ xác nhận</option>
                                    <option value="2">Xác nhận</option>';
                                }else if($order->status == 2){
                                    echo '<option selected value="2">Xác nhận</option>
                                        <option value="3">Đang vận chuyển</option>
                                        <option value="5">Hủy đơn hàng</option>';
                                }else if($order->status == 3){
                                    echo '
                                    <option selected value="3">Đang vận chuyển</option>
                                    <option value="4">Đã giao hàng</option>
                                    <option value="5">Hủy đơn hàng</option>
                                    ';
                                }else if($order->status == 4){
                                    echo '<option selected value="4">Đã giao hàng</option>';
                                }else if($order->status == 5){
                                    echo '<option value="1">Chờ xác nhận</option>
                                    <option selected value="5">Hủy đơn hàng</option>
                                    ';
                                }
                                @endphp
                                {{-- @foreach(config('apps.general.order_status') as $key => $val)
                                <option {{($order->status==$key)? 'selected' : ''}} value="{{$key}}">{{$val}}</option>
                                @endforeach --}}
                            </select>
                            <button data-order_code="{{$order->order_code}}" data-id="{{$order->id}}" type="button" class="btn btn-success mb0 btn-m update-status-order">Cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Thông Tin Vận Chuyển Hàng</h6>
            <div class="ibox-tools">
                <a class="order-detail-link" href="#orderDetailCardExample" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <i class="orderDetail fa fa-chevron-down"></i>
                </a>
            </div>
            <script>
                  $('.order-detail-link').on('click', function () {
                    $('.orderDetail').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up')
                });
            </script>
        </div>
        <div class="collapse show" id="orderDetailCardExample">
            <div class="card-body">
                <div id="dataTable_wrapper" class="dataTable_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                    @include('backend.orders.component.shipping-table')
                        </div>
                    </div>
                </div>
                </div>
        </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Chi Tiết Đơn Hàng</h6>
                <div class="ibox-tools">
                    <a class="shipping-link" href="#shippingCardExample" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <i class="shipping fa fa-chevron-down"></i>
                    </a>
                </div>
                <script>
                      $('.shipping-link').on('click', function () {
                        $('.shipping').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up')
                    });
                </script>
            </div>
            <div class="collapse show" id="shippingCardExample">
                <div class="card-body">
                    <div id="dataTable_wrapper" class="dataTable_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                        @include('backend.orders.component.order-detail-table')
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
    <script>
        var order_status='{{$order->status}}';
    </script>
    <script>
        $('.update-status-order').on('click',function(){
            if(order_status == $('.order-status').val() ){
                Swal.fire({
                title: "Chọn trạng thái đơn hàng muốn cập nhật!!",
                html: 'Chú ý<span class="text-danger">(*)</span>: Hãy chọn trạng thái mới của đơn hàng',
                icon: "question"
                });
            }else
            {
                var option={
                'status' : $('.order-status').val(),
                'order_id' : $(this).data('id'),
                'order_code' : $(this).data('order_code'),
            }
            $.ajax({
            url:'/admin/order/ajax/update/status',
            type:'POST',
            data: option,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success:function(res){
                if(res.flag==true){
                    order_status=$('.order-status').val();
                    let text='';
                    if($('.order-status').val() == 1){
                        text='<option selected value="1">Chờ xác nhận</option><option value="2">Xác nhận</option>'
                    }else if($('.order-status').val() == 2){
                        text='<option selected value="2">Xác nhận</option><option value="3">Đang vận chuyển</option><option value="5">Hủy đơn hàng</option>'
                    }else if($('.order-status').val() == 3){
                        text='<option selected value="3">Đang vận chuyển</option><option value="4">Đã giao hàng</option><option value="5">Hủy đơn hàng</option>'
                    }else if($('.order-status').val() == 4){
                        text='<option selected value="4">Đã giao hàng</option>'
                    }else if($('.order-status').val() == 5){
                        text='<option value="1">Chờ xác nhận</option><option selected value="5">Hủy đơn hàng</option>'
                    }
                    $('.order-status').empty().append(text);
                    Swal.fire({
                        title: "Cập nhật tình trạng thành công",
                        icon: "success"
                        });
                        setTimeout(function(){
                        window.location.reload(1);
                        }, 1500);
                }else{
                    Swal.fire({
                        title: "Cập nhật tình trạng thất bại!!",
                        html: 'Chú ý<span class="text-danger">(*)</span>: Vui lòng bổ sung số lượng kho và thử lại.',
                        icon: "error"
                        });
                }
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                Swal.fire({
                        title: "Cập nhật tình trạng thất bại.Vui lòng thử lại.",
                        icon: "error"
                        });
            }
        })
        }
        })
    </script>