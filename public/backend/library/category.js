(function($) {
    "use strict"; // Start of use strict
    var HT={};
    var _token= $('meta[name="csrf-token"]').attr('content');
    HT.switchery=() => {
        $('.js-switch').each(function(){
         //   let _this=$(this)
            var switchery = new Switchery(this, { color: '#1AB394' });
        })
    }
    // Toggle the side navigation
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
    // Smooth scrolling using jQuery easing
    $(document).ready(function() {
        HT.switchery();
        HT.checkAll();
        HT.checkBoxItem();+
        $('.status-cat').change(function(e){
            e.preventDefault();
            let _this=$(this)
            let option = {
                'value' : _this.val(), 
                'modelId': _this.attr('data-modelId'), 
                'model' : _this.attr('data-model'),
                'field' : _this.attr('data-field'),
                '_token': _token
            }
            $.ajax({
                url:'/admin/ajax/dashboard/changeStatus',
                type:'POST',
                data:option,
                dataType:'json', //Kiểu dữ liệu mong đợi trả về (json, xml, html, v.v )
                success:function(res){
                    let inputValue= ((option.value==1)?2:1)
                    if(res.flag==true){
                        let cssActive1='background-color: rgb(26, 179, 148); border-color: rgb(26, 179, 148); box-shadow: rgb(26, 179, 148) 0px 0px 0px 16px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;';
                        let cssActive2='left: 20px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;';
                        let cssUnActive1='box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset; border-color: rgb(223, 223, 223); background-color: rgb(255, 255, 255); transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;';
                        let cssUnActive2='left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;';
                        if(inputValue==2){
                            $('.js-switch-child-'+option.modelId).each(function(){
                                $(this).find('span.switchery').attr('style',cssActive1).find('small').attr('style',cssActive2);
                            });  
                        }else if(inputValue==1){
                            $('.js-switch-child-'+option.modelId).each(function(){
                                $(this).find('span.switchery').attr('style',cssUnActive1).find('small').attr('style',cssUnActive2);
                            });
                        }
                        _this.val(inputValue)
                        window.location.reload()
                    }
                },
                error:function(jqXHR, textStatus, errorThrown){
                    //Xử lý dữ liệu khi gặp lỗi 
                    console.log('Lỗi:' + textStatus + ' '+ errorThrown);
    
                }
            })
            
        });
        $('.status-child-cat').change(function(e){
            e.preventDefault();
            let _this=$(this)
            let option = {
                'value' : _this.val(), 
                'modelId': _this.attr('data-modelId'), 
                'model' : _this.attr('data-model'),
                'field' : _this.attr('data-field'),
                'parent_id' : _this.attr('data-parentId'),
                '_token': _token,
            }
            $.ajax({
                url:'/admin/ajax/dashboard/changeStatus',
                type:'POST',
                data:option,
                dataType:'json', //Kiểu dữ liệu mong đợi trả về (json, xml, html, v.v )
                success:function(res){
                    let inputValue= ((option.value==1)?2:1)
                    if(res.flag==true){
                        if(inputValue==2){
                            let cssActive1='background-color: rgb(26, 179, 148); border-color: rgb(26, 179, 148); box-shadow: rgb(26, 179, 148) 0px 0px 0px 16px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;';
                            let cssActive2='left: 20px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;';
                            if( $('.js-switch-parent-'+option.parent_id).find('span.switchery').attr('style')!=cssActive1){
                            $('.js-switch-parent-'+option.parent_id).find('span.switchery').attr('style',cssActive1).find('small').attr('style',cssActive2);
                            window.location.reload()
                            }
                        }
                        _this.val(inputValue);
                    }
                },
                error:function(jqXHR, textStatus, errorThrown){
                    //Xử lý dữ liệu khi gặp lỗi 
                    console.log('Lỗi:' + textStatus + ' '+ errorThrown);
    
                }
            })
            
        });
    });

  })(jQuery); // End of use strict
  