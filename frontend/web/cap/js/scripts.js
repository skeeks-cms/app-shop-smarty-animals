$(document).ready(function() {

    // Запрос коммерческого предложения
    $(".quotation, .errorMess a").fancybox({
        wrapCSS : "iesa-type",
        padding : 0,
        closeClick	: false,
        openEffect	: 'none',
        closeEffect	: 'none'
    });


    // sub tabs
    $('dl.sub-tabs dt').click(function(){
        $(this)
            .siblings().removeClass('selected').end()
            .next('dd').andSelf().addClass('selected');
    });


    // Раскраска строк таблиц
    if( $(".colored tbody").length) {
        $(".colored tbody tr:odd").addClass("odd");
    }


    // Плавный переход на верх страницы
    $(".to-top-block a").click(function(){
        $("html,body").animate({"scrollTop" : 0});
        return false;
    });

    // Фокус / блур на поле для поиска
    $('.search-text').focus(function(){
        if(this.value==this.defaultValue) {
            this.value='';
        }
    }).blur(function(){
            if(this.value=='') {
                this.value=this.defaultValue;
            }
        });
});