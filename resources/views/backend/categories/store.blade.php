@include('backend.dashboard.component.breadcrumb',['title'=> $config['seo']['create']['title']])
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{$config['seo']['create']['tableHeading']}}</h6>
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
          $url=($config['method'] == 'create' ) ? route('categoryProduct.store') : route('categoryProduct.update', $categoryProduct->id);
        @endphp
        <form action="{{$url}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-lg-4">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>Nhập thông tin danh mục</p>
                        <p>Lưu ý: Trường đánh dấu <span class="text-danger">(*)</span> là thông tin bắt buộc</p>
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
                                    <label for="" class="control-lable text-left">Tên Danh Mục<span class="text-danger">(*)</span></label>
                                    <input name="name" type="text" class="form-control" placeholder="" value="{{old('name', $categoryProduct->name ?? '')}}">
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label for="" class="control-lable text-left">Mô Tả</label>
                                    <input name="description" type="text" class="form-control" placeholder="" value="{{old('description', $categoryProduct->description ?? '')}}">
                                  </div>
                                </div>
                                @if($config['method'] == 'create')
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label class="control-lable text-left">Loại Danh Mục</label>
                                    <select name="parent_id" class="form-control">
                                      <option value="0" {{old('parent_id')==0 ? 'selected': ''}} >--root</option>
                                      @if(isset($parentCategorys))
                                      @foreach($parentCategorys as $parentCategory)
                                          <option value="{{$parentCategory->id}}" 
                                            {{old('parent_id',
                                            (isset($categoryProduct->parent_id))  ? $categoryProduct->parent_id : '')  == $parentCategory->id ? 'selected': ''}}>
                                              {{$parentCategory->name}}</option>
                                      @endforeach
                                      @endif
                                    </select>
                                  </div>
                                </div>
                                @endif
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label for="" class="control-lable text-left">Banner</label>
                                    <input class="form-control-file border upload"
                                    type="file" data-location="thumb/categories">
                                    <span id="error_image"></span>
                                    <div class="image_show"></div>
                                    <a href="/storage/{{ old('banner',$categoryProduct->banner ?? '') }}" target="_blank">
                                    <img src="/storage/{{ old('banner',$categoryProduct->banner ?? '') }}" width="150px"></a>
                                    <input type="hidden" name="banner" class="thumb" value="{{old('thumb',$categoryProduct->banner ?? '')}}">
                                  </div>
                                </div>
                                @if($config['method'] == 'create')
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Kích Hoạt Danh Mục<span class="text-danger">(*)</span></label>
                                    <div class="funkyradio">
                                        <div class="funkyradio-success">
                                            <input type="radio" name="publish" id="radio1" value="2" {{old('publish',
                                                              (isset($categoryProduct->publish))?$categoryProduct->publish:'') == 2 ? 'checked': ''}}/>
                                            <label for="radio1">Kích hoạt</label>
                                        </div>
                                        <div class="funkyradio-success">
                                            <input type="radio" name="publish" id="radio2" value="1" {{old('publish',
                                                              (isset($categoryProduct->publish))?$categoryProduct->publish:'') == 1 ? 'checked': ''}}/>
                                            <label for="radio2">Không kích hoạt</label>
                                        </div>
                                    </div>
                                    </div>
                                  </div>
                                  @endif
                              </div>

                        </div>
                    </div>
                </div>
                <div class="text-right">
                  <button type="submit" class="btn btn-primary">Lưu</button>
              </div>
            </div>
        </div>
        </form>
        </div>

