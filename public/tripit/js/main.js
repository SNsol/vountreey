jQuery(document).ready(function() {
    // Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('.navbar').outerHeight();

    $(window).scroll(function(event) {
        didScroll = true;
    });

    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta)
            return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight) {
            // Scroll Down
            $('.navbar').removeClass('nav-down').addClass('nav-up');
        } else {
            // Scroll Up
            if (st + $(window).height() < $(document).height()) {
                $('.navbar').removeClass('nav-up').addClass('nav-down');
            }
        }

        lastScrollTop = st;
    }

    jQuery('footer .col-md-3 h6').click(function() {
        jQuery(this).parent().addClass('active').siblings().removeClass('active');
    });
    jQuery('.panel.panel-default .panel-heading-sec').click(function() {
        jQuery(this).parent().parent().addClass('active').siblings().removeClass('active');
    });
    /* navbar toggle and remove empty p */
    jQuery(".navbar-nav > li.dropdown > a").after("<div class='dropdown-toggle plus' data-toggle='dropdown'></div>");
    // jQuery("p:empty,p:contains('&nbsp;')").css("display", "none"),
    //     jQuery("p").each(function() {
    //         var a = jQuery(this);
    //     0 == a.html().replace(/\s|&nbsp;/g, "").length && a.remove()
    //     });


    /* navbar */
    /* jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > 0) {
            jQuery(".navbar").addClass("navbar-fixed");

        } else {
            jQuery(".navbar").removeClass("navbar-fixed");
        }
    }); */
    jQuery(".nav-menu").click(function() {
        jQuery("body").toggleClass('support');

    });


    /* project slider */
    /*  jQuery(".slider-project").slick({
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
        arrows: true,
        dots: true,
        responsive: [{
            breakpoint: 540,
            settings: {
                slidesToShow: 1
            }
        }]
    });
    var x = jQuery(".tab-pane.active .slick-dots li").length;
    jQuery(".num-slide").append('<span class="tot">' + x + '</span>');
    jQuery(".num-slide .num").text('0' + jQuery(".tab-pane.active .slick-dots li.slick-active button").text());
    jQuery('.tab-pane.active .slider-project').on('afterChange', function(event, slick, currentSlide, nextSlide) {
        jQuery(".num-slide .num").text('0' + currentSlide);
    });

 */
    /* mobile ul */
    jQuery(".mobile-select span.text").text(jQuery(".nav.dropdown-menu a:first-child").text());
    jQuery(".nav.dropdown-menu a").click(function() {
        jQuery(".mobile-select span.text").text(jQuery(this).text());
        jQuery(".nav.dropdown-menu").fadeOut();
    });


    /* to top */
    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop() > 300) {
            jQuery('.gotop').addClass('show');
        } else {
            jQuery('.gotop').removeClass('show');
        }
    });
    jQuery(".gotop").click(function() {
        jQuery("html, body").animate({
            scrollTop: 0
        }, 600);
    });
    /* if ((jQuery(window).width()) > 767) { */

    /* responsive tabs accordion */
    jQuery('a[data-toggle="pill"]').on('click', function(e) {
        jQuery(this).tab('show');
        jQuery('.slider-project').slick('setPosition', 1);
        jQuery(".slider-project").slick("refresh");
    });

    jQuery('.navbar-toggler').click(function() {
        jQuery('body').addClass('offCanvasActive')
    });
    jQuery('.navbar-close').click(function() {
        jQuery('body').removeClass('offCanvasActive')
    });


});


/* Smooth scroll id */
jQuery(function() {
    jQuery('.smooth-scroll').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = jQuery(this.hash);
            target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                jQuery('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 500);
                return false;
            }
        }
    });
});


/* vertical center */
jQuery(function() {
    function reposition() {
        var modal = jQuery(this),
            dialog = modal.find('.modal-dialog');
        modal.css('display', 'block');

        // Dividing by two centers the modal exactly, but dividing by three
        // or four works better for larger screens.
        dialog.css("margin-top", Math.max(0, (jQuery(window).height() - dialog.height()) / 2));
    }
    // Reposition when a modal is shown
    jQuery('.modal').on('show.bs.modal', reposition);
    // Reposition when the window is resized
    jQuery(window).on('resize', function() {
        jQuery('.modal:visible').each(reposition);
    });

});





// jQuery(window).load(function() {
//     setInterval(function() {
//         load();
//     }, 1000);

//     function load() {
//         jQuery(".loader").delay(500).fadeOut(800);
//         setTimeout(addS, 500);
//     }

//     function addS() {
//         jQuery(".cover-text").fadeIn().addClass('slide');
//     }

// });