$(document).ready(function() {
    $(".smooth-scroll").on("click", function(event) {
        event.preventDefault();
        var targetId = $(this).attr("href");
        var targetElement = $(targetId);
        if (targetElement.length) {
            var currentScrollTop = $(window).scrollTop();
            var targetOffsetTop = targetElement.offset().top;
            var distance = Math.abs(targetOffsetTop - currentScrollTop);
            var duration = distance * 0.1;
            if(duration > 200) {
                duration = 200;
            }
            $('html, body').animate({
                scrollTop: targetOffsetTop
            }, duration);
        }
    });
});


$(".toggle-password").on("click", function() {
    var icon = $(this);
    var input = icon.siblings("input");
    var isPassword = input.attr("type") === "password";
    icon.toggleClass("fa-eye-slash fa-eye");
    input.attr("type", isPassword ? "text" : "password");
});



