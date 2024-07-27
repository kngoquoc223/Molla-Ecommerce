<table class="table table-bordered" id="dataTable" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Tên mã giảm giá</th>
            <th  class="text-center">Mã giảm giá</th>
            <th  class="text-center">Số lượng</th>
            <th  class="text-center">Điều kiện giảm</th>
            <th  class="text-center">Số giảm</th>
            <th  class="text-center">Tình Trạng</th>
            <th class="text-center">Thao Tác</th>
        </tr>
    </thead>
    <tbody> 
        @if(@isset($coupons) && is_object($coupons) )
        @foreach ($coupons as $coupon)
        <tr >
            <td>
            <input type="checkbox" value="{{$coupon->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td class="text-center">{{$coupon->coupon_name}}</td>
            <td class="text-center">{{$coupon->coupon_code}}</td>
            <td class="text-center">{{$coupon->coupon_time}}</td>
            <td class="text-center">
            <?php
            if($coupon->coupon_condition == 1){
                echo "Giảm theo %";
            }else
            {
                echo "Giảm theo Tiền";
            }
            ?></td>
            <td class="text-center">
                <?php
                            if($coupon->coupon_condition==1){
                                echo "Giảm $coupon->coupon_number%";
                            }else{
                                echo "Giảm ".number_format($coupon->coupon_number, 0, ',', '.')."đ";
                            }
                            ?>
                            </td>
            <td class="text-center js-switch-{{$coupon->id}}">
                <input type="checkbox" class="js-switch status " data-field="publish" data-model="Coupon" 
                type="checkbox" value="{{$coupon->publish}}" {{($coupon->publish==2) ? 'checked' :''}} 
                data-modelId="{{$coupon->id}}">
            </td>
            <td class="text-center">
                <a href="{{route('coupon.edit', $coupon->id)}}"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                <button data-name="{{$coupon->coupon_code}}" data-code="{{$coupon->id}}" class="btn btn-danger btn-circle coupon-remove"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{
    $coupons->links('pagination::bootstrap-4')
}}
<script>
    $('.coupon-remove').on('click',function(){
        Swal.fire({
            icon: "question",
            title: "Xóa Mã giảm giá?",
            html: $(this).data('name')+'<br><i><br>lưu ý<span class="text-danger">(*)</span>: Không thể khôi phục dữ liệu sau khi xóa hãy chắc chắn bạn muốn thực hiện chức năng này</i>',
            showCancelButton: true,
            showDenyButton:true,
            showConfirmButton:false,
            denyButtonText:"Xóa",
            cancelButtonText:"Đóng",
            }).then((result) => {
                if (result.isDenied) {
                    let _this=$(this)
                    let option = {
                        'id' : _this.data('code'),
                    }
                    $.ajax({
                    url:'/admin/coupon/ajax/destroy',
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
