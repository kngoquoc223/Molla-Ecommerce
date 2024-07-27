(function($) {
    "use strict"; // Start of use strict
    var HT={};
    HT.getCat=() =>{
        $(document).on('change','.getCat',function(){
            let _this=$(this)
            let option ={
                'data':{
                    'parent_id':_this.val(),
                },
                'target' : _this.attr('data-target')
            }
                HT.loadCategory(option);
        })        
    }
    HT.loadCategory=(option) =>{
        $.ajax({
            url:'/admin/ajax/category/getCategory',
            type:'GET',
            data:option,
            dataType:'json', //Kiểu dữ liệu mong đợi trả về (json, xml, html, v.v )
            success:function(res){
                    $('.'+option.target).html(res.html)
                    if(category_id != '' && option.target=='categories'){
                        $(".categories").val(category_id).trigger('change');
                    } 
            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);

            }
        })
           
    }
    HT.loadCat=() =>{
        if(parent_id != ''){
            $(".parent").val(parent_id).trigger('change');
        }
    }

    $(document).ready(function() {
        HT.getCat();
        HT.loadCat();
    });
  
  })(jQuery); // End of use strict
  