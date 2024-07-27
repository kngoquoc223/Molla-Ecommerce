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
          $url=($config['method'] == 'create' ) ? route('user.catalogue.store') : route('user.catalogue.update', $userCatalogue->id);
        @endphp
        <form action="{{$url}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-description">
                            <p>Nhập thông tin người sử dụng</p>
                            <p>Lưu ý: Trường đánh dấu <span class="text-danger">(*)</span> là thông tin bắt buộc</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <!-- Card Body -->
                        <div class="card-body">
                            <form>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="" class="control-lable text-left">Tên nhóm<span class="text-danger">(*)</span></label>
                                    <input name="name" type="text" class="form-control" id="inputEmail4" placeholder="" value="{{old('name', $userCatalogue->name ?? '')}}">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for=""class="control-lable text-left">Ghi chú</label>
                                    <input name="description" type="text" class="form-control" id="inputPassword4" placeholder="" value="{{old('description', $userCatalogue->description ?? '')}}">
                                  </div>
                                </div>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </div>
        </form>
        </div>
    </div>

