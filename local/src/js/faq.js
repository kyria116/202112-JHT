$('.ul-bx li').on('click', function () {
    if (!$(this).hasClass('open')) {
        $(this).addClass('open');
        $(this).find('.editor_Content').stop().slideDown();
    } else {
        $(this).removeClass('open');
        $(this).find('.editor_Content').stop().slideUp();
    }
})

//sticky menu
if (document.getElementById('datilContent')) {
    $(window).on('scroll resize', function () {
        winW = $(window).width();
        winH = $(window).height();
        var scrollTop = $(this).scrollTop();
        var scrollbot = scrollTop + winH;
        var sidemenu = $('.item2 .it2-bx .l-bx ul');
        var contentH = $('#datilContent').outerHeight(true);
        var contentP = $('#datilContent').offset().top;
        var bottomOffset = contentP + contentH - 110;
        var boxH = sidemenu.outerHeight(true);
        var boxW = sidemenu.outerWidth(true);
        var obj = contentH - boxH;
        // if( scrollbot >= contentP){
        //     if(!$('.item1 .it1-bx .r .it1-bcard').hasClass('active')){
        //         $('.item1 .it1-bx .r .it1-bcard:first-child').addClass('active');
        //     }
        // }
        if (winW > 767) {
            if (scrollTop >= contentP - 100) {
                sidemenu.addClass('sticky').css({ transform: 'translateY(100px)', width: boxW });
                if (scrollTop >= bottomOffset - boxH - 190) {

                    sidemenu.addClass('change').css({ transform: 'translateY(0px)', width: '100%' });

                } else {
                    sidemenu.removeClass('change');
                }
            } else {
                sidemenu.removeClass('sticky').css({ transform: 'translateY(0px)', width: '100%' });
            }


        } else {
            sidemenu.removeClass('sticky change').removeAttr('style');
        }
    }).resize();
}