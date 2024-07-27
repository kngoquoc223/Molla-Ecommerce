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
          $url=($config['method'] == 'create' ) ? route('coupon.store') : route('coupon.update', $coupon->id);
        @endphp
        <form action="{{$url}}" method="post">
          @csrf
          <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-description">
                            <p>Nhập thông tin Mã Giảm Giá</p>
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
                                  <div class="form-group col-md-8">
                                    <label  class="control-lable text-left">Tên mã giảm giá<span class="text-danger">(*)</span></label>
                                    <input name="coupon_name" type="text" class="form-control"  placeholder="" value="{{old('coupon_name', $coupon->coupon_name ?? '')}}">
                                  </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label  class="control-lable text-left">Mã giảm giá<span class="text-danger">(*)</span></label>
                                      <input name="coupon_code" type="text" class="form-control"  placeholder="" value="{{old('coupon_code', $coupon->coupon_code ?? '')}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label  class="control-lable text-left">Số lượng mã<span class="text-danger">(*)</span></label>
                                        <input name="coupon_time" type="number" class="form-control"  placeholder="" value="{{old('coupon_time', $coupon->coupon_time ?? '')}}">
                                      </div>
                                  </div>
                                  @php 
                                  $couponCatalogue=[
                                    '--Chọn Tính Năng--',
                                    'Giảm theo %',
                                    'Giảm theo tiền',
                                  ]
                                  @endphp
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label  class="control-lable text-left">Tính năng mã<span class="text-danger">(*)</span></label>
                                      <select name="coupon_condition" class="form-control setupSelect2 coupon-condition">
                                        @foreach ($couponCatalogue as $key => $item)                                
                                        <option {{$key==old('coupon_condition',
                                                (isset($coupon->coupon_condition)) ? $coupon->coupon_condition:'')
                                                 ? 'selected':'' }}  
                                                value="{{$key}}">{{$item}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label  class="control-lable text-left">Nhập số tiền giảm hoặc số %<span class="text-danger">(*)</span></label>
                                        <input value="{{old('coupon_number', $coupon->coupon_number ?? '')}}"  name="coupon_number" type="text" class="form-control coupon-value money" >
                                    </div>
                                  </div>  
                                  <div class="form-row">
                                    <div class="form-group col-md-12">
                                      <label>Kích Hoạt Mã Giảm Giá<span class="text-danger">(*)</span></label>
                                      <div class="funkyradio">
                                          <div class="funkyradio-success">
                                              <input type="radio" name="publish" id="radio1" value="2" {{old('publish',
                                                                (isset($coupon->publish))?$coupon->publish:'') == 2 ? 'checked': ''}}/>
                                              <label for="radio1">Kích hoạt</label>
                                          </div>
                                          <div class="funkyradio-success">
                                              <input type="radio" name="publish" id="radio2" value="1" {{old('publish',
                                                                (isset($coupon->publish))?$coupon->publish:'') == 1 ? 'checked': ''}}/>
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
<script>
    var inputField=document.querySelector("input[name='coupon_number']")
    inputField.onkeyup=function(){
    var removeChar=this.value.replace(/[^0-9\.]/g,'')
    var removeDot=removeChar.replace(/\./g,'')
    this.value=removeDot
  }
    $(document).ready(function(){
        $('.money').simpleMoneyFormat();
    })
</script>