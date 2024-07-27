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
          $url=($config['method'] == 'create' ) ? route('posts.store') : route('posts.update', $posts->id);
        @endphp
        <form action="{{$url}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-content">
                            <p>Nhập thông tin bài viết</p>
                            <p>Lưu ý: Trường đánh dấu <span class="text-danger">(*)</span> là thông tin bắt buộc</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                  <div class="card shadow mb-4">
                      <!-- Card Header - Dropdown -->
                      <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Nội dung</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">Tóm tắt</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2">SEO</a></li>
                      </ul>
                      <div class="tab-content">
                        <div id="home" class="tab-pane fade in active show">
                          <div class="card-body">
                            <form >
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="" class="control-lable text-left">Tiêu đề bài viết<span class="text-danger">(*)</span></label>
                                    <input name="title" type="text" class="form-control" placeholder="" value="{{old('title', $posts->title ?? '')}}">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label class="control-lable text-left">Danh mục bài viết<span class="text-danger">(*)</span></label>
                                    <select name="category_id" class="form-control setupSelect2">
                                      <option value="0">--Chọn Danh Mục Bài Viết--</option>
                                      @foreach ($categoryPosts as $item)           
                                      <option @if(old('category_id',$posts->category_id ?? '') == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-12">
                                    <label>Nội dung bài viết</label>
                                    <textarea name="content" id="editor1" rows="10" cols="80" >{{old('content', $posts->content ?? '')}}</textarea>
                                  </div>
                                </div>
                                <label style="float: right">Tác giả: <b>{{Auth::user()->name}}</b></label>
                                <input value="{{Auth::user()->id}}" name="user_id" type="hidden">
                              </form>
                        </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                          <div class="card-body">
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                  <label class="control-lable text-left">Ảnh<span class="text-danger">(*)</span></label>
                                  <input class="form-control-file border upload"
                                        type="file" data-location="thumb/posts">
                                        <span id="error_image"></span>
                                        <div class="image_show"></div>
                                        <a href="/storage/{{ old('image',$posts->image ?? '') }}" target="_blank">
                                        <img src="/storage/{{ old('image',$posts->image ?? '') }}" width="150px"></a>
                                        <input type="hidden" name="image" class="thumb" value="{{old('image',$posts->image ?? '')}}">
                                </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-12">
                                <label for="" class="control-lable text-left">Tóm tắt bài viết<span class="text-danger">(*)</span></label>
                                <textarea name="desc" id="editor2" rows="10" cols="80" >{{old('desc', $posts->desc ?? '')}}</textarea>
                              </div>
                            </div>
                              <div class="form-row">
                                <div class="form-group col-md-12">
                                  <label>Hiển Thị Bài Viết<span class="text-danger">(*)</span></label>
                                  <div class="funkyradio">
                                      <div class="funkyradio-success">
                                          <input type="radio" name="publish" id="radio1" value="2" {{old('publish',
                                                            (isset($posts->publish))?$posts->publish:'') == 2 ? 'checked': ''}}/>
                                          <label for="radio1">Kích hoạt</label>
                                      </div>
                                      <div class="funkyradio-success">
                                          <input type="radio" name="publish" id="radio2" value="1" {{old('publish',
                                                            (isset($posts->publish))?$posts->publish:'') == 1 ? 'checked': ''}}/>
                                          <label for="radio2">Không kích hoạt</label>
                                      </div>
                                  </div>
                                  </div>
                                </div>
                          </div>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                          <div class="card-body">
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                  <label for=""class="control-lable text-left">Meta từ khóa</label>
                                  <textarea name="meta_keywords" style="resize: none" rows="5" class="form-control">{{old('meta_keywords',$posts->meta_keywords ?? '')}}</textarea>
                                </div>
                                <div class="form-group col-md-6">
                                  <label for=""class="control-lable text-left">Meta nội dung</label>
                                  <textarea name="meta_desc" style="resize: none" rows="5" class="form-control">{{old('meta_desc',$posts->meta_desc ?? '')}}</textarea>
                                </div>        
                          </div>
                          </div>
                        </div>
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
<script>
CKEDITOR.replace( 'editor1' );
CKEDITOR.replace( 'editor2' );
</script>

