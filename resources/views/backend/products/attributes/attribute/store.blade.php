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
          $url=($config['method'] == 'create' ) ? route('attribute.store') : route('attribute.update', $attributeValue->id);
        @endphp
        <form action="{{$url}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-description">
                            <p>Nhập thông tin thuộc tính</p>
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
                                  <div class="form-group col-md-12">
                                    <label  class="control-lable text-left">Nhóm Thuộc Tính<span class="text-danger">(*)</span></label>
                                    <select name="id_attribute" class="form-control setupSelect2">
                                        <option value="0">--Chọn Nhóm Thuộc Tính--</option>
                                        @if(@isset($attributeCatalogues))
                                        @foreach ($attributeCatalogues as $attributeCatalogue)
                                            <option {{$attributeCatalogue->id==old('id_attribute',
                                            (isset($attributeValue->id_attribute))?$attributeValue->id_attribute:'')
                                                ?'selected':''}}
                                                     value="{{$attributeCatalogue->id}}">{{$attributeCatalogue->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                  </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label  class="control-lable text-left">Giá Trị<span class="text-danger">(*)</span></label>
                                      <input name="value" type="text" class="form-control" value="{{old('value', $attributeValue->value ?? '')}}">
                                    </div>
                                  </div>
                                  @if($config['method'] == 'create') 
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label>Kích Hoạt Thuộc Tính<span class="text-danger">(*)</span></label>
                                      <div class="funkyradio">
                                          <div class="funkyradio-success">
                                              <input type="radio" name="publish" id="radio1" value="2" {{old('publish',
                                                                (isset($attributeValue->publish))?$attributeValue->publish:'') == 2 ? 'checked': ''}}/>
                                              <label for="radio1">Kích hoạt</label>
                                          </div>
                                          <div class="funkyradio-success">
                                              <input type="radio" name="publish" id="radio2" value="1" {{old('publish',
                                                                (isset($attributeValue->publish))?$attributeValue->publish:'') == 1 ? 'checked': ''}}/>
                                              <label for="radio2">Không kích hoạt</label>
                                          </div>
                                      </div>
                                      </div>
                                    </div>
                                    @endif
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