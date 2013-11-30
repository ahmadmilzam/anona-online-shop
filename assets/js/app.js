// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();

$(function(){
    $("html").niceScroll({
        cursorcolor:"#999",
        cursorwidth: '7',
        cursorborder : '1px solid #888'
    });

    $('#sortable-grid').mixitup({
        easing : 'snap'
    });

    $(document).ready(function(){
        var scrolled = false;
        $(window).scroll(function(){
            if(200<$(window).scrollTop() && !scrolled){
                $('.navbar').addClass('sticky-menu').css('top','-50px').animate({top:'0px'}, 500);
                scrolled = true;
            }
            if(200>$(window).scrollTop() && scrolled){
                $('.navbar').removeClass('sticky-menu');
                scrolled = false;
            }
        });
        $("#nav_custom li.level0").mouseover(function(){
            if($(window).width() >= 768){
                $(this).children('ul.level1').fadeIn();
            }
            return false;
        }).mouseleave(function(){
            if($(window).width() >= 768){
                $(this).children('ul.level1').fadeOut();
            }
            return false;
        });
        $("#nav_custom li span.plus").click(function(e){
            e.stopPropagation();
            if($(this).hasClass('expanded')){
                $(this).removeClass('expanded');
                $(this).parent().removeClass('expanded');
                $(this).parent().children('ul').slideUp();
            } else {
                $(this).parent().parent().children('li.expanded').children('ul').slideUp();
                $(this).parent().parent().children('li.expanded').children('span.expanded').removeClass('expanded');
                $(this).parent().parent().children('li.expanded').removeClass('expanded');
                $(this).addClass('expanded');
                $(this).parent().addClass('expanded');
                $(this).parent().children('ul').slideDown();
            }
        });
        /*
        var flg = false;
        $("#nav_custom a").mouseover(function(){
            var thumb_image = $(this).parent().attr("thumb_image");
            if(thumb_image != "no-image")
                $("#nav_custom li.thumbnail-image-area img").attr("src",thumb_image);
        });
        */
    });
//]]>

    function affix_nav() {
        var width = document.documentElement.clientWidth;
        if (width > 768) {

            if ($(window).scrollTop() > 250) {
                $('#fix-nav-top').slideDown('800');
            } else {
                $('#fix-nav-top').fadeOut('1000');
            }

        }
    }

    $(window).scroll(function() {
        affix_nav();
    });

    //Click event to scroll to top
    $('#scroll-top').click(function(){
        $('html, body').animate({scrollTop : 0},800);
    });


});
