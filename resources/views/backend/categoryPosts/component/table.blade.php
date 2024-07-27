<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center" >Tên danh mục</th>
            <th class="text-center">Slug</th>
            <th  class="text-center">Tình trạng</th>
            <th class="text-center">Update</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>

    <tbody> 
        @if(@isset($categoryPosts) && is_object($categoryPosts) )
        @foreach ($categoryPosts as $posts)
        <tr >
            <td>
            <input type="checkbox" value="{{$posts->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td class="text-center">{{$posts->name}}</td>
            <td class="text-center">{{$posts->slug}}</td>
            <td class="text-center js-switch-{{$posts->id}}">
                <input type="checkbox" class="js-switch status" data-field="publish" data-model="CategoryPosts" 
                type="checkbox" value="{{$posts->publish}}" {{($posts->publish==2) ? 'checked' :''}} 
                data-modelId="{{$posts->id}}">
            </td>
            <td class="text-center">{{$posts->updated_at}}</td>
            <td class="text-center">
                <a href="{{route('categoryPosts.edit', $posts->id)}}"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                <button data-name="{{$posts->name}}" data-code="{{$posts->id}}" class="btn btn-danger btn-circle category-posts-remove"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{
    $categoryPosts->links('pagination::bootstrap-4')
}}
<script>
    $('.category-posts-remove').on('click',function(){
        Swal.fire({
            icon: "question",
            title: "Xóa Danh Mục?",
            html: $(this).data('name')+'<br><br><i>lưu ý<span class="text-danger">(*)</span>: Sẽ xóa tất cả <span class="text-primary"><u>Bài Viết</u></span> thuộc danh mục này</i>',
            showCancelButton: true,
            showDenyButton:true,
            showConfirmButton:false,
            denyButtonText:"Chắc chắn xóa",
            cancelButtonText:"Đóng",
            }).then((result) => {
                if (result.isDenied) {
                    let _this=$(this)
                    let option = {
                        'id' : _this.data('code'),
                    }
                    $.ajax({
                    url:'/admin/posts/category/ajax/destroy',
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
                            if(res.messenger != undefined){
                                Swal.fire({
                                icon: "error",
                                title: res.messenger,
                                });
                            }else{
                                Swal.fire({
                                icon: "error",
                                title: "Xóa bản ghi không thành công.Vui lòng thử lại",
                                });
                            }
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
