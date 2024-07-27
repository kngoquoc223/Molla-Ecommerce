(function($) {
    "use strict"; // Start of use strict
    var HT={};
    var _token= $('meta[name="csrf-token"]').attr('content');
    HT.loadMoreProduct=(option)=>{
        $.ajax({
            url: ENDPOINT + '?page=' + page,
            data: option,
            dataType:"json",
            type:'GET',
            beforeSend: function(){
                $('.auto-load').show();
                $('.more').hide();
            }
            })
            .done(function(res){
                if(res.html == ''){
                    $('.auto-load').hide();
                    return;
                }
                $('#countProduct').html(res.countProduct);
                $('.auto-load').hide();
                $('.more').show();
                $('#data-loadProduct').append(res.html);
            })
            .fail(function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            });
    
    }
    HT.loadFilterCat=(option)=>{
        $.ajax({
            url:'/ajax/danh-muc/loadFilterCat',
            type:'GET',
            data: option,
            success:function(res){
                if(res.flag == true){
                    if(res.html !=''){
                        $('#data-loadProduct').html(res.html);
                        HT.quickView();
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
                    }else{
                        $('#data-loadProduct').html('Không tìm thấy kết quả. Vui lòng thử lại!');
                    }

                }
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            }
        })
    }
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
                })
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            }
        })
    }
    HT.quickView=()=>{
        $('.btn-quickview').on('click',function(){
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
                        $('#product_quickvie_ratings-val').css('width', ''+res.output.ratings_val+'%');
                        $('#product_quickvie_review-link').html(res.output.review_link);
                        $('.product-gallery-item').on('click',function(){
                            $('.product-gallery-item').removeClass('active');
                            $(this).addClass('active');
                            $('#product-zoom').attr('src',$(this).attr('data-image'));
                        });
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
        // $(".moreProduct").click(function(e){
        //     e.preventDefault();
        //     page++
        //     var cat_id = new Array();
        //     if($("input:checkbox[name=cat]:checked").length != 0){
        //             $("input:checkbox[name=cat]:checked").each(function() {
        //                 cat_id.push($(this).val()); 
        //             });
        //     }else{
        //             $("input:checkbox[name=cat]").each(function() { 
        //                 cat_id.push($(this).val()); 
        //             });
        //     }
        //     let size = new Array();
        //     $("input:checkbox[name=size]:checked").each(function() { 
        //         size.push($(this).val()); 
        //     });
        //     let option={
        //         'attr_value_id' : size,
        //         'order_by' : $('.order_by').val(),
        //         'price':
        //         {
        //             'price_min': $('input[name="price_cat"]:checked').attr("min"),
        //             'price_max' : $('input[name="price_cat"]:checked').attr("max"),
        //         },
        //         'cat' : cat_id,
        //     }
        //     HT.loadMoreProduct(option)
        // })
        $('.cat').on('click',function(){
            var cat_id = new Array();
            if($("input:checkbox[name=cat]:checked").length != 0){
                    $("input:checkbox[name=cat]:checked").each(function() {
                        cat_id.push($(this).val()); 
                    });
            }else{
                    $("input:checkbox[name=cat]").each(function() { 
                        cat_id.push($(this).val()); 
                    });
            }
            let size = new Array();
            $("input:checkbox[name=size]:checked").each(function() { 
                size.push($(this).val()); 
            });
            let option={
                'attr_value_id' : size,
                'order_by' : $('.order_by').val(),
                'price':
                {
                    'price_min': $('input[name="price_cat"]:checked').attr("min"),
                    'price_max' : $('input[name="price_cat"]:checked').attr("max"),
                },
                'cat' : cat_id,
            }
            HT.loadFilterCat(option);
        })
        $('.size').on('click',function(){
            if(cat_id.length > 1){
                if($("input:checkbox[name=cat]").val() != undefined){
                    var cat = new Array();
                    if($("input:checkbox[name=cat]:checked").length != 0){
                        $("input:checkbox[name=cat]:checked").each(function() {
                            cat.push($(this).val()); 
                        });
                    }else{
                        $("input:checkbox[name=cat]").each(function() {
                            cat.push($(this).val()); 
                        });
                    }
                }
            }else{
                cat=cat_id;
            }
            let size= new Array(); 
            $("input:checkbox[name=size]:checked").each(function() { 
                size.push($(this).val()); 
            });
             let option={
                'attr_value_id' : size,
                'order_by' : $('.order_by').val(),
                'price':
                {
                    'price_min': $('input[name="price_cat"]:checked').attr("min"),
                    'price_max' : $('input[name="price_cat"]:checked').attr("max"),
                },
                'cat' : cat,
            }
            HT.loadFilterCat(option);
        })
        $('.order_by').on('change',function(){
            if(cat_id.length > 1){
                if($("input:checkbox[name=cat]").val() != undefined){
                    var cat = new Array();
                    if($("input:checkbox[name=cat]:checked").length != 0){
                        $("input:checkbox[name=cat]:checked").each(function() {
                            cat.push($(this).val()); 
                        });
                    }else{
                        $("input:checkbox[name=cat]").each(function() {
                            cat.push($(this).val()); 
                        });
                    }
                }
            }else{
                cat=cat_id;
            }
            let size = new Array(); 
            $("input:checkbox[name=size]:checked").each(function() { 
                size.push($(this).val()); 
            });
             let option={
                'attr_value_id' : size,
                'order_by' : $(this).val(),
                'price':
                {
                    'price_min': $('input[name="price_cat"]:checked').attr("min"),
                    'price_max' : $('input[name="price_cat"]:checked').attr("max"),
                },
                'cat' : cat,
            }
            HT.loadFilterCat(option);
        })
        $('input[name=price_cat]').change(function(){
            if(cat_id.length > 1){
                if($("input:checkbox[name=cat]").val() != undefined){
                    var cat = new Array();
                    if($("input:checkbox[name=cat]:checked").length != 0){
                        $("input:checkbox[name=cat]:checked").each(function() {
                            cat.push($(this).val()); 
                        });
                    }else{
                        $("input:checkbox[name=cat]").each(function() {
                            cat.push($(this).val()); 
                        });
                    }
                }
            }else{
                cat=cat_id;
            }
            let size = new Array(); 
            $("input:checkbox[name=size]:checked").each(function() { 
                size.push($(this).val()); 
            });
             let option={
                'attr_value_id' : size,
                'order_by' : $('.order_by').val(),
                'price':
                {
                    'price_min': $('input[name="price_cat"]:checked').attr("min"),
                    'price_max' : $('input[name="price_cat"]:checked').attr("max"),
                },
                'cat' : cat,
            }
            HT.loadFilterCat(option);
        })
        $('.sidebar-filter-clear').on('click',function(){
            $('input[name=price_cat]').prop('checked',false).trigger('change');
            $("input:checkbox[name=size]:checked").each(function() { 
                $(this).prop('checked',false).trigger('click');
            });
            $("input:checkbox[name=cat]:checked").each(function() { 
                $(this).prop('checked',false).trigger('click');
            });
        })
    });
  
  })(jQuery); // End of use strict
  