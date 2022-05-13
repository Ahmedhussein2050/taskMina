// Navbar
document.addEventListener("DOMContentLoaded", function () {
    // Prevent closing from click inside dropdown
    document.querySelectorAll('.dropdown-menu').forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    })
    document.querySelectorAll('.dropdown-menu a').forEach(function (element) {
        let nextEl = element.nextElementSibling;
        if (nextEl && nextEl.classList.contains('submenu')) {
            element.classList.add('arrow')
        }

    });
    // make it as accordion for smaller screens
    if (window.innerWidth < 992) {

        // close all inner dropdowns when parent is closed
        document.querySelectorAll('.navbar .dropdown').forEach(function (everydropdown) {
            everydropdown.addEventListener('hidden.bs.dropdown', function () {
                // after dropdown is hidden, then find all submenus
                this.querySelectorAll('.submenu').forEach(function (everysubmenu) {
                    // hide every submenu as well
                    everysubmenu.style.display = 'none';
                });
            })
        });

        document.querySelectorAll('.dropdown-menu a').forEach(function (element) {
            element.addEventListener('click', function (e) {

                let nextEl = this.nextElementSibling;
                if (nextEl && nextEl.classList.contains('submenu')) {
                    // prevent opening link if link needs to open dropdown
                    e.preventDefault();
                    console.log(nextEl);
                    if (nextEl.style.display == 'block') {
                        nextEl.style.display = 'none';
                    } else {
                        nextEl.style.display = 'block';
                    }

                }
            });
        })
    }
    // end if innerWidth

});
(function ($) {

    "use strict";
    // review panel
    $("#reviewPanelTrigger").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $("#reviewPanel").toggleClass("show");
    });

    $(document).click(function(event){
        if($('#reviewPanel').hasClass('show') && $(event.target).closest("#reviewPanel").length == 0) {
            $('#reviewPanel').toggleClass('show');
        }
    });
    // Payment options
    $('.payment-options label').on('click', function () {
        $('.payment-options label').removeClass('active');
        $(this).addClass('active');
    })

    // tooltips
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip()
    })
    // Notifications
    $('#notifications').click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(".notification-wrapper").toggleClass("show");
        $(".shopping-cart").removeClass("show");
    });

    $(document).click(function () {
        var $item = $(".shopping-cart");
        var $item2 = $(".notification-wrapper");
        if ($item.hasClass("show") || $item2.hasClass("show")) {
            $item.removeClass("show");
            $item2.removeClass("show");
        }
    });

    $('.notification-wrapper').click(function (e) {
        e.stopPropagation();
    });
    $('.shopping-cart').click(function (e) {
        e.stopPropagation();
    });
 
    $(document).click(function (event) {
        if ($('.shopping-cart').hasClass('show') && $(event.target).closest(".shopping-cart").length == 0) {
            $('.shopping-cart').toggleClass('show');
        }
    });

// contact form
    $('#unrealForm').on('click', function () {

        $('#realForm').toggleClass('show');

    });
    $('#closeForm').on('click', function () {

        $('#realForm').toggleClass('show');

    });


// ===== Scroll to Top ====
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });
    $('#return-to-top').click(function () {      // When arrow is clicked
        $('body,html').animate({
            scrollTop: 0                       // Scroll to top of body
        }, 500);
    });


    // Sliders
    $('.sponsors-slider').slick({
        slidesToShow: 6,
        slidesToScroll: 6,
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-left"></i></button>',
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-right"></i></button>',
        dots: false,
        rtl: false,
        infinite: false,
        arrows: false,
        centerMode: false,
        focusOnSelect: true,

        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 6,
                    slidesToScroll: 5,

                }
            },
            {
                breakpoint: 789,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2,

                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,

                }
            }

        ]


    });

    $('.products-slider').slick({
        slidesToShow: 5,
        slidesToScroll: 5,
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-left"></i></button>',
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-right"></i></button>',
        dots: false,
        rtl: false,
        arrows: true,
        centerMode: false,
        focusOnSelect: true,
        autoplay:true,

        responsive: [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,

                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,

                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,

                }
            }

        ]


    });

    $('.main-slider-trigger').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-left"></i></button>',
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-right"></i></button>',
        dots: true,
        rtl: false,
        infinite: false,
        arrows: false,
        centerMode: false,
        focusOnSelect: true,
        autoplay:true,


    });

    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-long-arrow-alt-left"></i></button>',
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-long-arrow-alt-right"></i></button>',
        focusOnSelect: true,
        responsive: [

            {
                breakpoint: 769,
                settings: {
                    arrows:false
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows:false
                }
            }

        ]
    });
    //slimScroll

    $('.shopping-cart-items , .slimscroll').slimScroll({
        color: '#136BCF',
        size: '5px',
        height: '400px',
    });


    // Loader
    $(window).on('load', function () {
        $('#loader').fadeOut('slow');
    });


    // Quantity input
    function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 0) {
            parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }

    $('.input-group').on('click', '.button-plus', function (e) {
        incrementValue(e);
    });

    $('.input-group').on('click', '.button-minus', function (e) {
        decrementValue(e);
    });
})(jQuery);
