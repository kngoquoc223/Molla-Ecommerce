(function($) {
    "use strict"; // Start of use strict
    var HT={};
    var _token= $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        $('#checkOrder').submit(function(e){
            e.preventDefault();
            if($('#order-code').val() != ''){
                let option={
                    'order_code' : $('#order-code').val(),
                    '_token': _token,
                }
                $.ajax({
                    url:'/ajax/check-order',
                    type:'POST',
                    data: option,
                    beforeSend: function () {
                        Swal.showLoading();
                    },
                    success:function(res){
                        if(res.flag == true){
                            Swal.close();
                            $('#order').html(res.html);
                        }
                        else{
                            $('#order-code').val('');
                            $('#order').html('');
                            Swal.fire({
                                width: 600,
                                icon: "error",
                                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Mã đơn hàng không đúng vui lòng kiểm tra lại!</span>",
                              });
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        //Xử lý dữ liệu khi gặp lỗi 
                        console.log('Lỗi:' + textStatus + ' '+ errorThrown);
                    }
                })
            }else{
                Swal.fire({
                    width: 600,
                    icon: "error",
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Vui lòng nhập mã đơn hàng để tiếp tục!</span>",
                  });
            }
        })
    });
  
  })(jQuery); // End of use strict
  