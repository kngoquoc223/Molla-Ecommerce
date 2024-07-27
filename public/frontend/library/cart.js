(function($) {
    "use strict"; // Start of use strict
    var HT={};
    var _token= $('meta[name="csrf-token"]').attr('content');
    HT.updateToCart=(option)=>{
        $.ajax({
            url:'ajax/update-to-cart',
            type:'POST',
            data: option,
            success:function(res){
                let sub= res.price * res.qty;
                $('#total-col-'+res.session_id).html(Intl.NumberFormat('en-DE').format(sub) +'đ');
                $('#total').html(Intl.NumberFormat('en-DE').format(res.total) + 'đ');
                let checkout= res.total - res.total_coupon;
                if(checkout <0){
                    checkout=0;
                }
                $('#total-coupon').html(Intl.NumberFormat('en-DE').format(res.total_coupon)+'đ');
                $('#total-checkout').html(Intl.NumberFormat('en-DE').format(checkout)+'đ');
                $('.cart-count').html(res.cart_count);
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            }
        })
    }
    HT.destroyToCart=(option)=>{
        $.ajax({
            url:'/ajax/destroy-to-cart',
            type:'POST',
            data: option,
            success:function(res){
                if(res.cart_count!=0){
                    $('.cart-count').html(res.cart_count);
                    $('#product-id-session-'+res.session_id+'').fadeOut();
                    $('#total').html(Intl.NumberFormat('en-DE').format(res.total)+'đ');
                    let checkout= res.total - res.total_coupon;
                    if(checkout <0){
                        checkout=0;
                    }
                    $('#total-coupon').html(Intl.NumberFormat('en-DE').format(res.total_coupon)+'đ');
                    $('#total-checkout').html(Intl.NumberFormat('en-DE').format(checkout)+'đ');
                }else{
                    $('.cart-count').html(res.cart_count);
                    $('#total').html(Intl.NumberFormat('en-DE').format(res.total)+'đ');
                    let checkout= res.total - res.total_coupon;
                    if(checkout <0){
                        checkout=0;
                    }
                    $('#total-coupon').html(Intl.NumberFormat('en-DE').format(res.total_coupon)+'đ');
                    $('#total-checkout').html(Intl.NumberFormat('en-DE').format(checkout)+'đ');
                    $('.table-mobile').find("tbody").html('<tr><td colspan="5"><center>Hiện chưa có sản phẩm!</center></td></tr>')
                    $('.btn-order').attr('href',"#")
                }
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            }
        })
    }
    HT.destroyToCoupon=(option)=>{
        $.ajax({
            url:'ajax/destroy-to-coupon',
            type:'POST',
            data: option,
            success:function(res){
                if(res.flag == true){
                    location.reload();
                }
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            }
        })
    }
    HT.removeToWishList=(option)=>{
        $.ajax({
            url:'/ajax/remove-to-wishlist',
            type:'POST',
            data: option,
            success:function(res){
                if(res.wishlist_count!=0){
                    $('.wishlist-count').html(res.wishlist_count);
                    $('#wishlist-product-id-session-'+res.session_id+'').fadeOut();
                }else{
                    $('.wishlist-count').html(res.wishlist_count);
                    $('.compare-products').html('<p style="font-size: 1.6rem;font-family: Be VietNam" class="text-center">Hiện chưa có sản phẩm!</p>');
                }
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            }
        })
    }
    // Smooth scrolling using jQuery easing
    $(document).ready(function() {
        $('.update-sub-total').on('change',function(e){
            e.preventDefault();
            let array=[];
            $('.coupon').each(function(){
                let value=$(this).attr('data-value');
                let condition=$(this).attr('data-condition');
                array.push({'value':value,'condition':condition})
            })
            let id=$(this).data('session_id');
            var option={
                'coupon' : array,
                'session_id' : id,
                'qty' : $(this).val(),
                'price' : $(this).data('price'),
                '_token': _token,
            }
            HT.updateToCart(option);
        })
        $('.delete-cart').on('click',function(e){
            e.preventDefault();
            let array=[];
            $('.coupon').each(function(){
                let value=$(this).attr('data-value');
                let condition=$(this).attr('data-condition');
                array.push({'value':value,'condition':condition})
            })
            let id=$(this).data('session_id');
            var option={
                'coupon' : array,
                'session_id' : id,
                '_token': _token,
            }
            HT.destroyToCart(option);
        })
        $('.delete-coupon').on('click',function(e){
            e.preventDefault();
            let id=$(this).data('coupon_code');
            var option={
                'coupon_code' : id,
                '_token': _token,
            }
            HT.destroyToCoupon(option);
        })
        $('.remove-wishlist').click(function(e){
            e.preventDefault();
            let id=$(this).data('session_id');
            let array=[];
            var option={
                'coupon' : array,
                'session_id' : id,
                '_token': _token,
            }
            HT.removeToWishList(option);
        });
        $('.remove-wishlist-all').click(function(e){
            Swal.fire({
                width: 600,
                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Làm mới danh sách!</span>",
                icon: "info",
                showCancelButton:true,
                cancelButtonText: "<span style='font-family: Open Sans;font-size: 1.4rem;'>Đóng</span>",
                confirmButtonClass:"btn-success",
                confirmButtonText:"<span style='font-family: Open Sans;font-size: 1.4rem;'>Làm mới</span>",
              }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url:'/ajax/remove-to-wishlist-all',
                        type:'POST',
                        headers: 
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(res){
                            if(res.flag==true){
                                Swal.fire({
                                    width: 600,
                                    position: "center",
                                    icon: "success",
                                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Làm mới danh sách thành công</span>",
                                    showConfirmButton: false,
                                    timer: 1500
                                  });
                                  location.reload();
                            }
                        },
                        error:function(jqXHR, textStatus, errorThrown){
                            //Xử lý dữ liệu khi gặp lỗi 
                            console.log('Lỗi:' + textStatus + ' '+ errorThrown);
                        }
                    })
                }
              });
        });
        $('.btn-order').click(function(e){
            if($(this).attr('href') == '#'){
                Swal.fire({
                    width: 600,
                    icon: "error",
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Để tiến hành thanh toán!</span>",
                    html: "<span style='font-family: Open Sans;font-size: 2rem;'>Hãy thêm sản phẩm vào giỏ hàng.</span>",
                  });
            }
        });
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
  