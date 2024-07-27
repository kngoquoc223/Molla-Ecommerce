(function($) {
    "use strict"; // Start of use strict
    var HT={};
    var _token= $('meta[name="csrf-token"]').attr('content');
    $("form[id='checkoutValidate']").validate({
            rules: {
              name: {
                minlength: 8,
                required : true,
              },
              email: {
                required: true,
                email: true
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
              method_payment:{
                min:1,
              },
              method_delivery:{
                min:1,
              },
            },
            messages: {
              name:{
                required: "Vui lòng nhập Họ Tên",
                minlength: "Họ Tên phải nhiều hơn 8 ký tự"
              },
              email:{
                required: "Vui lòng nhập địa chỉ Email",
                email: "Địa chỉ Email không hợp lệ (vd:abc@gmail.com)",
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
              method_payment:{
                min: "Vui lòng chọn Hình thức thanh toán",
              },
              method_delivery:{
                min: "Vui lòng chọn Phương thức vận chuyển",
              },
            },
            submitHandler: function(form) {
              Swal.showLoading();
              form.submit();
            }
    });
    HT.checkoutDelivery=(option)=>{
        $.ajax({
            url:'ajax/calculate-delivery',
            type:'GET',
            data: option,
            success:function(res){
                var total_checkout=res.cost+$('#temp-total-checkout').data('value');
                $('.fee-delivery').val(res.cost);
                $('.total-checkout').val(total_checkout);
                $('#cost').html(Intl.NumberFormat('en-DE').format(res.cost)+'đ');
                $('#total-checkout').html(Intl.NumberFormat('en-DE').format(total_checkout)+'đ');
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            }
        })
    }
    HT.loadmethodPayment=()=>{
        if(method_payment != ''){
            $('.method-payment').val(method_payment).trigger('change');
        }
    }
    // Smooth scrolling using jQuery easing
    $(document).ready(function() {
        $('.method-delivery').change(function(e){
            e.preventDefault();
            if($(this).val() != 0){
                var province=$('.province').val();
                var district=$('.districts').val();
                var ward=$('.wards').val();
                if(province != 0 && district != 0 && ward != 0){
                    var option={
                        'province_id' : province,
                        'district_id' : district,
                        'ward_id' : ward,
                        'delivery' : $(this).val(),
                    }
                    HT.checkoutDelivery(option);
                }else
                {
                    Swal.fire({
                        icon: "error",
                        title: "<span style='font-family: Open Sans'>Vui lòng chọn<br>Thành Phố Quận/Huyện Phường/Xã</span>",
                      });
                    $('.fee-delivery').val('0');
                    $('.total-checkout').val('0');
                    $('#cost').html('');
                    $('#total-checkout').html('');
                    $(this).val(0).trigger('change');
                }
            }else{
                $('.fee-delivery').val('0');
                $('.total-checkout').val('0');
                $('#cost').html('');
                $('#total-checkout').html('');
            }
        })
        HT.loadmethodPayment();
    });
  
  })(jQuery); // End of use strict
  