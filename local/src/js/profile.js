$('.clos-btn').on('click', function () {
    $('.pop-act').removeClass('show-pop').fadeOut();
    $('body,html,.sub_menu').removeAttr("style");
})

function popupOpen(i) {
    $('.pop-act').addClass('show-pop').fadeIn();
    $('.pop-act .pop-bx').removeClass('active');
    $('.pop-act .pop-bx').eq(i - 1).addClass('active');
}