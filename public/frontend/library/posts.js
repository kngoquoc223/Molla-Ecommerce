(function($) {
    "use strict"; // Start of use strict
    var HT={};
    var _token= $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function()
    {
        $('#posts_comment').submit(function(e){
            if($( "input[type=hidden][name=user_id]" ).val() != '' && $('#comment-comment').val() != ''){
                let option={
                    'user_id' : $( "input[type=hidden][name=user_id]" ).val(),
                    'user_email' : $( "input[type=text][name=user_email]" ).val(),
                    'user_name' : $( "input[type=text][name=user_name]" ).val(),
                    'comment' : $('#comment-comment').val(),
                    'posts_id' : $( "input[type=hidden][name=posts_id]" ).val(),
                    '_token': _token,
                }
                $.ajax({
                    url:'/ajax/bai-viet/comment',
                    type:'POST',
                    data: option,
                    success:function(res){
                        if(res.flag==true){
                            Swal.fire({
                                width: 600,
                                title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Cảm ơn bạn đã bình luận!</span>",
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
                                icon: "error"
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
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Vui lòng nhập bình luận!</span>",
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
                    'posts_id' : $( "input[type=hidden][name=reply_posts_id_"+$(this).data('key')+"]" ).val(),
                    'parent_id' :  $(this).data('key'),
                    '_token': _token,
                }
                $.ajax({
                    url:'/ajax/bai-viet/reply-comment',
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
                                icon: "error"
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
                    title: "<span style='font-family: Open Sans;font-size: 2.5rem;'>Vui lòng nhập bình luận!</span>",
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
                        url:'/ajax/bai-viet/remove-comment',
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
    });
  
  })(jQuery); // End of use strict
  