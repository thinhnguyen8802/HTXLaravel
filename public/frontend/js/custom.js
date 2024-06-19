(function($) {
    "use strict";
    let menu = document.getElementById('menuClick');
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
        menu.style.display = 'block';
        menu.style.top = event.y + 'px';
        menu.style.left = event.x + 'px';
    });
    document.addEventListener('click', function() {
        menu.style.display = 'none';
    });

    $('.popup-youtube, .popup-vimeo').magnificPopup({
        // disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });



    var review = $('.textimonial_iner');
    if (review.length) {
        review.owlCarousel({
            items: 1,
            loop: true,
            dots: true,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: 5000,
            nav: false,
            responsive: {
                0: {
                    margin: 15,

                },
                600: {
                    margin: 10,
                },
                1000: {
                    margin: 10,
                }
            }
        });
    }
    var best_product_slider = $('.best_product_slider');
    if (best_product_slider.length) {
        best_product_slider.owlCarousel({
            items: 4,
            loop: false,
            dots: false,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: 5000,
            nav: true,
            navText: ["previous", "next"],
            responsive: {
                0: {
                    margin: 15,
                    items: 1,
                    nav: false
                },
                576: {
                    margin: 15,
                    items: 2,
                    nav: false
                },
                768: {
                    margin: 30,
                    items: 3,
                    nav: true
                },
                991: {
                    margin: 30,
                    items: 4,
                    nav: true
                }
            }
        });
    }

    var cate_slide = $('.cate_slide');
    if (cate_slide.length) {
        cate_slide.owlCarousel({
            items: 4,
            loop: true,
            dots: false,
            autoplay: false,
            nav: true,
            responsive: {
                0: {
                    margin: 15,
                    items: 3,
                    nav: false
                },
                576: {
                    margin: 15,
                    items: 4,
                    nav: false
                },
                768: {
                    margin: 30,
                    items: 5,
                    nav: true
                },
                991: {
                    margin: 30,
                    items: 8,
                    nav: true
                }
            }
        });
    }

    //product list slider
    var product_list_slider = $('.product_list_slider');
    if (product_list_slider.length) {
        product_list_slider.owlCarousel({
            items: 4,
            loop: false,
            dots: false,
            animateOut: 'slideOutDown',
            animateIn: 'flipInX',
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: 5000,
            nav: true,
            navText: ["previous", "next"],
            smartSpeed: 1000,
            responsive: {
                0: {
                    margin: 15,
                    nav: false,
                    items: 1
                },
                600: {
                    margin: 15,
                    items: 2,
                    nav: true
                },
               960: {
                    margin: 30,
                    nav: true,
                    items: 4
                }
            }
        });
    }

    // single banner slider
    var banner_slider = $('.banner_slider');
    if (banner_slider.length) {
        banner_slider.owlCarousel({
            items: 1,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayTimeout: 5000,
            // nav: true,
            // navText: ["previous", " next"],
            smartSpeed: 1000,
        });
    }

    if ($('.img-gal').length > 0) {
        $('.img-gal').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    }


    //single banner slider
    $('.banner_slider').on('initialized.owl.carousel changed.owl.carousel', function(e) {
        function pad2(number) {
            return (number < 10 ? '0' : '') + number
        }
        var carousel = e.relatedTarget;
        $('.slider-counter').text(pad2(carousel.current()));

    }).owlCarousel({
        items: 1,
        loop: true,
        dots: false,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 5000,
        nav: true,
        navText: ["next", "previous"],
        smartSpeed: 1000,
        responsive: {
            0: {
                nav: false
            },
            600: {
                nav: false
            },
            768: {
                nav: true
            }
        }
    });



    // niceSelect js code
    $(document).ready(function() {
        $('select').niceSelect();

        // //add-to-cart
        // $('.add-to-cart').click(function() {
        //     var id = $(this).data('id_product');
        //     var cart_product_id = $('.cart_product_id_' + id).val();
        //     var cart_product_name = $('.cart_product_name_' + id).val();
        //     var cart_product_thumbnail = $('.cart_product_thumbnail_' + id).val();
        //     var cart_product_sale_price = $('.cart_product_sale_price_' + id).val();
        //     var cart_product_qty = $('.cart_product_qty_' + id).val();

        //     $.ajax({
        //         url: '{{url(' / add - cart - ajax ')}}'
        //         method: 'POST',

        //     });
        // });
    });

    // menu fixed js code
    // $(window).scroll(function() {
    //     var window_top = $(window).scrollTop() + 1;
    //     if (window_top > 50) {
    //         $('.main_menu').addClass('menu_fixed animated fadeInDown');
    //         $('.banner_header').addClass('d-none');
    //     } else {
    //         $('.main_menu').removeClass('menu_fixed animated fadeInDown');
    //         $('.banner_header').removeClass('d-none');

    //     }
    // });


    $('.counter').counterUp({
        time: 2000
    });

    $('.slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        speed: 300,
        infinite: true,
        asNavFor: '.slider-nav-thumbnails',
        autoplay: true,
        pauseOnFocus: true,
        dots: true,
    });

    $('.slider-nav-thumbnails').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider',
        focusOnSelect: true,
        infinite: true,
        prevArrow: false,
        nextArrow: false,
        centerMode: true,
        responsive: [{
            breakpoint: 480,
            settings: {
                centerMode: false,
            }
        }]
    });


    // Search Toggle
    $("#search_input_box").hide();
    $("#search_1").on("click", function() {
        $("#search_input_box").slideToggle();
        $("#search_input").focus();
    });
    $("#close_search").on("click", function() {
        $('#search_input_box').slideUp(500);
    });

    //------- Mailchimp js --------//
    function mailChimp() {
        $('#mc_embed_signup').find('form').ajaxChimp();
    }
    mailChimp();

    //------- makeTimer js (thời gian)--------//
    function makeTimer() {

        //		var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");
        var endTime = new Date("11 Jan 2023 00:00:00 GMT+07:00");
        endTime = (Date.parse(endTime) / 1000);

        var now = new Date();
        now = (Date.parse(now) / 1000);

        var timeLeft = endTime - now;

        var days = Math.floor(timeLeft / 86400);
        var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
        var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
        var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

        if (hours < "10") {
            hours = "0" + hours;
        }
        if (minutes < "10") {
            minutes = "0" + minutes;
        }
        if (seconds < "10") {
            seconds = "0" + seconds;
        }

        $("#days").html("<span>Ngày</span>" + days);
        $("#hours").html("<span>Giờ</span>" + hours);
        $("#minutes").html("<span>Phút</span>" + minutes);
        $("#seconds").html("<span>Giây</span>" + seconds);

    }
    // click counter js
    // (function() {

    //     window.inputNumber = function(el) {

    //         var min = el.attr('min') || false;
    //         var max = el.attr('max') || false;

    //         var els = {};

    //         els.dec = el.prev();
    //         els.inc = el.next();

    //         el.each(function() {
    //             init($(this));
    //         });

    //         function init(el) {
    //             els.dec.on('click', decrement);
    //             els.inc.on('click', increment);
    //             function decrement() {
    //                 var value = el[0].value;
    //                 value--;
    //                 if (!min || value >= min) {
    //                     el[0].value = value;
    //                 }
    //             }

    //             function increment() {
    //                 var value = el[0].value;
    //                 value++;
    //                 if (!max || value <= max) {
    //                     el[0].value = value++;
    //                 }
    //             }
    //         }
    //     }
    // })();
    (function() {
        window.inputNumber = function(el) {
          var min = el.attr('min') || false;
          var max = el.attr('max') || false;

          el.each(function() {
            init($(this));
          });

          function init(el) {
            el.prev().on('click', decrement);
            el.next().on('click', increment);

            function decrement() {
              var value = el[0].value;
              value--;
              (value < 1) ? value = 1: '';
              if (!min || value >= min) {
                el[0].value = value;
              }
            }

            function increment() {
              var value = el[0].value;
              value++;
              if (!max || value <= max) {
                el[0].value = value++;
              }
            }
          }
        };
      })();
    inputNumber($('.input-number'));



    setInterval(function() {
        makeTimer();
    }, 1000);

    // click counter js


    // var a = 0;
    // $('.increase').on('click', function(){



    //   console.log(  $(this).innerHTML='Product Count: '+ a++ );
    // });
    var product_overview = $('#lightSlider li');
    $('#lightSlider').lightSlider({
        gallery: true,
        verticalHeight: 450,
        item: 1,
        loop:true,
        slideMargin: 0,
        thumbItem: 5,
        speed: 600,
        autoplay: true,
        responsive: [{
            breakpoint: 991,
            settings: {
                item: 1,

            }
        },
        {
            breakpoint: 576,
            settings: {
                item: 1,
                slideMove: 1,
                verticalHeight: 350,
                thumbItem: 3,

            }
        }
    ]
    });

    var product_overview = $('#vertical');
    if (product_overview.length) {
        product_overview.lightSlider({
            gallery: true,
            item: 1,
            vertical: true,
            verticalHeight: 450,
            thumbItem: 5,
            loop: true,
            slideMargin: 0,
            speed: 600,
            autoplay: true,
            keyPress: false,

            responsive: [{
                    breakpoint: 991,
                    settings: {
                        item: 1,

                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        item: 1,
                        slideMove: 1,
                        verticalHeight: 350,
                        thumbItem: 3,

                    }
                }
            ]
        });
    }
//reset input file
$('input[type="file"][name="avatar"]').val('');
//image preview
$('input[type="file"][name="avatar"]').on('change', function() {
    var img_path = $(this)[0].value;
    $('.img-holder').html("");
    var extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();
    if (extension == 'jpeg' || extension == 'jpg' || extension == 'png') {
        if (typeof(FileReader) != 'undefined') {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('<img/>', { 'src': e.target.result}).appendTo($('.img-holder'));
            }
            $('.img-holder').show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            $('.img-holder').html('không hỗ trợ định dạng ảnh này! xin vui lòng đổi ảnh khác')
        }
    } else {
        $($('.img-holder')).empty();
    }
});
document.querySelector("html").classList.add('js');

var fileInput  = document.querySelector( ".input-file" ),
    button     = document.querySelector( ".input-file-trigger" ),
    the_return = document.querySelector(".file-return");

if(button != undefined){
    button.addEventListener( "keydown", function( event ) {
        if ( event.keyCode == 13 || event.keyCode == 32 ) {
            fileInput.focus();
        }
    });
    button.addEventListener( "click", function( event ) {
        fileInput.focus();
        return false;
     });
}
if(fileInput != undefined){
    fileInput.addEventListener( "change", function( event ) {
        the_return.innerHTML = this.value;
    });
}





}(jQuery));
