(function($) {

    $(window).load(function(e){


    $('.banner-slider:not(.slick-initialized').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        arrows: true,
    });



    $('.client-slider:not(.slick-initialized').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        speed: 500,
        autoplay: true,
        arrows: false,
    });

    $('#testimonial-slider.three-testimonial:not(.slick-initialized').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        speed: 500,
        autoplay: true,
        arrows: false,
    });

    $('#testimonial-slider.two-testimonial:not(.slick-initialized').slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        speed: 500,
        autoplay: true,
        arrows: false,
    });

    $('#testimonial-slider.one-testimonial:not(.slick-initialized').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        autoplay: true,
        arrows: false,
    });

    })

})(jQuery);
