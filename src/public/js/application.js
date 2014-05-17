
var num = 100; //vị trí mà khi scroll chuột đến sẽ bắt đầu sự kiện
$(window).bind('scroll', function () {
    if ($(window).scrollTop() > num) {
        $('#sidebar_container').addClass('fixed');
    } else {
        $('#sidebar_container').removeClass('fixed');
    }
});
