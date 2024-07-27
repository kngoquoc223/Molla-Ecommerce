<table class="table table-bordered" id="dataTable" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Tên</th>
            <th  class="text-center">Slug</th>
            <th  class="text-center">Update</th>
            <th  class="text-center">Tình Trạng</th>
            {{-- <th class="text-center">Thao Tác</th> --}}
        </tr>
    </thead>
    <tbody> 
        @if(@isset($menus) && is_object($menus) )
        @foreach ($menus as $menu)
        <tr >
            <td>
            <input type="checkbox" value="{{$menu->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td class="text-center">{{$menu->name}}</td>
            <td class="text-center">{{$menu->slug}}</td>
            <td class="text-center">{{$menu->updated_at}}</td>
            <td class="text-center js-switch-{{$menu->id}}">
                <input type="checkbox" class="js-switch status " data-field="publish" data-model="Menu" 
                type="checkbox" value="{{$menu->publish}}" {{($menu->publish==2) ? 'checked' :''}} 
                data-modelId="{{$menu->id}}">
            </td>
            {{-- <td class="text-center">
                <a href="{{route('menu.edit', $menu->id)}}"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                <button data-name="{{$menu->name}}" data-code="{{$menu->id}}" class="btn btn-danger btn-circle menu-remove"><i class="fas fa-trash-alt"></i></button>
            </td> --}}
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{
    $menus->links('pagination::bootstrap-4')
}}
<script>
    $('.menu-remove').on('click',function(){
        Swal.fire({
            icon: "question",
            title: "Xóa menu?",
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
                    url:'/admin/interface/menu/ajax/destroy',
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