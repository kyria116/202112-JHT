$(".ind-banner ul").slick({dots:!0,infinite:!0,speed:500,fade:!0,cssEase:"linear",slidesToShow:1,slidesToScroll:1,autoplay:!0,autoplaySpeed:5e3,pauseOnHover:!1}),$(".item1 ul").slick({dots:!1,infinite:!0,speed:500,fade:!0,cssEase:"linear",slidesToShow:1,slidesToScroll:1}),$(".item3 ul").slick({dots:!1,infinite:!0,speed:500,fade:!0,cssEase:"linear",slidesToShow:1,slidesToScroll:1}),$(".item5 ul").slick({dots:!1,infinite:!0,speed:500,fade:!1,cssEase:"linear",slidesToShow:4,slidesToScroll:1,responsive:[{breakpoint:767,settings:{slidesToShow:2,slidesToScroll:1,variableWidth:!0}}]}),$('iframe[src*="youtube.com"]').each((function(){var e=$(this).attr("src");$(this).attr("src",e+"?controls=1&rel=0&enablejsapi=1")}));var player,tag=document.createElement("script"),firstScriptTag=document.getElementsByTagName("script")[0];function onYouTubeIframeAPIReady(){for(var e=$(".iframe-bx iframe"),s=0;s<e.length;s++)player=new YT.Player(e[s],{events:{onStateChange:onPlayerStateChange}})}function onPlayerReady(e){}function fadeVideo(e){console.log(e.target.f),e.target.f.parentNode.parentNode.className+=" start"}function onPlayerStateChange(e){fadeVideo(e)}firstScriptTag.parentNode.insertBefore(tag,firstScriptTag);