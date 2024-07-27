<table class="table table-bordered" id="dataTable" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th style="width:50px;">
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th style="width:150px;">Thumb</th>
            <th  class="text-center">Thông Tin</th>
            <th style="width:200px;" class="text-center">Vị Trí</th>
            
            <th  class="text-center" style="width:150px;">Tình Trạng</th>
            <th class="text-center" style="width:120px;">Thao Tác</th>
        </tr>
    </thead>
    <tbody> 
        @if(@isset($sliders) && is_object($sliders) )
        @foreach ($sliders as $slider)
        <tr >
            <td>
            <input type="checkbox" value="{{$slider->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td>
                <div class="gallery">
                <a target="_blank" >
                  <img src="/storage/{{$slider->thumb}}">
                </a>
              </div>
            </td>
            <td>
                <div class="text-secondary">
                    <span class="text-primary">Tên Tiêu Đề:</span>
                    {{$slider->name}}</div>
                    <div class="text-primary">
                    <span class="text-danger">Đường Dẫn:</span>
                        {{$slider->url}}</div>
                        <div class="text-secondary">
                    <span class="text-danger">Mô Tả:</span>
                                {{$slider->description}}</div>
            </td>
            <td class="text-center">{{$slider->sort_by}}</td>
            <td class="text-center js-switch-{{$slider->id}}">
                <input type="checkbox" class="js-switch status " data-field="publish" data-model="Slider" 
                type="checkbox" value="{{$slider->publish}}" {{($slider->publish==2) ? 'checked' :''}} 
                data-modelId="{{$slider->id}}">
            </td>
            <td class="text-center">
                <a href="{{route('slider.edit', $slider->id)}}"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                <button data-name="{{$slider->name}}" data-code="{{$slider->id}}" class="btn btn-danger btn-circle slider-remove"><i class="fas fa-trash-alt"></i></button>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{
    $sliders->links('pagination::bootstrap-4')
}}
<script>
    $('.slider-remove').on('click',function(){
        Swal.fire({
            icon: "question",
            title: "Xóa Slider?",
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
                    url:'/admin/interface/slider/ajax/destroy',
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