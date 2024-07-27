@include('backend.dashboard.component.breadcrumb',['title'=> $config['seo']['delete']['title']])
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{$config['seo']['delete']['tableHeading']}}</h6>
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
        <form id="submit-destroy-cat" action="{{route('categoryProduct.destroy', $categoryProduct->id)}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-description">
                            <p>Bạn muốn xóa danh mục có tên là: {{$categoryProduct->name}}</p>
                            <p>Lưu ý: Không thể khôi phục danh mục sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <!-- Card Body -->
                        <div class="card-body">
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label for="" class="control-lable text-left">Tên Danh Mục<span class="text-danger">(*)</span></label>
                                    <input readonly name="name" type="text" class="form-control"  placeholder="" value="{{old('name', $categoryProduct->name ?? '')}}">
                                  </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(isset($childCategorys) && !empty($childCategorys))
            <div class="row">
                <div class="col-lg-4">                    
                    <div class="panel-head">
                    <div class="panel-title">Cảnh báo<span class="text-danger">*</span></div>
                    <div class="panel-description">
                        <p>Danh mục này tồn tài danh mục con. Hành động này sẽ xóa hết các chức năng hiện hành của danh mục con</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <!-- Card Body -->
                    <div class="card-body">                       
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="" class="control-lable text-left">Danh Mục Con<span class="text-danger">(*)</span></label>
                                <select class="custom-select" multiple disabled> 
                                    @foreach($childCategorys as $childCategory)
                                    <option value="{{$childCategory->id}}">{{$childCategory->name}}</option>
                                    @endforeach
                                  </select>
                              </div>                           
                            </div>
                    </div>
                </div>
            </div>
            </div>
            @endif
            @if(isset($parentCategory) && !empty($parentCategory)) 
            <div class="row">
                <div class="col-lg-4">                    
                    <div class="panel-head">
                    <div class="panel-title">Cảnh báo<span class="text-danger">*</span></div>
                    <div class="panel-description">
                        <p>Danh mục này tồn tài danh mục cha. Hành động này không ảnh hưởng đến chức năng hiện hành của danh mục cha</p>
                    </div>
                </div>
                </div>
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <!-- Card Body -->
                        <div class="card-body">
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label for="" class="control-lable text-left">Tên Danh Mục Cha<span class="text-danger">(*)</span></label>
                                    <input readonly name="parentName" type="text" class="form-control"  placeholder="" value="{{old('parentName"', $parentCategory->name ?? '')}}">
                                  </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="text-right">
                <button type="button" id="destroy-cat" class="btn btn-danger">Xóa dữ liệu</button>
            </div>
        </div>
        </form>
        </div>
    </div>
    <script>
       $('#destroy-cat').on('click',function(e){
        e.preventDefault();
        var form = $('#submit-destroy-cat');
        Swal.fire({
            icon: "question",
            title: "Xóa Danh Mục?",
            html: '<i>lưu ý<span class="text-danger">(*)</span>: Sẽ xóa tất cả danh mục và sản phẩm hiện hành thuộc danh mục</i>',
            showCancelButton: true,
            showDenyButton:true,
            showConfirmButton:false,
            denyButtonText:"Chắc chắn xóa",
            cancelButtonText:"Đóng",
            }).then((result) => {
                if (result.isDenied) {
                    form.submit();
                }
            });
        });
    </script>


