<table class="table table-bordered" id="dataTable" cellspacing="0" style="width:100%">
    <thead>
        <tr>
            <th class="text-center" style="width:100px;">
            <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th>Thumb</th>
            <th class="text-center">Sản Phẩm</th>
            <th class="text-center">Đơn Giá</th>
            <th class="text-center">Giá Giảm</th>
            <th class="text-center">Tình trạng</th>
            <th class="text-center" style="width:250px;">Thao tác</th>
        </tr>
    </thead>
    <tbody> 
        @if(@isset($products) && is_object($products))
        @foreach ($products as $product)
        <tr >
            <td class="text-center">
            <input type="checkbox" value="{{$product->id}}" class="input-checkbox checkBoxItem">
            </td>
            <td>
                <div style="width: 70px" class="gallery">
                <a target="_blank" >
                  <img src="/storage/{{$product->thumb}}">
                </a>
              </div>
            </td>
            <td>
                <div class="text-dark">
                    <span class="text-primary">Tên Sản Phẩm:</span>
                    {{$product->name}}</div>
                <div class="text-dark">
                    <span class="text-info">Danh Mục:</span>
                    @foreach ($categories as $category)
                       @if($category->id == $product->category_id)
                       {{$category->parent->name}} --{{$category->name}}
                    @endif
                    @endforeach
                </div>
                <div class="text-dark">
                    <span class="text-secondary">Size/Số Lượng:</span>
                    @php
                    $quantity=0;
                    foreach ($product->attr as $v) {
                        $quantity+=$v->pivot->quantity;
                        echo $v->value.'/'.$v->pivot->quantity.' ';
                    }
                    @endphp
                </div>
                <div class="text-secondary">
                    <span class="text-secondary">Tổng số lượng:</span>
                    @php 
                    echo '<span class="text-success">'.$quantity.'</span>'
                    @endphp
                </div>
            </td>
            <td>{{number_format($product->price, 0, ',', '.')}}đ</td>
            <td>{{($product->discount!='')?number_format($product->discount, 0, ',', '.'):0}}đ</td>
            <td class="text-center js-switch-{{$product->id}}">
                <input type="checkbox" class="js-switch status " data-field="publish" data-model="Product" 
                type="checkbox" value="{{$product->publish}}" {{($product->publish==2) ? 'checked' :''}} 
                data-modelId="{{$product->id}}">
            </td>
            <td class="text-center">
                <div><a href="{{route('product.edit', $product->id)}}"  class="btn btn-primary btn-circle"><i class="far fa-edit"></i></a>
                    <a href="{{route('product.delete', $product->id)}}" class="btn btn-danger btn-circle"><i class="fas fa-trash-alt"></i></a></div>
                <div>
                    <div class="p-2">                    
                        <a href="{{route('product.image.edit',$product->id)}}" class="btn btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-eye"></i>
                        </span>
                        <span class="text">Thư Viện Ảnh</span>
                    </a></div>
                    <div class="p-2">
                        <a data-id="{{$product->id}}" class="btn btn-danger btn-icon-split product-gallery-remove">
                            <span class="icon text-white-50">
                                <i class="fa fa-times"></i>
                            </span>
                            <span class="text">Xóa Thư Viện </span>
                        </a>
                    </div>
                </div>

            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{
    $products->links('pagination::bootstrap-4')
}}
<script>
    $('.product-gallery-remove').on('click',function(){
        Swal.fire({
            icon: "question",
            title: "Xóa Thư Viện Ảnh?",
            html: '<i>lưu ý<span class="text-danger">(*)</span>: Không thể khôi phục thư viện ảnh sau khi xóa.Hãy chắc chắn bạn muốn thực hiện chức năng này!!</i>',
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
                    url:'/admin/product/ajax/destroyImage',
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
