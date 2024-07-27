<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th class="text-center" style="width:100px;">
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Hình ảnh</th>
            <th class="text-center">Bài viết</th>
            <th class="text-center" style="width:150px;">Tình trạng</th>
            <th class="text-center" style="width:150px;">Thao tác</th>
        </tr>
    </thead>

    <tbody> 
        @if(@isset($posts) && is_object($posts) )
        @foreach ($posts as $v)
        <tr >
            <td class="text-center">
            <input type="checkbox" value="{{$v->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td>
                <div style="width: 70px" class="gallery">
                <a target="_blank" >
                  <img src="/storage/{{$v->image}}">
                </a>
              </div>
            </td>
            <td>
                <div class="text-dark">
                    <span class="text-primary">Tiêu đề:</span>
                    <b>{{$v->title}}</b>
                </div>
                <div class="text-dark">
                    <span class="text-secondary">Slug:</span>
                    {{$v->slug}}
                </div>
                <div class="text-dark">
                    <span class="text-primary">Danh mục:</span>
                    {{$v->category->name}}
                </div>
                <div class="text-dark">
                    <span class="text-secondary">Từ khóa bài viết:</span>
                    {{$v->meta_keywords}}
                </div>
                <div class="text-dark">
                    <span class="text-secondary">Mô tả ngắn:</span>
                    {!!$v->desc!!}
                </div>
                <div class="text-dark">
                    <span class="text-secondary">Tác giả:</span>
                    {{$v->user->name??'Người dùng đã xóa'}}
                </div>
            </td>
            <td class="text-center js-switch-{{$v->id}}">
                <input type="checkbox" class="js-switch status" data-field="publish" data-model="Posts" 
                type="checkbox" value="{{$v->publish}}" {{($v->publish==2) ? 'checked' :''}} 
                data-modelId="{{$v->id}}">
            </td>
            <td class="text-center">
                <a href="{{route('posts.edit', $v->id)}}"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                <button data-id="{{$v->id}}" data-title="{{$v->title}}" class="btn btn-danger btn-circle posts-remove"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{
    $posts->links('pagination::bootstrap-4')
}}
<script>
    $('.posts-remove').on('click',function(){
        Swal.fire({
            icon: "question",
            title: "Xóa bài viết?",
            text: 'Tiêu đề: '+$(this).data('title'),
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
                    url:'/admin/posts/ajax/destroy',
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