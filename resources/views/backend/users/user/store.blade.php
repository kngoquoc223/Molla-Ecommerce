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
          $url=($config['method'] == 'create' ) ? route('user.store') : route('user.update', $user->id);
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
                            <form >
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="" class="control-lable text-left">Email<span class="text-danger">(*)</span></label>
                                    <input {{($config['method'] == 'edit')?'readonly':''}} name="email" type="text" class="form-control" id="inputEmail4" placeholder="" value="{{old('email', $user->email ?? '')}}">
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for=""class="control-lable text-left">Tên người dùng<span class="text-danger">(*)</span></label>
                                    <input name="name" type="text" class="form-control" id="inputPassword4" placeholder="" value="{{old('name', $user->name ?? '')}}">
                                  </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="control-lable text-left">Chọn nhóm thành viên<span class="text-danger">(*)</span></label>
                                        <select {{($config['method'] == 'edit')?'disabled':''}} name="user_catalogue_id" class="form-control setupSelect2">
                                          @foreach ($userCatalogues as $item)           
                                          <option {{Auth::user()->user_catalogue_id == 1 ? '' : ($item->id == 1 ? 'disabled' : '') }} @if(old('user_catalogue_id',$user->user_catalogue_id ?? '') == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label for=""class="control-lable text-left">Ngày sinh</label>
                                        <input name="birthday" type="date" class="form-control" 
                                            value="{{old('birthday',(isset($user->birthday)) ? date('Y-m-d',strtotime($user->birthday)):'')}}">
                                      </div>
                                </div>
                                @if($config['method']=='create')
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for=""class="control-lable text-left">Mật khẩu<span class="text-danger">(*)</span></label>
                                        <input name="password" type="text" class="form-control" id="inputEmail4" placeholder="">
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label for=""class="control-lable text-left">Nhập lại mật khẩu<span class="text-danger">(*)</span></label>
                                        <input name="re_password" type="text" class="form-control" id="inputPassword4" placeholder="">
                                      </div>
                                  </div>
                                  @endif
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for=""class="control-lable text-left">Ảnh đại diện</label>
                                        <input  class="form-control-file border upload"
                                                type="file" data-location="users">
                                              <div class="image_show"></div>
                                              <a href="/storage/{{old('avatar',$user->avatar ?? '')}}" target="_blank">
                                              <img src="/storage/{{old('avatar',$user->avatar ?? '')}}" width="150px"></a>
                                              <input type="hidden" name="avatar" class="thumb" value="{{old('avatar',$user->avatar ?? '')}}">
                                      </div>
                                  </div>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin liên hệ</div>
                        <div class="panel-description">
                            <p>Nhập thông tin liên hệ của người sử dụng</p>
                        </div>
                    </div>
                </div>
                <!-- Donut Chart -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <!-- Card Body -->
                        <div class="card-body">
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputCity">Thành Phố</label>
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
                                    <label for="inputState">Quận/Huyện</label>
                                    <select name="district_id" class="form-control districts setupSelect2 location" data-target="wards">
                                      <option value="0">[Chọn Quận/Huyện]</option>
                                    </select>
                                  </div>
                                </div>
                                  <div class="form-row">   
                                    <div class="form-group col-md-6">
                                        <label for="inputState">Phường/Xã</label>
                                        <select name="ward_id" class="form-control setupSelect2 wards">
                                          <option value="0">[Chọn Phường/Xã]</option>
                                        </select>
                                      </div>                               
                                    <div class="form-group col-md-6">
                                    <label for="inputZip">Địa chỉ</label>
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
    <script>
        var province_id = '{{ (isset($user->province_id)) ? $user->province_id : old('province_id') }}'
        var district_id = '{{ (isset($user->district_id)) ? $user->district_id : old('district_id') }}'
        var ward_id = '{{ (isset($user->ward_id)) ? $user->ward_id : old('ward_id') }}'
    </script>

