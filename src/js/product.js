$('.b-imgbx').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.s-imgbx',
    infinite: false,
});
$('.s-imgbx').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    asNavFor: '.b-imgbx',
    array: true,
    // dots: true,
    focusOnSelect: true,
    infinite: false,
    responsive: [
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
            }
        },
    ]
});


$('.add-purbx ul').slick({
    slidesToShow: 2,
    slidesToScroll: 1,
    asNavFor: '.b-imgbx',
    array: true,
    // dots: true,
    focusOnSelect: true,
    infinite: false,
    variableWidth: true,
    responsive: [
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                variableWidth: false,
            }
        },
    ]
});


// $('.it2-bx .product-list').slick({
//     slidesToShow: 4,
//     slidesToScroll: 1,
//     responsive: [
//         {
//             breakpoint: 991,
//             settings: {
//                 slidesToShow: 2,
//                 slidesToScroll: 1,
//                 variableWidth: false,
//                 array: true,
//                 infinite: true,
//             }
//         },
//     ]
// });

$(window).on('resize', function() {
    $('.it2-bx .product-list').slick('resize');
});
$('.it2-bx .product-list').slick({
    slidesToShow: 2,
    slidesToScroll: 1,
        mobileFirst: true,
        arrows: true,
        responsive: [
            {
                breakpoint: 991,
                settings: 'unslick'
            }
        ]
        
});


$('.html-bx').mCustomScrollbar();

// if($('.pric-bx:first-child').hasClass('org-pric')){
//     $('.dis-pric').addClass('pt40');
// }

if($('.productdetailPage .bot-bx>a').hasClass('activity-card')){
}else{
    $('.productdetailPage .bot-bx .html-bx').addClass('mt118')
}
