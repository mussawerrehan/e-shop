$('.side-menu li').on('click', 'a', function(e){
    if ($(this).parent().children('ul').length){
        e.preventDefault();
        $(this).addClass('active');
        $(this).parent().children('ul').slideDown();
        setTimeout(function(){
            $.fn.matchHeight._update();
            $.fn.matchHeight._maintainScroll = true;
        }, 1000);
    }
});

$('.side-menu li').on('click', 'a.active', function(e){
    e.preventDefault();
    $(this).removeClass('active');
    $(this).parent().children('ul').slideUp();
    setTimeout(function(){
        $.fn.matchHeight._update();
        $.fn.matchHeight._maintainScroll = true;
    }, 1000);
});

$('.password, .confirm_password').on('keyup', function () {
    if ($('.password').val() == $('.confirm_password').val()) {
        $('#message').html('Matching').css('color', 'green');
    } else
        $('#message').html('Not Matching').css('color', 'red');
});