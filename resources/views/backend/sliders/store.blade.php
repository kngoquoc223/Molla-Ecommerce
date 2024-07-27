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
          $url=($config['method'] == 'create' ) ? route('slider.store') : route('slider.update', $slider->id);
        @endphp
        <form action="{{$url}}" method="post">
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
                        <!-- Card Body -->
                        <div class="card-body">
                            <form >
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label  class="control-lable text-left">Tiêu Đề<span class="text-danger">(*)</span></label>
                                    <input name="name" type="text" class="form-control"  placeholder="" value="{{old('name', $slider->name ?? '')}}">
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-9">
                                    <label  class="control-lable text-left">Đường Dẫn<span class="text-danger">(*)</span></label>
                                    <input name="url" type="text" class="form-control"  placeholder="" value="{{old('url', $slider->url ?? '')}}">
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Mô Tả<span class="text-danger">(*)</span></label>
                                    <input class="form-control" type="text" name="description" id="" value="{{old('description',$slider->description ?? '')}}">
                                  </div>
                                </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for=""class="control-lable text-left">Ảnh Slider<span class="text-danger">(*)</span></label>
                                        <input  class="form-control-file border upload"
                                                type="file" data-location="sliders">
                                              <div class="image_show"></div>
                                              <a href="/storage/{{old('thumb',$slider->thumb ?? '')}}" target="_blank">
                                              <img src="/storage/{{old('thumb',$slider->thumb ?? '')}}" width="150px"></a>
                                              <input type="hidden" name="thumb" class="thumb" value="{{old('thumb',$slider->thumb ?? '')}}">
                                              
                                      </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label>Kích Hoạt Slider<span class="text-danger">(*)</span></label>
                                      <div class="funkyradio">
                                          <div class="funkyradio-success">
                                              <input type="radio" name="publish" id="radio1" value="2" {{old('publish',
                                                                (isset($slider->publish))?$slider->publish:'') == 2 ? 'checked': ''}}/>
                                              <label for="radio1">Kích hoạt</label>
                                          </div>
                                          <div class="funkyradio-success">
                                              <input type="radio" name="publish" id="radio2" value="1" {{old('publish',
                                                                (isset($slider->publish))?$slider->publish:'') == 1 ? 'checked': ''}}/>
                                              <label for="radio2">Không kích hoạt</label>
                                          </div>
                                      </div>
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
