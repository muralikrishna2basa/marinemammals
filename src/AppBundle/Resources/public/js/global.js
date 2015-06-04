$(document).ready(function($) {
    // scrollup button
    $(window).scroll(function(){
        if ($(this).scrollTop() > 100)
        {
            $('.scrollup').fadeIn();
        } else
        {
            $('.scrollup').fadeOut();
        }
    });
    $('.scrollup').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });

    $(".pop").popover();

    $(".has-tooltip").tooltip();

    $('a.new-window').attr('target','_blank');

});
