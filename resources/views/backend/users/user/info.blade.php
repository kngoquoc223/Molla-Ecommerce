@include('backend.dashboard.component.breadcrumb',['title'=> $config['seo']['edit']['title']])
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{$config['seo']['edit']['tableHeading']}}</h6>
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
          <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-description">
                            <p>Nhập thông tin người sử dụng</p>
                            <p>Lưu ý:</p>
                            <p>Trường đánh dấu <span class="text-danger">(*)</span> là thông tin bắt buộc</p>
                            <p><span class="text-danger">(*)</span> Chỉ cập nhật thông tin theo từng mục</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <ul class="nav nav-tabs">
                          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Thông tin chung</a></li>
                          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">Thay đổi mật khẩu</a></li>
                          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2">Thay đổi email</a></li>
                        </ul>
                        <div class="tab-content">
                          <div id="home" class="tab-pane fade in active show">
                            <form action="{{route('user.info.update',$user->id)}}" method="POST">
                              @csrf
                              <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for=""class="control-lable text-left">Ảnh đại diện</label>
                                        <input  class="form-control-file border upload"
                                                type="file" data-location="users">
                                              <div class="image_show"></div>
                                              <div class="gallery">
                                                <a href="/storage/{{old('avatar',$user->avatar ?? '')}}" target="_blank">
                                                    <img src="/storage/{{old('avatar',$user->avatar ?? '')}}" width="150px"></a>
                                              </div>
                                              <input type="hidden" name="avatar" class="thumb" value="{{old('avatar',$user->avatar ?? '')}}">
                                      </div>
                                  </div>
                                        <div class="form-row">
                                          <div class="form-group col-md-6">
                                            <label for="" class="control-lable text-left">Email<span class="text-danger">(*)</span></label>
                                            <input readonly name="email" type="text" class="form-control" id="inputEmail4" placeholder="" value="{{old('email', $user->email ?? '')}}">
                                          </div>
                                          <div class="form-group col-md-6">
                                            <label for=""class="control-lable text-left">Tên người dùng<span class="text-danger">(*)</span></label>
                                            <input name="name" type="text" class="form-control" id="inputPassword4" placeholder="" value="{{old('name', $user->name ?? '')}}">
                                          </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="control-lable text-left">Chọn nhóm thành viên<span class="text-danger">(*)</span></label>
                                                <select disabled name="user_catalogue_id" class="form-control setupSelect2">
                                                  @foreach ($userCatalogues as $item)           
                                                  <option @if(old('user_catalogue_id',$user->user_catalogue_id ?? '') == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                                  @endforeach
                                                </select>
                                              </div>
                                              <div class="form-group col-md-6">
                                                <label for=""class="control-lable text-left">Ngày sinh</label>
                                                <input name="birthday" type="date" class="form-control" 
                                                    value="{{old('birthday',(isset($user->birthday)) ? date('Y-m-d',strtotime($user->birthday)):'')}}">
                                              </div>
                                        </div>
                                          <div class="form-row">
                                            <div class="form-group col-md-6">
                                              <label for="" class="control-lable text-left">Thành Phố<span class="text-danger">(*)</span></label>
                                              <select name="province_id" class="form-control setupSelect2 province location" data-target="districts">
                                                <option value="0">[Chọn Thành Phố]</option>
                                                @if (isset($provinces))
                                                @foreach($provinces as $province)
                                                <option @if(old('province_id') == $province->code) selected @endif value="{{$province->code}}">{{$province->name}}</option>
                                                @endforeach
                                                @endif
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                              <label for="" class="control-lable text-left">Quận/Huyện<span class="text-danger">(*)</span></label>
                                              <select name="district_id" class="form-control districts setupSelect2 location" data-target="wards">
                                                <option value="0">[Chọn Quận/Huyện]</option>
                                              </select>
                                            </div>
                                          </div>
                                            <div class="form-row">   
                                              <div class="form-group col-md-6">
                                                  <label for="" class="control-lable text-left">Phường/Xã<span class="text-danger">(*)</span></label>
                                                  <select name="ward_id" class="form-control setupSelect2 wards">
                                                    <option value="0">[Chọn Phường/Xã]</option>
                                                  </select>
                                                </div>                               
                                              <div class="form-group col-md-6">
                                              <label class="control-lable text-left">Địa chỉ<span class="text-danger">(*)</span></label>
                                              <input name="address" type="text" class="form-control" id="inputZip" value="{{old('address',$user->address ?? '')}}">
                                            </div>
                                          </div>
                                          <div class="form-row">
                                              <div class="form-group col-md-6">
                                                  <label for=""class="control-lable text-left">Số điện thoại<span class="text-danger">(*)</span></label>
                                                  <input name="phone" type="text" class="form-control" id="inputEmail4" placeholder="" value="{{old('phone',$user->phone ?? '')}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                  <label for=""class="control-lable text-left">Ghi chú</label>
                                                  <input name="description" type="text" class="form-control" id="inputPassword4" placeholder="" value="{{old('description',$user->description ?? '')}}">
                                                </div>        
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                            </div>
                              </div>              
                            </form>
                          </div>
                          <div id="menu1" class="tab-pane fade">
                            <form method="POST" action="{{route('user.info.changePassword',$user->id)}}">
                              @csrf
                              <div class="card-body">
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for=""class="control-lable text-left">Mật khẩu hiện tại<span class="text-danger">(*)</span></label>
                                      <input id="password_old" name="password_old" type="password" class="form-control showPassword">
                                    </div>   
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for=""class="control-lable text-left">Mật khẩu mới<span class="text-danger">(*)</span></label>
                                      <input id="password" name="password" type="password" class="form-control showPassword">
                                    </div>   
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for=""class="control-lable text-left">Nhập lại mật khẩu mới<span class="text-danger">(*)</span></label>
                                      <input id="re_password" name="re_password" type="password" class="form-control showPassword">
                                    </div>   
                                </div>
                                <div class="row">
                                  <div class="col-sm-6">
                                      <input type="checkbox" onclick="myFunction()">Show Password
                                  </div>
                              </div>
                              <script>
                                  function myFunction() {
                                      var x = document.getElementsByClassName("showPassword");
                                      for (var i = 0; i < x.length; i++) {
                                      if (x[i].type === "password") {
                                          x[i].type = "text";
                                      } else {
                                          x[i].type = "password";
                                      }
                                      }
                                      }
                              </script>
                                <div class="text-right">
                                  <button type="submit" class="btn btn-primary">Cập nhật</button>
                              </div>
                          </div>
                            </form>
                          </div>
                          <div id="menu2" class="tab-pane fade">
                            <form method="POST" action="{{route('user.info.changeEmail',$user->id)}}">
                              @csrf
                              <div class="card-body">
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                      <label for=""class="control-lable text-left">Nhập Email mới<span class="text-danger">(*)</span></label>
                                      <input name="email" type="email" class="form-control">
                                    </div>   
                                </div>
                                <div class="text-right">
                                  <button type="submit" class="btn btn-primary">Cập nhật</button>
                              </div>
                          </div>
                            </form>
                          </div>
                        </div>
                        <!-- Card Body -->
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <script>
        var province_id = '{{ (isset($user->province_id)) ? $user->province_id : old('province_id') }}'
        var district_id = '{{ (isset($user->district_id)) ? $user->district_id : old('district_id') }}'
        var ward_id = '{{ (isset($user->ward_id)) ? $user->ward_id : old('ward_id') }}'
    </script>

