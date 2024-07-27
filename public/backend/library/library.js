(function($) {
    "use strict"; // Start of use strict
    var HT={};
    var _token= $('meta[name="csrf-token"]').attr('content');
    HT.select2= () => {
        if($('.setupSelect2').length){
            $('.setupSelect2').select2();
        }
 
    }
    HT.switchery=() => {
        $('.js-switch').each(function(){
         //   let _this=$(this)
            var switchery = new Switchery(this, { color: '#1AB394' });
        })
    }
    HT.checkAll=() => {
        if($('#checkAll').length){
            $(document).on('click', '#checkAll',function(){
                let isChecked= $(this).prop('checked')

                $('.checkBoxItem').prop('checked',isChecked);
                $('.checkBoxItem').each(function(){
                    let _this=$(this)
                    HT.changeBackground(_this)
                })
            })
        }
    }
    HT.checkBoxItem=() => {
        if($('.checkBoxItem').length){
            $(document).on('click', '.checkBoxItem',function(){
                let _this = $(this)
                HT.changeBackground(_this)
                HT.allChecked()
            })
     }
    }
    HT.changeBackground= (object) => {
        let isChecked = object.prop('checked')
        if(isChecked){
            object.closest('tr').addClass('active-bg')
        }else{
            object.closest('tr').removeClass('active-bg')
        }
    }
    HT.allChecked = () => {
        let allChecked = $('.checkBoxItem:checked').length === $('.checkBoxItem').length;
        $('#checkAll').prop('checked',allChecked);
    }
    HT.changeStatusAll= () => {
        if($('.changeStatusAll').length){
            $(document).on('click', '.changeStatusAll',function(e){
                let _this=$(this)
                let id = []
                $('.checkBoxItem').each(function(){
                    let checkBox=$(this)
                    if(checkBox.prop('checked')){
                        id.push(checkBox.val())
                    }
                })
                let option = {
                    'value' : _this.attr('data-value'), 
                    'model' : _this.attr('data-model'),
                    'field' : _this.attr('data-field'),
                    'id': id,
                    '_token': _token
                }
                $.ajax({
                    url:'/admin/ajax/dashboard/changeStatusAll',
                    type:'POST',
                    data:option,
                    dataType:'json', //Kiểu dữ liệu mong đợi trả về (json, xml, html, v.v )
                    success:function(res){                       
                        if(res.flag==true){
                            let cssActive1='background-color: rgb(26, 179, 148); border-color: rgb(26, 179, 148); box-shadow: rgb(26, 179, 148) 0px 0px 0px 16px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;';
                            let cssActive2='left: 20px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;';
                            let cssUnActive1='box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;';
                            let cssUnActive2='left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;';
                                for(let i=0;i<id.length;i++){
                                    if(option.value==2){
                                        $('.js-switch-'+id[i]).find('span.switchery').attr('style',cssActive1).find('small').attr('style',cssActive2)  
                                    }else if(option.value==1){
                                        $('.js-switch-'+id[i]).find('span.switchery').attr('style',cssUnActive1).find('small').attr('style',cssUnActive2)
                                    }
                                }
                        }
        
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        //Xử lý dữ liệu khi gặp lỗi 
                        console.log('Lỗi:' + textStatus + ' '+ errorThrown);
        
                    }
                })
                e.preventDefault()
            })
        }
    }
    HT.changeStatus=()=>{
            $(document).on('change','.status',function(e){
                let _this=$(this)
                let option = {
                    'value' : _this.val(), 
                    'modelId': _this.attr('data-modelId'), 
                    'model' : _this.attr('data-model'),
                    'field' : _this.attr('data-field'),
                    '_token': _token
                }
                if(option['model']=='UserCatalogue'){
                    if(option['modelId']==1 || option['modelId']==2){
                        Swal.fire({
                            title: "Cập nhật tình trạng thất bại!!",
                            html: '<span class="text-danger">(*)</span>: Đăng nhập hệ thống để thao tác nhóm này.',
                            icon: "error"
                            }).then(function() {
                                window.location.reload();
                            });
                        return false;
                    }
                }else if(option['model']=='User'){
                    if(option['modelId']==1){
                        Swal.fire({
                            title: "Cập nhật tình trạng thất bại!!",
                            html: '<span class="text-danger">(*)</span>: Đăng nhập hệ thống để thao tác người dùng này.',
                            icon: "error"
                            }).then(function() {
                                window.location.reload();
                            });
                        return false;
                    }
                    }
                    $.ajax({
                        url:'/admin/ajax/dashboard/changeStatus',
                        type:'POST',
                        data:option,
                        dataType:'json', //Kiểu dữ liệu mong đợi trả về (json, xml, html, v.v )
                        success:function(res){
                            let inputValue= ((option.value==1)?2:1)
                            if(res.flag==true){
                                _this.val(inputValue)
                            }
                        },
                        error:function(jqXHR, textStatus, errorThrown){
                            //Xử lý dữ liệu khi gặp lỗi 
                            console.log('Lỗi:' + textStatus + ' '+ errorThrown);
            
                        }
                    })
                    e.preventDefault()
            })
    }
    HT.uploadMulti=() => {
            $(document).on('change','.uploadMulti',function(e){
                let _this=$(this);
                var error='';
                var exten = $("#images").val().split('.').pop().toLowerCase();
                let files=_this[0].files;
                if(files.length > 4){
                    error+='<p>Tối đa được 4 ảnh</p>';
                }else if(files.length == 0){
                    error+='<p>Hãy chọn file ảnh</p>';
                }else if(files.size > 2000000){
                    error+='<p>File ảnh không được lớn hơn 2MB</p>';
                }
                // else if(jQuery.inArray(exten, ['jpg', 'jpeg', 'png']) == -1){
                //     error+='<p>File ảnh không hợp lệ</p>';
                // }
                if(error ==''){
                    $('#error_gallery').html('');
                    $('#imagesPreview').html('');
                    for(let i=0 ; i<files.length ; i++){
                    $('#imagesPreview').append('<a href="'+ URL.createObjectURL(e.target.files[i]) +'" target="_blank">'+' <img src="'+ URL.createObjectURL(e.target.files[i]) +'" width="100px"></a>');
                    }
                }else{
                    $('.uploadMulti').val('')
                    $('#imagesPreview').html('');
                    $('#error_gallery').html('<span class="text-danger">'+error+'</span>');
                }
                e.preventDefault()
            })
    }
    HT.upload=()=>{
            $(document).on('change','.upload',function(){
                    let _this=$(this);
                    const form= new FormData();
                    form.append('file', _this[0].files[0]);
                    form.append('location',_this.attr('data-location'));
                    $.ajax({
                        processData: false,
                        contentType: false,
                        url:'/admin/upload/services',
                        type:'POST',
                        data: form,
                        dataType:'json', 
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function(res){
                            if(res.error == false){
                                $('.image_show').addClass('gallery').html('<a href="/storage/'+ res.url +'" target="_blank">'+' <img src="/storage/'+ res.url +'" width="100px"></a>');
                                $('.thumb').val(res.url);
                            }else{
                                alert('Lỗi');
                            }
                        },
                        error:function(jqXHR, textStatus, errorThrown){
                            //Xử lý dữ liệu khi gặp lỗi 
                            console.log('Lỗi:' + textStatus + ' '+ errorThrown);
                        }
                    })
            })
    }
    HT.Dynamically=()=>{
            $(document).on('click','.add_item_btn',function(){
                var i=$('.row').length-1;
                $('#show-item').prepend('<div class="row"><div class="col-md-4 mb-3"><select class="form-control attr_value" name="attr['+i+'][attr_value_id]">'+option+'</select></div><div class="col-md-4 mb-3"><input placeholder="Số Lượng" class="form-control attr_quantity" type="number" name="attr['+i+'][quantity]"></div><div class="col-md-4 mb-3"><button type="button" class="btn btn-danger remove_item_btn">-</button></div></div>');
            })
            $(document).on('click','.remove_item_btn',function(e){
                e.preventDefault();
                let row_item=$(this).parent().parent();
                $(row_item).remove();
                let row1=$('.row').length-2;
                let row2=$('.row').length-2;
                $('.attr_value').each(function(){
                    $(this).attr('name','attr['+row1+'][attr_value_id]');
                    --row1;
                })
                $('.attr_quantity').each(function(){
                    $(this).attr('name','attr['+row2+'][quantity]');
                    --row2;
                })
            })
    }
    HT.submitProduct=()=>{
            $(document).on('click','.submitProduct',function(){
                var n=document.getElementsByClassName('attr_quantity');
                var sum=0;
                for(let i=0; i<n.length ; i++){
                    sum += Number(n[i].value);
                }
                $('#quantity').val(sum);
            })
    }
    // Smooth scrolling using jQuery easing
    $(document).ready(function() {
        HT.switchery();
        HT.select2();
        HT.changeStatus();
        HT.checkAll();
        HT.checkBoxItem();+
        HT.changeStatusAll();
        HT.upload();
        HT.uploadMulti();
        HT.Dynamically();
        HT.submitProduct();
    });

  })(jQuery); // End of use strict
  