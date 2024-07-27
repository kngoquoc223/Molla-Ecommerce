(function($) {
    "use strict"; // Start of use strict
    var HT={};
    var _token= $('meta[name="csrf-token"]').attr('content');

    HT.getLocation=() =>{
        $(document).on('change','.location',function(){
            let _this=$(this)
            let option ={
                'data':{
                    'location_id':_this.val(),
                },
                'target' : _this.attr('data-target')
            }
           HT.sendDataTogetLocation(option)
        })        
    }
    HT.sendDataTogetLocation=(option) =>{
        $.ajax({
            url:'/ajax/location/getLocation',
            type:'GET',
            data:option,
            dataType:'json', //Kiểu dữ liệu mong đợi trả về (json, xml, html, v.v )
            success:function(res){
                //Xử lý dữ liệu yêu cầu trả về thành công 
                //VD: hiển thị dữ liệu trên trang
                $('.'+option.target).html(res.html)
                if(district_id != '' && option.target=='districts'){
                    $(".districts").val(district_id).trigger('change');
                }
                if(ward_id != '' && option.target=='wards'){
                    $(".wards").val(ward_id).trigger('change');
                } 

            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);

            }
        })
    }
    HT.loadCity=() =>{
        if(province_id != ''){
            $(".province").val(province_id).trigger('change');
        }
    }
    $("form[id='updateUser']").validate({
      rules: {
        name: {
          minlength: 8,
          required : true,
        },
        phone: {
          required: true,
          number: true,
          minlength: 8,
          maxlength: 15,
        },
        address: {
          required: true,
        },
        province_id:{
          min:1,
        },
        district_id:{
          min:1,
        },
        ward_id:{
          min:1,
        },
      },
      messages: {
        name:{
          required: "Vui lòng nhập Họ Tên",
          minlength: "Họ Tên phải nhiều hơn 8 ký tự"
        },
        phone:{
          required: "Vui lòng nhập Số điện thoại",
          number: "Số điện thoại không hợp lệ (độ dài từ 8 - 15 ký tự, không chứa ký tự đặc biệt và khoảng trắng)",
          minlength: "Số điện thoại không hợp lệ (độ dài từ 8 - 15 ký tự, không chứa ký tự đặc biệt và khoảng trắng)",
          maxlength: "Số điện thoại không hợp lệ (độ dài từ 8 - 15 ký tự, không chứa ký tự đặc biệt và khoảng trắng)",
        },
        address: "Vui lòng nhập Địa chỉ",
        province_id:{
          min: "Vui lòng chọn Thành Phố",
        },
        district_id:{
          min: "Vui lòng chọn Quận/Huyện",
        },
        ward_id:{
          min: "Vui lòng chọn Phường/Xã",
        },
      },
      submitHandler: function() {
          let option={
              'id' : user_id,
              'name' : $("input:text[name=name]").val(),
              'birthday' : $("#birthday").val(),
              'phone' : $("input:text[name=phone]").val(),
              'address' : $("input:text[name=address]").val(),
              'province_id' : $('.province').val(),
              'district_id' : $('.districts').val(),
              'ward_id' : $('.wards').val(),
              '_token': _token,
          }
          $.ajax({
              url:'/ajax/user/update',
              type:'POST',
              data: option,
              success:function(res){
                  if(res.flag == true){
                    Swal.fire({
                      width: 600,
                      position: "center",
                      icon: "success",
                      title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Cập nhật thông tin thành công!</span>",
                      showConfirmButton: false,
                      timer: 1500
                    });
                    location.reload();
                  }else{
                      Swal.fire({
                          width: 600,
                          icon: "error",
                          title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Cập nhật thông tin thất bại.Vui lòng kiểm tra lại!</span>",
                        });
                  }
              },
              error:function(jqXHR, textStatus, errorThrown){
                  //Xử lý dữ liệu khi gặp lỗi 
                  console.log('Lỗi:' + textStatus + ' '+ errorThrown);
              }
          })
      }
    });
    $("form[id='changeEmail']").validate({
      rules: {
        email: {
          required: true,
          email: true
        },
      },
      messages: {
        email:{
          required: "Vui lòng nhập địa chỉ Email",
          email: "Địa chỉ Email không hợp lệ (vd:abc@gmail.com)",
        },
      },
      submitHandler: function() {
          let option={
              'id' : user_id,
              'email' : $("input:text[name=email]").val(),
              '_token': _token,
          }
          $.ajax({
              url:'ajax/user/changeEmail',
              type:'POST',
              data: option,
              success:function(res){
                  if(res.flag == true){
                      Swal.fire({
                        width: 600,
                        position: "center",
                        icon: "success",
                        title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Cập nhật email thành công!</span>",
                        showConfirmButton: false,
                        timer: 1500
                      });
                      location.reload();
                  }else{
                      Swal.fire({
                          width: 600,
                          icon: "error",
                          title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Cập nhật email thất bại.Vui lòng kiểm tra lại!</span>",
                          html: "<span style='font-family: Open Sans;font-size: 2rem;'>"+res.error['email']+"</span>",
                        });
                  }
              },
              error:function(jqXHR, textStatus, errorThrown){
                  //Xử lý dữ liệu khi gặp lỗi 
                  console.log('Lỗi:' + textStatus + ' '+ errorThrown);
              }
          })
      }
});
    $("form[id='changePassword']").validate({
      rules: {
        password_old: {
          required: true,
          minlength: 6,
        },
        password: {
          required: true,
          minlength: 6,
        },
        re_password: {
          required: true,
          minlength: 6,
          equalTo: '[name="password"]'
        },
      },
      messages: {
        password_old:{
          required: "Vui lòng nhập mật khẩu",
          minlength: "Mật khẩu phải nhiều hơn 6 ký tự",
        },
        password:{
          required: "Vui lòng nhập mật khẩu mới",
          minlength: "Mật khẩu mới phải nhiều hơn 6 ký tự",
        },
        re_password:{
          required: "Vui lòng nhập lại mật khẩu mới",
          minlength: "Mật khẩu mới phải nhiều hơn 6 ký tự",
          equalTo: "Mật khẩu mới không trùng khớp",
        },
      },
      submitHandler: function() {
          let option={
              'id' : user_id,
              'password_old': $("#password_old").val(),
              'password': $("#password").val(),
              '_token': _token,
          }
          $.ajax({
              url:'ajax/user/changePassword',
              type:'POST',
              data: option,
              success:function(res){
                  if(res.flag == true){
                    Swal.fire({
                      width: 600,
                      position: "center",
                      icon: "success",
                      title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Cập nhật mật khẩu thành công!</span>",
                      showConfirmButton: false,
                      timer: 1500
                    });
                    location.reload();
                  }else{
                      Swal.fire({
                          width: 600,
                          icon: "error",
                          title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Cập nhật mật khẩu thất bại</span>",
                          html: "<span style='font-family: Open Sans;font-size: 2rem;'>"+res.error+"</span>",
                        });
                  }
              },
              error:function(jqXHR, textStatus, errorThrown){
                  //Xử lý dữ liệu khi gặp lỗi 
                  console.log('Lỗi:' + textStatus + ' '+ errorThrown);
              }
          })
      }
    });
    // Smooth scrolling using jQuery easing
    $(document).ready(function() {
        // $('#updateUser').submit(function(e){
        //     e.preventDefault();
        //     HT.userValidate();
        // })
        // $('#changeEmail').submit(function(e){
        //   e.preventDefault();
        //   HT.emailValidate();
        // })
        // $('#changePassword').submit(function(e){
        // e.preventDefault();
        // HT.passwordValidate();
        // })
        HT.getLocation();
        HT.loadCity();
        $('#sign_up_').submit(function(e){
          Swal.fire({
              width: 600,
              position: "center",
              icon: "success",
              title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Đăng ký nhận tin thành công!</span>",
              showConfirmButton: true,
            });
            $('#email_sign_up').val('');
          e.preventDefault();
        })
        $('#keywords').keyup(function(){
        var query=$(this).val();
        if(query.length>=1){
            var option={
                'query' : query,
                '_token': _token,
            }
            $.ajax({
                url:'/ajax/autocomplete',
                type:'POST',
                data: option,
                success:function(res){
                    $('#search-ajax').html(res);
                },
                error:function(jqXHR, textStatus, errorThrown){
                    //Xử lý dữ liệu khi gặp lỗi 
                    console.log('Lỗi:' + textStatus + ' '+ errorThrown);
                }
            })
        }else{
            $('#search-ajax').html('');
        }
        });

    });
  })(jQuery); // End of use strict
  