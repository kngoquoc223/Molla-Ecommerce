@include('backend.dashboard.component.breadcrumb',['title'=> $config['seo']['index']['title']])
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">{{$config['seo']['create']['title']}}</h6>
            <div class="ibox-tools">
              <a class="feeshipCardExample" href="#feeshipCardExample" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                  <i class="feeshipCard fa fa-chevron-down"></i>
              </a>
          </div>
          <script>
                $('.feeshipCardExample').on('click', function () {
                  $('.feeshipCard').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up')
              });
          </script>
        </div>
        <div class="collapse show" id="feeshipCardExample">
            <div class="card-body">
              <form id="feeshipValidate">
                @csrf
              <div class="row">
                <div class="col-lg-12">
                          <div class="form-row">
                            <div class="form-group col-md-4">
                              <label for="inputCity">Thành Phố</label>
                              <select id="province_id" name="province_id" class="form-control province location" data-target="districts">
                                <option value="0">[Chọn Thành Phố]</option>
                                @if (isset($provinces))
                                @foreach($provinces as $province)
                                <option @if(old('province_id') == $province->code) selected @endif value="{{$province->code}}">{{$province->name}}</option>
                                @endforeach
                                @endif
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="inputState">Quận/Huyện</label>
                              <select id="district_id" name="district_id" class="form-control districts location" data-target="wards">
                                <option value="0">[Chọn Quận/Huyện]</option>
                              </select>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="inputState">Phường/Xã</label>
                              <select id="ward_id" name="ward_id" class="form-control wards">
                                <option value="0">[Chọn Phường/Xã]</option>
                              </select>
                            </div> 
                          </div>
                            <div class="form-row">
                              <div class="form-group col-md-6">
                                <label  class="control-lable text-left">Phí ship hàng<span class="text-danger">(*)</span></label>
                                <input id="cost" required name="cost" type="text" class="form-control money">
                              </div>
                              <div class="form-group col-md-6">
                                <label  class="control-lable text-left">&nbsp;</label>
                                <div class="text-left">
                                  <button type="submit" class="btn btn-success store-feeship">Thêm phí ship</button>
                              </div>
                              </div>
                            </div>
                </div>
            </div>
          </form>
    </div>
        </div>
        </div>
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">{{$config['seo']['index']['tableHeading']}}</h6>
              <div class="ibox-tools">
                <a class="collapseCardExample" href="#collapseCardExample" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <i class="setfa fa fa-chevron-down"></i>
                </a>
            </div>
            <script>
                  $('.collapseCardExample').on('click', function () {
                    $('.setfa').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up')
                });
            </script>
          </div>
          <div class="collapse show" id="collapseCardExample">
              <div class="card-body">
            <div id="dataTable_wrapper" class="dataTable_wrapper dt-bootstrap4">
              @include('backend.feeships.component.filter')
              <div class="row">
                  <div class="col-sm-12">
              @include('backend.feeships.component.table')
                  </div>
              </div>
          </div>
      </div>
          </div>
          </div>
    </div>
    <script>
      var province_id = ''
      var district_id = ''
      var ward_id = ''
  </script>
    <script>
      $(document).ready(function(){
        $('.money').simpleMoneyFormat();
        $("#feeshipValidate").validate({
            rules: {
              province_id:{
                min:1,
              },
              district_id:{
                min:1,
              },
              ward_id:{
                min:1,
              },
              cost:{
                required : true,
              },
            },
        
            messages: {
              province_id:{
                min: "Vui lòng chọn Thành Phố",
              },
              district_id:{
                min: "Vui lòng chọn Quận/Huyện",
              },
              ward_id:{
                min: "Vui lòng chọn Phường/Xã",
              },
              cost:{
                required: "Vui lòng nhập phí ship",
              },
            },
         });
    })
  </script>
    <script>
      var inputField=document.querySelector('.money')
      inputField.onkeyup=function(){
        var removeChar=this.value.replace(/[^0-9\.]/g,'')
        var removeDot=removeChar.replace(/\./g,'')
        this.value=removeDot
      }
    </script>
<script>
    $("#feeshipValidate").submit(function(e){
                e.preventDefault();
                $.ajax({
                    url:'/admin/feeship/ajax/store',
                    type:'POST',
                    data:$(this).serialize(),
                    success:function(res){
                      if(res.error == 'true'){
                      }else{
                        if(res.html != ''){
                        Swal.fire({
                            title: "Thêm bản ghi thành công",
                            icon: "success"
                          });
                        $('#feeshipTable').prepend(res.html);
                      }else{
                        Swal.fire({
                            icon: "error",
                            title: "Bản ghi đã tồn tại.Vui lòng thử lại!",
                          });
                      }
                      }
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        //Xử lý dữ liệu khi gặp lỗi 
                        console.log('Lỗi:' + textStatus + ' '+ errorThrown);
        
                    }
                })
              })
</script>

