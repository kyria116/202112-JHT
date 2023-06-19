$('.b-img').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: true,
    fade: true,
    asNavFor: '.s-img',
    customPaging: function customPaging(slider, i) {
        var current, count;
        i = i + 1;
        current = i < 10 ? "0" + i : i;
        count = slider.slideCount <= 9 ? "0" + slider.slideCount : slider.slideCount;
        return '<i>' + current + '</i>  /  ' + '<span>' + count + '</span>';
    },
});
$('.s-img').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.b-img',
    array: true,
    // dots: true,
    focusOnSelect: true,
});