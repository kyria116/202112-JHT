$('.three-list').slick({
    dots: false,
    arrow: false,
    infinite: false,
    speed: 500,
    fade: false,
    cssEase: 'linear',
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 991,
            settings: {
                variableWidth: true,
                slidesToShow: 1,
            }
        },
    ]
});