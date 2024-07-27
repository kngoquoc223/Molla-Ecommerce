(function($) {
    "use strict"; // Start of use strict
    var HT={};
    var _token= $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function()
    {
        $('#contact_submit').submit(function(e){
            Swal.fire({
                width: 600,
                position: "center",
                icon: "success",
                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Đã gửi lời nhắn!</span>",
                html: "<span style='font-family: Open Sans;font-size: 2rem;'>Chúng tôi sẽ phản hồi sớm nhất.Vui lòng kiểm tra mail</span>",
                showConfirmButton: false,
                timer: 3000
              });
              window.setTimeout(function(){ 
                location.reload();
            } ,3000);
            e.preventDefault();
        })
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
  