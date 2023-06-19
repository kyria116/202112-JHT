
    //@prepros-prepend modal.js

var index = $('.sel-bx li').length;
if (index == 1) {
    $('.remove-btn').addClass('hid');
}


$('.remove-btn').on('click', function () {
    var index = $('.sel-bx > li').length;
    $('.sel-bx > li').eq(index - 1).remove();
    if (index == 2) {
        $(this).addClass('hid');
    }
})

var sel = $('.sel-bx li').eq(0).html();
$('.add-btn').on('click', function () {
    var index = $('.sel-bx li').length;
    $('.sel-bx').append(
        `<li>${sel}</li>`
    );    
    
    $(".product_id" ).chosen();
    
    if (index > 0) {
        $('.remove-btn').removeClass('hid');
    }


    $('select').on('change', function () {
        if ($(this).val() == 'N') {
            $(this).removeClass('chsel');
        } else {
            $(this).addClass('chsel');
        }
    })
    
})



$('input[type=radio]').on('change', function () {
    console.log($(this).val());
    if ($(this).val() == 's-2') {
        $('.shopsel').addClass('show');
        $('.shopsel2').removeClass('show');
        $('.shopsel3').removeClass('show');
        $('.shopsel4').removeClass('show');
    } else if ($(this).val() == 's-1') {
        $('.shopsel').removeClass('show');
        $('.shopsel2').addClass('show');
        $('.shopsel3').removeClass('show');
        $('.shopsel4').removeClass('show');
    } else if ($(this).val() == 's-3') {
        $('.shopsel').removeClass('show');
        $('.shopsel2').removeClass('show');
        $('.shopsel3').addClass('show');
        $('.shopsel4').removeClass('show');
    } else if ($(this).val() == 's-4') {
        $('.shopsel').removeClass('show');
        $('.shopsel2').removeClass('show');
        $('.shopsel3').removeClass('show');
        $('.shopsel4').addClass('show');
    }

});