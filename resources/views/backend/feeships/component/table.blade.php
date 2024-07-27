<table class="table table-bordered" id="dataTable" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Tên thành phố</th>
            <th  class="text-center">Tên quận huyện</th>
            <th  class="text-center">Tên xã phường</th>
            <th class="text-center" width="15%;">Phí ship</th>
            <th class="text-center">Thao Tác</th>
        </tr>
    </thead>
    <tbody id="feeshipTable"> 
        @if(@isset($feeships) && is_object($feeships) )
        @foreach ($feeships as $feeship)
        <tr >
            <td>
            <input type="checkbox" value="{{$feeship->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td class="text-center">{{$feeship->province->name}}</td>
            <td class="text-center">{{$feeship->district->name}}</td>
            <td class="text-center">{{$feeship->ward->name}}</td>
            <td class="text-center"><input data-id="{{$feeship->id}}" value="{{($feeship->cost!=''?number_format($feeship->cost, 0, ',', ','):'')}}" class="form-control fee-ship-eddit" type="text"></td>
            <td class="text-center">
                <button data-ward="{{$feeship->ward->name}}" data-district="{{$feeship->district->name}}" data-province="{{$feeship->province->name}}" data-id="{{$feeship->id}}" class="btn btn-danger btn-circle destroy-feeship"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{
    $feeships->links('pagination::bootstrap-4')
}}
<script>
    $('.fee-ship-eddit').on('click',function(){
        $(this).addClass('money');
        $('.money').simpleMoneyFormat();
    })
    $(document).on('blur','.fee-ship-eddit',function(){
        $(this).removeClass('money');
        var option={
            'id' : $(this).data('id'),
            'cost' : $(this).val(),
        }
        if(option['cost'] != ''){
            $.ajax({
                    url:'/admin/feeship/ajax/update',
                    type:'POST',
                    data:option,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(res){
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        //Xử lý dữ liệu khi gặp lỗi 
                        console.log('Lỗi:' + textStatus + ' '+ errorThrown);
        
                    }
                })
        }
    })
</script>
<script>
    $('.destroy-feeship').on('click',function(){
        Swal.fire({
            icon: "question",
            title: "Xóa phí ship?",
            text: $(this).data('province')+'-'+ $(this).data('district') +'-'+ $(this).data('ward'),
            showCancelButton: true,
            showDenyButton:true,
            showConfirmButton:false,
            denyButtonText:"Xóa",
            cancelButtonText:"Đóng",
            }).then((result) => {
                if (result.isDenied) {
                    let _this=$(this)
                    let option = {
                        'id' : _this.data('id'),
                    }
                    $.ajax({
                    url:'/admin/feeship/ajax/destroy',
                    type:'POST',
                    data:option,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success:function(res){
                        if(res.error == false){
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
