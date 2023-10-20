
$(function(){
    $('.product-number').on('click', function () {
        $('#modalBg').css('display', 'block');
        $('body').addClass('modal-open');
    })
    $('#close').on('click', function () {
        $('#modalBg').css('display', 'none');
        $('body').removeClass('modal-open');
    })
    const outer = document.getElementById('modalBg')
    const inner = document.getElementById('myModal')
    outer.addEventListener("click", function (e) {
        $('#modalBg').css('display', 'none');
        $('body').removeClass('modal-open');
        e.stopPropagation();
    }, false);
    inner.addEventListener('click', function (e) {
        e.stopPropagation();
    }, false);
})
