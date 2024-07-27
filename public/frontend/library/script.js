function copy(element,copyId){
    navigator.clipboard.writeText($(copyId).text());
    $('.copyClipboard').each(function(){
        $(this).html('Sao chép mã');
    });
    element.innerHTML='Đã sao chép';
}