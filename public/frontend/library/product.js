(function($) {
    "use strict"; // Start of use strict
    var HT={};
    var _token= $('meta[name="csrf-token"]').attr('content');
    HT.addToCart=(option)=>{
        $.ajax({
            url:'/ajax/add-to-cart',
            type:'POST',
            data: option,
            success:function(res){
                if( res.html!='' ){
                    $('.dropdown-cart-products').html(res.html);
                    $('.cart-count').html(res.cart_count);
                }
                Swal.fire({
                    width: 600,
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Thêm Giỏ Hàng Thành Công!</span>",
                    icon: "success",
                    showCancelButton:true,
                    cancelButtonText: "<span style='font-family: Open Sans;font-size: 1.4rem;'>Xem Tiếp</span>",
                    confirmButtonClass:"btn-success",
                    confirmButtonText:"<span style='font-family: Open Sans;font-size: 1.4rem;'>Đến Trang Giỏ Hàng</span>",
                  }).then((result)=>{
                    if(result.isConfirmed){
                        window.location.href="/cart"
                    }
                  });
                  $('.remove-cart').on('click',function(){
                    let id=$(this).data('session_id');
                    let array=[];
                    var option={
                        'coupon' : array,
                        'session_id' : id,
                        '_token': _token,
                    }
                    HT.removeToCart(option);
                })
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            }
        })
    }
    HT.quickView=()=>{
        $('.btn-quickview').on('click',function(e){
            e.preventDefault();
            let option={
                'product_id' : $(this).data('product_id')
            }
            $.ajax({
                url:'/ajax/san-pham/loadProductQuickView',
                type:'GET',
                data: option,
                success:function(res){
                    if(res.flag==true){
                        if(res.output.product_gallery != ''){
                            $('.product_quickview_gallery').html(res.output.product_gallery);
                            $('#product_quickview_slide').html(res.output.product_slide);
                        }else{
                            $('.product_quickview_gallery').html(res.output.product_thumb);
                            $('#product_quickview_slide').html(res.output.product_thumb);
                        }
                        $('#product_quickview_price').html(res.output.product_price);
                        $('#product_quickview_title').html(res.output.product_name);
                        $('#product_quickview_size').html(res.output.product_size);
                        $('#qty').addClass('cart_product_qty_'+res.output.product_id+'');
                        $('#product_quickview_input').html(res.output.input_hidden);
                        $('#product_quickview_btn-cart').html(res.output.btn_cart);
                        $('#product_quickview_btn-wishlist').html(res.output.btn_wishlist);
                        $('#product_quickview_content').html(res.output.product_content);
                        $('.product-gallery-item').on('click',function(){
                            $('.product-gallery-item').removeClass('active');
                            $(this).addClass('active');
                            $('#product-zoom').attr('src',$(this).attr('data-image'));
                        });
                        $('#product_quickvie_ratings-val').css('width', ''+res.output.ratings_val+'%');
                        $('#product_quickvie_review-link').html(res.output.review_link);
                        $('.item-size').on('click',function test(){
                            $('.item-size').removeClass('active');
                            $(this).addClass('active');
                            let value=$(this).attr('value');
                            $('.cart_product_size_active').attr('value',value);
                            $('.quantity').html('('+$(this).attr('data-quantity')+')Còn Hàng')
                        });
                        $('.btn-cart').click(function(e){
                            e.preventDefault();
                            if($('.cart_product_size_active').attr('value') == undefined){
                                Swal.fire({
                                    width: 600,
                                    icon: "info",
                                    title: "<span style='font-family: Open Sans;font-size: 2rem;'>Chọn Size Để Thêm Vào Giỏ Hàng!!</span>",
                                    confirmButtonText:"<span style='font-family: Open Sans;font-size: 1.4rem;'>Đóng</span>",
                                  });
                            }else{
                                var id=$(this).data('id_product');
                                var option={
                                    'cart_product_id' : $('.cart_product_id_'+id).val(),
                                    'cart_product_name' : $('.cart_product_name_'+id).val(),
                                    'cart_product_thumb' : $('.cart_product_thumb_'+id).val(),
                                    'cart_product_price' : $('.cart_product_price_'+id).val(),
                                    'cart_product_qty' : $('.cart_product_qty_'+id).val(),
                                    'cart_product_size' : $('.cart_product_size_active').val(),
                                    '_token': _token,
                                }
                                HT.addToCart(option);
                            }
                        })
                        $('.btn-wishlist-quickview').click(function(e){
                            e.preventDefault();
                            var id=$(this).data('id_product');
                            var option={
                                'wishlist_product_id' : $('.cart_product_id_'+id).val(),
                                'wishlist_product_name' : $('.cart_product_name_'+id).val(),
                                'wishlist_product_thumb' : $('.cart_product_thumb_'+id).val(),
                                'wishlist_product_price' : $('.cart_product_price_'+id).val(),
                                '_token': _token,
                            }
                            HT.addToWishList(option);
                        })
                    }
                },
                error:function(jqXHR, textStatus, errorThrown){
                    //Xử lý dữ liệu khi gặp lỗi 
                    console.log('Lỗi:' + textStatus + ' '+ errorThrown);
                }
            })
        });
    }
    HT.removeToCart=(option)=>{
        $.ajax({
            url:'/ajax/destroy-to-cart',
            type:'POST',
            data: option,
            success:function(res){
                if(res.cart_count!=0){
                    $('.cart-count').html(res.cart_count);
                    $('#cart-product-id-session-'+res.session_id+'').fadeOut();
                    $('#cart-total').html(Intl.NumberFormat('en-DE').format(res.total)+'đ');
                }else{
                    $('.cart-count').html(res.cart_count);
                    $('.dropdown-cart-products').html('<p style="font-size: 1.6rem;font-family: Be VietNam" class="text-center">Hiện chưa có sản phẩm!</p><div class="dropdown-cart-total"><span style="font-size: 1.4rem">Tổng tiền:</span><span style="font-size: 1.6rem;color: #ef837b" id="cart-total" class="cart-total-price">0đ</span></div><div style="justify-content: center" class="dropdown-cart-action"><a href="/cart"class="btn btn-primary">XEM GIỎ HÀNG</a></div>');
                }
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            }
        })
    }
    HT.addToWishList=(option)=>{
        $.ajax({
            url:'/ajax/add-to-wishlist',
            type:'POST',
            data: option,
            success:function(res){
                    if( res.html!=''){
                        $('.compare-products').html(res.html);
                        $('.wishlist-count').html(res.wishlist_count);
                        if(res.flag==0){
                            Swal.fire({
                                width: 600,
                                position: "center",
                                icon: "success",
                                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Thêm danh sách thành công!</span>",
                                showConfirmButton: false,
                                timer: 1500
                              });
                        }else{
                            Swal.fire({
                                width: 600,
                                icon: "error",
                                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Sản phẩm đã có trong danh sách</span>",
                                html:"<span style='font-family: Open Sans;font-size: 2rem;'>Vui lòng kiểm tra lại!!</span>",
                              });
                        }
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
                        })
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
        $('.product-gallery-item').on('click',function(){
            $('.product-gallery-item').removeClass('active');
            $(this).addClass('active');
            $('#product-zoom').attr('src',$(this).attr('data-image'));
        });
        $('.item-size').on('click',function(){
            $('.item-size').removeClass('active');
            $(this).addClass('active');
            let value=$(this).attr('value');
            $('.cart_product_size_active').attr('value',value);
            $('.quantity').html('('+$(this).attr('data-quantity')+')Còn Hàng')
        });
        $('.btn-cart').click(function(e){
            e.preventDefault();
            if($('.cart_product_size_active').attr('value') == undefined){
                Swal.fire({
                    width: 600,
                    icon: "info",
                    title: "<span style='font-family: Open Sans;font-size: 2rem;'>Chọn Size Để Thêm Vào Giỏ Hàng!!</span>",
                    confirmButtonText:"<span style='font-family: Open Sans;font-size: 1.4rem;'>Đóng</span>",
                  });
            }else{
                var id=$(this).data('id_product');
                var option={
                    'cart_product_id' : $('.cart_product_id_'+id).val(),
                    'cart_product_name' : $('.cart_product_name_'+id).val(),
                    'cart_product_thumb' : $('.cart_product_thumb_'+id).val(),
                    'cart_product_price' : $('.cart_product_price_'+id).val(),
                    'cart_product_qty' : $('.cart_product_qty_'+id).val(),
                    'cart_product_size' : $('.cart_product_size_active').val(),
                    '_token': _token,
                }
                HT.addToCart(option);
            }
        });
        $('.remove-cart').on('click',function(e){
            e.preventDefault();
            let id=$(this).data('session_id');
            let array=[];
            var option={
                'coupon' : array,
                'session_id' : id,
                '_token': _token,
            }
            HT.removeToCart(option);
        });
        $('.btn-wishlist').click(function(e){
            e.preventDefault();
            var id=$(this).data('id_product');
            var option={
                'wishlist_product_id' : $('.cart_product_id_'+id).val(),
                'wishlist_product_name' : $('.cart_product_name_'+id).val(),
                'wishlist_product_thumb' : $('.cart_product_thumb_'+id).val(),
                'wishlist_product_price' : $('.cart_product_price_'+id).val(),
                '_token': _token,
            }
            HT.addToWishList(option);
        });
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
        $('.rate').click(function(e){
            if($( "input[type=hidden][name=user_id]" ).val() == ''){
                Swal.fire({
                    width: 600,
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Vui lòng đăng nhập để thực hiện chức năng!</span>",
                    icon: "info",
                    showCancelButton:true,
                    cancelButtonText: "<span style='font-family: Open Sans;font-size: 1.4rem;'>Đóng</span>",
                    confirmButtonClass:"btn-success",
                    confirmButtonText:"<span style='font-family: Open Sans;font-size: 1.4rem;'>Đến trang đăng nhập</span>",
                  }).then((result)=>{
                    if(result.isConfirmed){
                        window.location.href="/login"
                    }
                  });
                  $("input[type='radio'][name=rate]").prop( "checked", false );
            }
        })
        $('#comment').submit(function(e){
            if($( "input[type=hidden][name=user_id]" ).val() != '' && $('#comment-comment').val() != '' && $("input[type='radio'][name=rate]:checked").val()!=undefined){
                let option={
                    'user_id' : $( "input[type=hidden][name=user_id]" ).val(),
                    'user_email' : $( "input[type=text][name=user_email]" ).val(),
                    'user_name' : $( "input[type=text][name=user_name]" ).val(),
                    'comment' : $('#comment-comment').val(),
                    'product_id' : $( "input[type=hidden][name=product_id]" ).val(),
                    'rating' : $("input[type='radio'][name=rate]:checked").val(),
                    '_token': _token,
                }
                $.ajax({
                    url:'/ajax/san-pham/comment',
                    type:'POST',
                    data: option,
                    success:function(res){
                        if(res.flag==true){
                            Swal.fire({
                                width: 600,
                                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Cảm ơn bạn đã đánh giá!</span>",
                                html: "<span style='font-family: Open Sans;font-size: 2rem;'>Chúng tôi sẽ duyệt sớm nhất</span>",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 3000,
                              });
                              window.setTimeout(function(){ 
                                location.reload();
                            } ,3000);
                        }else{
                            Swal.fire({
                                width: 600,
                                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Có lỗi trong quá trình thực hiện!</span>",
                                html: "<span style='font-family: Open Sans;font-size: 2rem;'>Vui lòng thử lại</span>",
                                icon: "error",
                                timer: 3000,
                              });
                              window.setTimeout(function(){ 
                                location.reload();
                            } ,3000);
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        //Xử lý dữ liệu khi gặp lỗi 
                        console.log('Lỗi:' + textStatus + ' '+ errorThrown);
                    }
                })
            }else if($( "input[type=hidden][name=user_id]" ).val() == ''){
                Swal.fire({
                    width: 600,
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Vui lòng đăng nhập để thực hiện chức năng!</span>",
                    icon: "info",
                    showCancelButton:true,
                    cancelButtonText: "<span style='font-family: Open Sans;font-size: 1.4rem;'>Đóng</span>",
                    confirmButtonClass:"btn-success",
                    confirmButtonText:"<span style='font-family: Open Sans;font-size: 1.4rem;'>Đến trang đăng nhập</span>",
                  }).then((result)=>{
                    if(result.isConfirmed){
                        window.location.href="/login"
                    }
                  });

            }else if($('#comment-comment').val() == ''){
                Swal.fire({
                    width: 600,
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Vui lòng nhập đánh giá!</span>",
                    icon: "info"
                  });
            }else if($("input[type='radio'][name=rate]:checked").val()==undefined){
                Swal.fire({
                    width: 600,
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Vui lòng đánh giá sao!</span>",
                    icon: "info"
                  });
            }
            e.preventDefault();
        });
        $('.comment-reply').on('click',function(){
            $('.comment-reply-key').each(function(){
                $(this).hide();
            })
            $('#comment-reply-'+$(this).data('key')).show();
        });
        $('.reply-comment').click(function(){
            if($( "input[type=hidden][name=reply_user_id_"+$(this).data('key')+"]" ).val() != '' && $('#reply-comment-'+$(this).data('key')).val() != ''){
                let option={
                    'user_id' : $( "input[type=hidden][name=reply_user_id_"+$(this).data('key')+"]" ).val(),
                    'user_email' : $( "input[type=text][name=reply_user_email_"+$(this).data('key')+"]" ).val(),
                    'user_name' : $( "input[type=text][name=reply_user_name_"+$(this).data('key')+"]" ).val(),
                    'comment' : $('#reply-comment-'+$(this).data('key')).val(),
                    'product_id' : $( "input[type=hidden][name=reply_product_id_"+$(this).data('key')+"]" ).val(),
                    'parent_id' :  $(this).data('key'),
                    '_token': _token,
                }
                $.ajax({
                    url:'/ajax/san-pham/reply-comment',
                    type:'POST',
                    data: option,
                    success:function(res){
                        if(res.flag==true){
                            Swal.fire({
                                width: 600,
                                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Trả lời bình luận thành công</span>",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 3000,
                                });
                                window.setTimeout(function(){ 
                                    location.reload();
                                } ,3000);
                        }else{
                            Swal.fire({
                                width: 600,
                                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Có lỗi trong quá trình thực hiện!</span>",
                                html: "<span style='font-family: Open Sans;font-size: 2rem;'>Vui lòng thử lại</span>",
                                icon: "error",
                                timer: 3000,
                              });
                              window.setTimeout(function(){ 
                                location.reload();
                            } ,3000);
                        }
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        //Xử lý dữ liệu khi gặp lỗi 
                        console.log('Lỗi:' + textStatus + ' '+ errorThrown);
                    }
                })
            }else if($( "input[type=hidden][name=reply_user_id_"+$(this).data('key')+"]" ).val() == ''){
                Swal.fire({
                    width: 600,
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Vui lòng đăng nhập để thực hiện chức năng!</span>",
                    icon: "info",
                    showCancelButton:true,
                    cancelButtonText: "<span style='font-family: Open Sans;font-size: 1.4rem;'>Đóng</span>",
                    confirmButtonClass:"btn-success",
                    confirmButtonText:"<span style='font-family: Open Sans;font-size: 1.4rem;'>Đến trang đăng nhập</span>",
                  }).then((result)=>{
                    if(result.isConfirmed){
                        window.location.href="/login"
                    }
                  });

            }else if($('#reply-comment-'+$(this).data('key')).val() == ''){
                Swal.fire({
                    width: 600,
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Vui lòng nhập đánh giá!</span>",
                    icon: "info"
                  });
            }
        });
        $('.remove-comment').click(function(){
            Swal.fire({
                width: 600,
                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Xóa bình luận này khỏi bài viết!</span>",
                icon: "info",
                showConfirmButton:false,
                showCancelButton:true,
                showDenyButton: true,
                denyButtonText: "<span style='font-family: Open Sans;font-size: 1.4rem;'>Xóa</span>",
                cancelButtonText: "<span style='font-family: Open Sans;font-size: 1.4rem;'>Đóng</span>",
              }).then((result)=>{
                if(result.isDenied){
                    let option={
                        'id':$(this).data('key'),
                        '_token': _token,
                    }
                    $.ajax({
                        url:'/ajax/san-pham/remove-comment',
                        type:'POST',
                        data: option,
                        success:function(res){
                            if(res.flag==true){
                                Swal.fire({
                                    width: 600,
                                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Đã xóa bình luận!</span>",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 3000,
                                  });
                                  window.setTimeout(function(){ 
                                    location.reload();
                                } ,3000);
                            }else{
                                Swal.fire({
                                    width: 600,
                                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Có lỗi trong quá trình thực hiện!</span>",
                                    html: "<span style='font-family: Open Sans;font-size: 2rem;'>Vui lòng thử lại</span>",
                                    icon: "error"
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
        HT.quickView();
    });
  
  })(jQuery); // End of use strict
  