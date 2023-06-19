$('.ind-banner ul').slick({
    dots: true,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear',
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    pauseOnHover: false,
});

$('.item1 ul').slick({
    dots: false,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear',
    slidesToShow: 1,
    slidesToScroll: 1,
});

$('.item3 ul').slick({
    dots: false,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear',
    slidesToShow: 1,
    slidesToScroll: 1,
});

$('.item5 ul').slick({
    dots: false,
    infinite: true,
    speed: 500,
    fade: false,
    cssEase: 'linear',
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 767,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                variableWidth: true,
            }
        },
    ]
});


$('iframe[src*="youtube.com"]').each(function () {
    var url = $(this).attr("src")
    $(this).attr("src", url + "?controls=1&rel=0&enablejsapi=1")
});
var tag = document.createElement('script');
var firstScriptTag = document.getElementsByTagName('script')[0];

firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;
function onYouTubeIframeAPIReady() {
    var elems1 = $('.iframe-bx iframe');
    for (var i = 0; i < elems1.length; i++) {

        player = new YT.Player(elems1[i], {
            events: {
                //'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }
}
function onPlayerReady(event) {

}

function fadeVideo(event) {
    console.log(event.target.f);
    event.target.f.parentNode.parentNode.className += " start";
}

function onPlayerStateChange(event) {
    fadeVideo(event);
}
