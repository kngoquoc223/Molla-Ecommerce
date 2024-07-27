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
        <form action="{{route('product.destroy', $product->id)}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-description">
                            <p>Lưu ý :<span class="text-danger">(*)</span> Không thể khôi phục sản phẩm sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <!-- Card Body -->
                        <div class="card-body">
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="" class="control-lable text-left">Tên Sản Phẩm<span class="text-danger">(*)</span></label>
                                    <input readonly name="name" type="text" class="form-control"  value="{{old('name', $product->name ?? '')}}">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for=""class="control-lable text-left">Danh Mục<span class="text-danger">(*)</span></label>
                                    <input readonly name="category_id" type="text" class="form-control" value="{{old('category_id', $product->category_products->name ?? '')}}">
                                  </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                            <label for=""class="control-lable text-left">Thumb<span class="text-danger">(*)</span></label>
                                            <div class="image_show"><a href="/storage/{{$product->thumb}}" target="_blank">
                                              <img src="/storage/{{$product->thumb}}" width="150px"></a>
                                              </div>
                                      </div>
                                  </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-danger">Xóa dữ liệu</button>
            </div>
        </div>
        </form>
        </div>
    </div>


