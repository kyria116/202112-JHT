// @prepros-prepend jquery_min.js
$(document).ready(function () {

    
    $("li").each(function(){
        if($(this).find('.pric-bx div').hasClass('org-pric')){
            $(this).find('.specialprice').addClass('show');
        }
    });

    //----------------------header scroll------------------//
    var windowHeight = $(window).height();
    var miniHeight = windowHeight - $('footer').outerHeight();
    $('main').css({
        "min-height": miniHeight + "px"
    });

    $(window).on('resize', function (event) {
        var windowHeight = $(window).height();
        var miniHeight = windowHeight - $('footer').outerHeight() - $('.header_box').outerHeight();

        $('main').css({
            "min-height": miniHeight + "px"
        });

        if ($(this).width() > 980) {
            $('body,html,footer').removeAttr("style");
            $('.header_box').removeClass('open').removeAttr('style');
            $('.nav_box').removeAttr("style");
            $('.hamburger-menu').removeClass('animate').removeAttr("style");
        }


    }).resize();

    // $(window).on('resize', function (event) {
    //     if ($(this).width() < 992) {
    //         $('.member-bx .member-btn2').on('click', function () {
    //             if ($(this).hasClass('active')) {
    //                 $('.mo-memberbx').fadeOut();
    //                 $(this).removeClass('active');
    //             } else {
    //                 $(this).addClass('active');
    //                 $('.mo-memberbx').fadeIn();
    //             }
    //         })
    //     }
    // });

    $('.menu-wrapper').on('click', function () {
        if (!$('.hamburger-menu').hasClass('animate')) {
            $('.hamburger-menu').addClass('animate');
            $('.nav_box').stop().addClass('open');
            $('body,html').css({ 'overflow': 'hidden' });
            $('footer').css({ 'z-index': '-1' });
        } else {
            $('.hamburger-menu').removeClass('animate');
            $('footer').removeAttr("style");
            $('.nav_box').stop().removeClass('open');
            $('body,html').removeAttr("style");
            $('.botdes-bx').removeClass('open');
            $('.nav_box').removeClass('in-st');
        }
    });

    $('select').on('change', function () {
        if ($(this).val() == 'N') {
            $(this).removeClass('chsel');
        } else {
            $(this).addClass('chsel');
        }
    })



    //----------------------add animation------------------//
    // picture
    $(window).load(function () {
        $(window).scroll(function () {
            var bottom_of_window = $(window).scrollTop() + $(window).height();

            $('.imgmaskwrap').each(function (i) {
                var bottom_of_object = $(this).offset().top
                if (bottom_of_window > bottom_of_object) {
                    $(this).addClass('transi-mask');
                }
            });

        });
    })
    //word
    // $(window).scroll(function () {
    //     var bottom_of_window = $(window).scrollTop() + $(window).height();

    //     $('.f140,.f90,.f30').each(function (i) {
    //         var bottom_of_object = $(this).offset().top;
    //         if (bottom_of_window > bottom_of_object) {
    //             $(this).css('opacity', '0').addClass('fadeIn');
    //         }
    //     });

    // });


    $(window).on('resize', function (event) {
        if ($(this).width() < 992) {
            $('.member-bx .member-btn2').off('click');
            $('.member-bx .member-btn').off('click');
            $('.ins-bx .close1').off('click');
            $('.ins-bx .close2').off('click');

            $('.member-bx .member-btn2').on('click', function () {
                if ($(this).hasClass('active')) {
                    $('.mo-memberbx').fadeOut();
                    $(this).removeClass('active');
                    $('.member-bx').removeClass('active');
                } else {
                    $(this).addClass('active');
                    $('.mo-memberbx').fadeIn();
                    $('.member-bx').addClass('active');
                }
            })

            $('.ins-bx .close1').on('click', function () {
                if ($('.member-bx .member-btn2').hasClass('active')) {
                    $('.mo-memberbx').fadeOut();
                    $('.member-bx .member-btn2').removeClass('active');
                    $('.member-bx').removeClass('active');
                } else {
                    $('.member-bx .member-btn2').addClass('active');
                    $('.mo-memberbx').fadeIn();
                }
            })

            $('.member-bx .member-btn').on('click', function () {
                if ($(this).hasClass('active')) {
                    $('.mo-memberbx2').fadeOut();
                    $(this).removeClass('active');
                    $('.member-bx').removeClass('active');
                } else {
                    $(this).addClass('active');
                    $('.mo-memberbx2').fadeIn();
                    $('.member-bx').addClass('active');
                }
            })
            $('.ins-bx .close2').on('click', function () {
                if ($('.member-bx .member-btn').hasClass('active')) {
                    $('.mo-memberbx2').fadeOut();
                    $('.member-bx .member-btn').removeClass('active');
                    $('.member-bx').removeClass('active');
                } else {
                    $('.member-bx .member-btn').addClass('active');
                    $('.mo-memberbx2').fadeIn();
                }
            })


            $('.nav_box .hamenu>a').on('click', function () {
                // if($('.nav_box').hadClass('in-st')){
                //     $('.nav_box')
                // }
                $('.nav_box').addClass('in-st');
                $(this).next().addClass('open');
            })

            $('.hamenu .botdes-bx .b-ti').on('click', function () {
                $('.nav_box').removeClass('in-st');
                $('.botdes-bx').removeClass('open');
            })
        } else {
            $('.member-bx .member-btn2').off('click');
            $('.member-bx .member-btn').off('click');
            $('.ins-bx .close1').off('click');
            $('.ins-bx .close2').off('click');
        }
    }).resize();



    //----------------------top_btn------------------//
    $(window).on('scroll', function () {
        var scrollTop = $(this).scrollTop();
        var top = $('.top_btn');
        var screenHeight = $(window).height();
        var scrollTop2 = $(this).scrollTop() + (screenHeight / 2);

        if (scrollTop > 170) {
            top.addClass('show-topbtn');
        } else {
            top.removeClass('show-topbtn');
        }

        var top_number;
        if ($(this).width() >= 768) {
            top_number = 410;
        } else {
            top_number = 300;
        }
        if (scrollTop2 >= $('footer').offset().top - top_number) {
            top.addClass('fix');
        } else if (scrollTop2 <= $('footer').offset().top + 400) {
            top.removeClass('fix');
        }
    }).scroll();
    $(".top_btn").on('click', function () {

        $("html,body").animate({ scrollTop: 0 }, 1000);
        return false;
    });
    //----------------------TopMenu------------------//
    // if ($('#top-menu-ul').length > 0) {
    //     var menu_ul = $('#top-menu-ul ul').width();
    //     var menu_box = $('#top-menu-ul .item_menu_Box').width();

    //     $('#top-menu-ul').removeClass('open_flexslider');
    //     $('#top-menu-ul .slides').removeAttr('style');
    //     $('#top-menu-ul .item_menu_Box').removeAttr('style');
    //     if (menu_ul > menu_box) {
    //         $('#top-menu-ul').addClass('open_flexslider');
    //     }
    //     slider_ul_list();
    // }
    var TopMenu = function () {
        $(window).on('resize', function () {
            //top menu
            if ($('#top-menu-ul').length > 0) {
                var menu_ul = $('#top-menu-ul ul').width();
                var menu_box = $('#top-menu-ul .item_menu_Box').width()

                $('#top-menu-ul').removeClass('open_flexslider');
                $('#top-menu-ul .slides').removeAttr('style');
                $('#top-menu-ul .item_menu_Box').removeAttr('style');
                if (menu_ul > menu_box) {
                    $('#top-menu-ul').addClass('open_flexslider');
                }
                slider_ul_list();
            }
        }).resize();
    }
    function slider_ul_list() {
        var newscroll = 0;
        var move = new Array();
        var total_width = 0;
        var i = 0;
        var sum = 0;
        var sumArray = new Array();
        var total = $("#top-menu-ul li");
        var active = $("#top-menu-ul .slides .active").index();
        total_width = $("#top-menu-ul ul").width();//1043.4
        total.each(function () {
            move[i] = $(this).width();
            sum += move[i];//move[i]紀錄每個按鈕的【寬度】(累加)
            sumArray[i] = sum;
            i++;
        });

        sum = Math.round((total_width - sum) / i);
        for (var j = 0; j < i; j++) move[j] += sum; //move[j]紀錄每個按鈕的【位置】
        sum = 0;

        for (var ac = 0; ac < active; ac++) sum += move[ac];//move[ac]當前按鈕的【位置】
        if ($('#top-menu-ul').hasClass('open_flexslider')) {
            var item_w = $("#top-menu-ul ul").width();//ul 所有寬度
            var list_width = $('#top-menu-ul .item_menu_Box').width(); //按鈕外層       
            sum = sum > (total_width - list_width) ? (total_width - list_width) : sum;  //判斷是否已經移動到最右邊   
            if (active > 0) { $('#top-menu-ul .item_menu_Box').scrollLeft(sum); }
            else { newscroll = 0; }
            //click用
            var j = 0;
            var move_total = 0;
            for (var ac = 0; ac <= active; ac++) {
                move_total = ac > 0 ? (move_total + move[ac - 1]) : 0;
                if (move_total > (total_width - list_width)) move_total = (total_width - list_width);
                else j = ac;
            }
            (ac - j) > 1 ? j++ : "";
            move_total = Math.floor(move_total);
            $(".item_menu_Box").on('scroll', function () {
                newscroll = $('#top-menu-ul .item_menu_Box').scrollLeft();
            });
            $("#top-menu-ul .flex-next").on('click', function () {
                console.log('1')
                if (newscroll == move_total) {
                    if (move_total < (total_width - list_width) && j < i) {
                        j++;
                        move_total = 0;
                        for (var k = 0; k < j; k++) move_total += move[k];
                        move_total = move_total > (total_width - list_width) ? (total_width - list_width) : move_total;
                        move_total = Math.floor(move_total);
                        $('#top-menu-ul .item_menu_Box').stop().animate({ scrollLeft: move_total }, 300, '');
                    }
                } else {
                    var m_switch = 0;
                    for (var k = 0; k < i; k++) {
                        if (m_switch == 0 && newscroll < sumArray[k]) {
                            m_switch = 1;
                            move_total = Math.floor(sumArray[k]);
                            $('#top-menu-ul .item_menu_Box').stop().animate({ scrollLeft: move_total }, 300, '');
                            j = k + 1;
                        }
                    }
                }
                return false;
            });
            $("#top-menu-ul .flex-prev").on('click', function () {
                console.log('2')
                if (newscroll == move_total) {
                    if (move_total > 0 && j > 0) {
                        j--;
                        move_total = 0;
                        for (var k = 0; k < j; k++) move_total += move[k];
                        move_total = move_total > (total_width - list_width) ? (total_width - list_width) : move_total;
                        move_total = Math.floor(move_total);
                        $('#top-menu-ul .item_menu_Box').stop().animate({ scrollLeft: move_total }, 300, '');
                    }
                } else {
                    var m_switch = 0;
                    for (var k = j; k >= 0; k--) {
                        if (m_switch == 0 && newscroll > sumArray[k]) {
                            m_switch = 1;
                            move_total = Math.floor(sumArray[k]);
                            $('#top-menu-ul .item_menu_Box').stop().animate({ scrollLeft: move_total }, 300, '');
                            j = k + 1;
                        }
                    }
                }
                return false;
            });
        }
    }
    TopMenu()
    slider_ul_list()
})

