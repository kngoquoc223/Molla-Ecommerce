(function($) {
    "use strict"; // Start of use strict
    var HT={};
    HT.getLocation=() =>{
        $(document).on('change','.location',function(){
            let _this=$(this)
            let option ={
                'data':{
                    'location_id':_this.val(),
                },
                'target' : _this.attr('data-target')
            }
           HT.sendDataTogetLocation(option)
        })        
    }
    HT.sendDataTogetLocation=(option) =>{
        $.ajax({
            url:'/admin/ajax/location/getLocation',
            type:'GET',
            data:option,
            dataType:'json', //Kiểu dữ liệu mong đợi trả về (json, xml, html, v.v )
            success:function(res){
                //Xử lý dữ liệu yêu cầu trả về thành công 
                //VD: hiển thị dữ liệu trên trang
                $('.'+option.target).html(res.html)
                if(district_id != '' && option.target=='districts'){
                    $(".districts").val(district_id).trigger('change');
                }
                if(ward_id != '' && option.target=='wards'){
                    $(".wards").val(ward_id).trigger('change');
                } 

            },
            error:function(jqXHR, textStatus, errorThrown){
                //Xử lý dữ liệu khi gặp lỗi 
                console.log('Lỗi:' + textStatus + ' '+ errorThrown);

            }
        })
    }
    HT.loadCity=() =>{
        if(province_id != ''){
            $(".province").val(province_id).trigger('change');
        }
    }

    $(document).ready(function() {
        HT.getLocation();
        HT.loadCity();
    });
  
  })(jQuery); // End of use strict
  