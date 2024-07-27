<div class="">
    <div class="col-lg-8">
        <h2>Thư Viện Ảnh Sản Phẩm</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('show-dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{route('product.index')}}">Sản Phẩm</a></li>
              <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Thư Viện Ảnh Sản Phẩm</li>
            </ol>
          </nav>
    </div>
</div>
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a class="btn btn-light btn-icon-split" href="{{route('product.index')}}">
                <span class="icon text-gray-600">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="text">Danh sách sản phẩm</span>
            </a>
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
        <form action="{{route('product.image.update',$product->id)}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="tab-content">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        @if(isset($productImages) && !$productImages->isEmpty())
                                        <label class="control-lable text-left">Ảnh Trong Thư Viện<span class="text-danger"> (*)</span></label>
                                        <div>
                                            @foreach ($productImages as $item)
                                            <div class="gallery"> 
                                                <a href="/storage/{{$item->image}}" target="_blank"><img src="/storage/{{$item->image}}" width="100px"></a>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <label class="control-lable text-left">Thư Viện Ảnh Trống<span class="text-danger"> (*)</span></label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                </div>
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="tab-content">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label class="control-lable text-left">Tên Sản Phẩm</label>
                                        <input readonly class="form-control" value="{{$product->name}}">
                                      </div>
                                  </div>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-lable text-left">Chọn Ảnh Mới
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
                            </div>
                        </div>
                        <!-- Card Body -->
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
            
        </div>
        </form>
        </div>
    </div>
