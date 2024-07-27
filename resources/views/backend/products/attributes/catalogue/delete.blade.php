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
        <form action="{{route('attribute.catalogue.destroy', $attribute->id)}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-description">
                            <p>Lưu ý :<span class="text-danger">(*)</span> Không thể khôi phục thuộc tính sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này</p>
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
                                    <label for="" class="control-lable text-left">Tên Thuộc Tính<span class="text-danger">(*)</span></label>
                                    <input readonly name="name" type="text" class="form-control"  value="{{old('name', $attribute->name ?? '')}}">
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


