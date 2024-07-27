@php 
    $link=($config['method'] == 'create') ? $config['seo']['create'] :  $config['seo']['edit']
@endphp
@include('backend.dashboard.component.breadcrumb',['title'=> $link['title']])
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{$link['tableHeading']}}</h6>
        </div>
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
         @php 
          $url=($config['method'] == 'create' ) ? route('product.store') : route('product.update', $product->id);
        @endphp
        <form action="{{$url}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-description">
                            <p>Nhập thông tin sản phẩm</p>
                            <p>Lưu ý: Trường đánh dấu <span class="text-danger">(*)</span> là thông tin bắt buộc</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <ul class="nav nav-tabs">
                          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Thông Tin Sản Phẩm</a></li>
                          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">Mô Tả</a></li>
                          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2">Thuộc Tính</a></li>
                          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu3">Ảnh Sản Phẩm</a></li>
                        </ul>
                        <div class="tab-content">
                          <div id="home" class="tab-pane fade in active show">
                            <div class="card-body">
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label  class="control-lable text-left">Tên sản phẩm<span class="text-danger">(*)</span></label>
                                      <input  name="name" type="text" class="form-control"  value="{{old('name', $product->name ?? '')}}">
                                    </div>
                                  </div>
                                  <div class="form-row">
                                      <div class="form-group col-md-6">
                                          <label class="control-lable text-left">Danh Mục Cha<span class="text-danger">(*)</span></label>
                                          <select name="catParent" class="form-control setupSelect2 parent getCat" data-target=categories>
                                            <option value="0">--Chọn Danh Mục Sản Phẩm--</option>
                                            @if(isset($listCategory))
                                            @foreach ($listCategory as $category)                          
                                          <option @if(old('catParent') == $category->id) selected @endif value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                            @endif
                                          </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                          <label class="control-lable text-left">Danh Mục Phụ<span class="text-danger">(*)</span></label>
                                          <select name="category_id" class="form-control setupSelect2 categories">
                                          </select>
                                        </div>
                                  </div>
                          </div>
                          </div>
                          <div id="menu1" class="tab-pane fade">
                            <div class="card-body">
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for=""class="control-lable text-left">Mô tả</label>
                                    <input name="content" type="text" class="form-control"  placeholder="" value="{{old('content',$product->content ?? '')}}">
                                  </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label>Mô Tả Chi Tiết Sản Phẩm</label>
                                  <textarea name="description" id="editor1" rows="10" cols="80" >{{old('description', $product->description ?? '')}}</textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="menu2" class="tab-pane fade">
                            <div class="card-body">
                               <div class="form-row">
                                <div class="form-group col-md-12">
                                  <div id="show-item">
                                    @php 
                                    $option='';
                                    $option.='<option class="text-center" value="0">--Chọn Size--</option>';
                                    foreach($attributeValues as $k => $v){
                                      $option.='<option class="text-center" value="'.$v->id.'">'.$v->value.'</option>';
                                    }
                                    $output='';
                                    $attrsValue= old('attr', $attrs ?? []);
                                    if(count($attrsValue) != 0){
                                      $length = count($attrsValue) -1 ;
                                      // foreach ($attrsValue as $key => $value) {
                                        foreach(range($length,0) as $i){
                                        $attr_value_id=$attrsValue[$i]['attr_value_id'];
                                        $quantity=$attrsValue[$i]['quantity'];
                                        $output.='<div class="row">
                                        <div class="col-md-4 mb-3">
                                          <select class="form-control attr_value" name="attr['.$i.'][attr_value_id]">
                                            <option class="text-center" value="0">--Chọn Size--</option>';
                                            foreach ($attributeValues as $k => $v) {
                                              $output.='<option '.($v->id == $attr_value_id ? 'selected' : '').' class="text-center" value="'.$v->id.'">'.$v->value.'</option>';
                                            }
                                            $output.='</select>
                                          </div>
                                          <div class="col-md-4 mb-3">
                                            <input placeholder="Số Lượng" value="'.$quantity.'" class="form-control attr_quantity" type="number" name="attr['.$i.'][quantity]"></div>
                                            <div class="col-md-4 mb-3"><button type="button" class="'.($i==0?'btn btn-success add_item_btn': 'btn btn-danger remove_item_btn').'">'.($i==0?'+':'-').'</button>
                                              </div>
                                              </div>';
                                      }
                                    }
                                    if($output != ''){
                                      echo $output;
                                    }else{
                                      echo '<div class="row">
                                      <div class="col-md-4 mb-3">
                                        <select class="form-control attr_value" name="attr[0][attr_value_id]">
                                          <option class="text-center" value="0">--Chọn Size--</option>';
                                          foreach ($attributeValues as $item){
                                          echo  '<option class="text-center" value="'.$item->id.'">'.$item->value.'</option>';
                                          }
                                          echo '</select>
                                    </div>
                                      <div class="col-md-4 mb-3"><input placeholder="Số Lượng" class="form-control attr_quantity" type="number" name="attr[0][quantity]"></div>
                                      <div class="col-md-4 mb-3"><button type="button" class="btn btn-success add_item_btn">+</button></div>
                                    </div>';
                                    }
                                    @endphp
                                    {{-- <div class="row">
                                      <div class="col-md-4 mb-3">
                                        <select class="form-control" name="attr[{{$arr??0}}][attr_value_id]" id="attr">
                                          <option class="text-center" value="0">--Chọn Size--</option>
                                          @if(isset($attributeValues))
                                          @foreach ($attributeValues as $item)
                                          <option class="text-center" value="{{$item->id}}">{{$item->value}}</option>
                                          @endforeach
                                          @endif
                                      </select>
                                    </div>
                                      <div class="col-md-4 mb-3"><input placeholder="Số Lượng" class="form-control attr_quantity" type="number" name="attr[{{$arr??0}}][quantity]"></div>
                                      <div class="col-md-4 mb-3"><button value="{{$arr??0}}" type="button" class="btn btn-success add_item_btn">+</button></div>
                                    </div> --}}
                                    <input hidden type="number" name="quantity" id="quantity">
                                  </div>
                                </div>
                              </div>  
                              <div class="form-row">
                                <div class="form-group col-md-6">
                                  <label for="" class="control-lable text-left">Giá Sản Phẩm<span class="text-danger">(*)</span></label>
                                  <input value="{{old('price', $product->price ?? '')}}" name="price" type="text" class="form-control money price" placeholder="Nhập Đơn Giá">
                                </div>
                                <div class="form-group col-md-6">
                                  <label for=""class="control-lable text-left">Giá Giảm</label>
                                  <input value="{{old('discount', $product->discount ?? '')}}" name="discount" type="text" class="form-control money discount" placeholder="Nhập Đơn Giá">
                                </div>
                              </div>            
                            </div>
                          </div>
                          <div id="menu3" class="tab-pane fade">
                            <div class="card-body">
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-lable text-left">Ảnh đại diện<span class="text-danger">(*)</span></label>
                                    <input class="form-control-file border upload"
                                          type="file" data-location="thumb/products">
                                          <span id="error_image"></span>
                                          <div class="image_show"></div>
                                          <a href="/storage/{{ old('thumb',$product->thumb ?? '') }}" target="_blank">
                                          <img src="/storage/{{ old('thumb',$product->thumb ?? '') }}" width="150px"></a>
                                          <input type="hidden" name="thumb" class="thumb" value="{{old('thumb',$product->thumb ?? '')}}">
                                  </div>
                              </div>
                              @if($config['method'] == 'create')
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-lable text-left">Thư Viện Ảnh
                                    ( Lưu ý<span class="text-danger"> (*)</span>: Có thể chọn nhiều ảnh )
                                    </label>
                                    <input  class="form-control-file border uploadMulti"
                                            type="file"
                                            data-location="products"
                                            name="images[]"
                                            id="images"
                                            multiple >
                                    <span id="error_gallery"></span>
                                     <div id="imagesPreview"></div>
                                  </div>
                              </div>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label>Kích Hoạt Sản Phẩm<span class="text-danger">(*)</span></label>
                                  <div class="funkyradio">
                                      <div class="funkyradio-success">
                                          <input type="radio" name="publish" id="radio1" value="2" {{old('publish',
                                                            (isset($product->publish))?$product->publish:'') == 2 ? 'checked': ''}}/>
                                          <label for="radio1">Kích hoạt</label>
                                      </div>
                                      <div class="funkyradio-success">
                                          <input type="radio" name="publish" id="radio2" value="1" {{old('publish',
                                                            (isset($product->publish))?$product->publish:'') == 1 ? 'checked': ''}}/>
                                          <label for="radio2">Không kích hoạt</label>
                                      </div>
                                  </div>
                                  </div>
                                </div>
                                @endif
                            </div>
                          </div>
                        </div>
                        <!-- Card Body -->

                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary submitProduct">Lưu</button>
            </div>
        </div>
        </form>
        </div>
    </div>
    <script>
      CKEDITOR.replace( 'editor1' );
  </script>
  <script>
    $('.getId').each(function(){
      var id
      id=$(this).attr('id')
      new MultiSelectTag(id)
    })
  </script>
<script>
  var option = '<?php echo $option; ?>'
  var parent_id = '{{ (isset($product->category_products->parent_id)) ? $product->category_products->parent_id : old('catParent') }}'
  var category_id = '{{ (isset($product->category_id)) ? $product->category_id : old('category_id') }}'
</script>
<script>
  var inputField=document.querySelector('.discount')
  inputField.onkeyup=function(){
    var removeChar=this.value.replace(/[^0-9\.]/g,'')
    var removeDot=removeChar.replace(/\./g,'')
    this.value=removeDot
  }
  var inputField=document.querySelector('.price')
  inputField.onkeyup=function(){
    var removeChar=this.value.replace(/[^0-9\.]/g,'')
    var removeDot=removeChar.replace(/\./g,'')
    this.value=removeDot
  }
</script>
<script>
      $(document).ready(function(){
        $('.money').simpleMoneyFormat();
    })
</script>