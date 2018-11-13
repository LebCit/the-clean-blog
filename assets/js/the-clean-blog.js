jQuery(document).ready(function ($) {

    //1. Navigation Scripts to Show Header on Scroll-Up
    var MQL = 1024;

    // Primary navigation slide-in effect
    if ($(window).width() >= MQL) {
        var headerHeight = $('.cb-nav').height();
        $(window).on('scroll', {
            previousTop: 0
        },
                function (e) {
                    e.preventDefault();
                    var currentTop = $(window).scrollTop();
                    //check if user is scrolling up
                    if (currentTop < this.previousTop) {
                        //if scrolling up...
                        if (currentTop > 0 && $('.cb-nav').hasClass('is-fixed')) {
                            $('.cb-nav').addClass('is-visible');
                        } else {
                            $('.cb-nav').removeClass('is-visible is-fixed');
                        }
                    } else if (currentTop > this.previousTop) {
                        //if scrolling down...
                        $('.cb-nav').removeClass('is-visible');
                        if (currentTop > headerHeight && $('.cb-nav:not(".is-fixed")'))
                            $('.cb-nav').addClass('is-fixed');
                        // Reset the initial state of the search icon and dropdown
                        $('.icon-search').removeClass('icon-close');
                        $('.search-dropdown').hide();
                    }
                    this.previousTop = currentTop;
                });
    }//End 1.

    //2. Click on the parent <span> of the arrow down and scroll to the #content
    $('.strike > span').click(function (e) {
        e.preventDefault();
        if (window.innerWidth >= 1024) {
            $('html, body').animate({
                scrollTop: $("#content").position().top
            }, 600);
        } else {
            $('html, body').animate({
                scrollTop: $("#content").position().top - 50
            }, 600);
        }
    });
    
    // Function to check if an element is visible while scrolling.
    $.fn.isOnScreen = function () {

        var win = $(window);

        var viewport = {
            top: win.scrollTop(),
            left: win.scrollLeft()
        };
        viewport.right = viewport.left + win.width();
        viewport.bottom = viewport.top + win.height();

        var bounds = this.offset();
        bounds.right = bounds.left + this.outerWidth();
        bounds.bottom = bounds.top + this.outerHeight();

        return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
    };
    
    // Add/Remove .bounce class from .strike on scroll if it's visible on screen
    $('.strike').each(function(){
        $strike = $(this);
        $(window).scroll(function (event) {
            event.preventDefault;
            if (!$('.fa-arrow-down').isOnScreen()) {
                $strike.removeClass('bounce');
            } else {
                setTimeout(function () {
                    $strike.addClass('bounce');
                }, 900);
            }
        });
    });
    
    // Sub menu from mobile to desktop, Remove .bounce class from .strike on resize, even if it's visible on screen
    $(window).on('resize', function () {
        if ($('.cb-main-nav').hasClass('moves-out') && window.innerWidth < 1024 && $('.fa-arrow-down').isOnScreen()) {
            $strike.removeClass('bounce');
        }
    });
    //End 2.

    /*
     * Before opening the Header Search Form,
     * do not waste time by creating jQuery object from window multiple times.
     * Do it just once and store it in a variable.
     * This is done to take care of the performance.
     */ 
    var $window = $(window);
    var originalHeight = $(window).height();
    var originalWidth = $(window).width();
    //3. Open/Close Header Search Form
    $('.search-trigger').click(function () {
        $(this).find('i').toggleClass('icon-close');
        $('.search-dropdown').animate({
            height: 'toggle',
            opacity: 'toggle'
        });
        // Reset the initial state of the search icon and dropdown
        if ($('.icon-close').is(':visible')) {
            if ($window.height() !== originalHeight) {
                $(this).find('i').addClass('icon-close');
                $('.search-dropdown').show();
            }
            $window.resize(function () {
                /* 
                 * Do not calculate the new window width twice.
                 * Do it just once and store it in a variable.
                 */
                var newWidth = $window.width();
                // Do the comparison
                if (originalWidth !== newWidth) {
                    // Execute the code
                    $('.search-trigger .icon-search').removeClass('icon-close');
                    $('.search-dropdown').hide();
                    // Reset the width
                    originalWidth = newWidth;
                }
            });
        }
        //  Focus in input search field
        $('.search-dropdown .search-field').focus();
    });
    // Reset Search Input Value to Search...    
    $('input.search-field').val('');//End 3.

    /* 4.
     * Give #wpadminbar a fixed position from 600px and below
     * Used JS instead of CSS because theme check plugin
     * require not to use #wpadminbar in stylesheet
     */
    if (($('.admin-bar').length) && (window.matchMedia('(max-width: 600px)').matches)) {
        $('#wpadminbar').css({position: 'fixed', right: '490px'});
    }//End 4.

    //5. Add required attribute to input field on 404.php and search.php
    if (($('.not-found').length)) {
        $("input").prop('required', true);
    }//End 5.

    //6. Add fixed/reveal effect to footer with footer-reveal.js
    $('#colophon').footerReveal({shadowOpacity: 1});//End 6.

    //7. Add scroll to top feature with jquery.scrollUp.js
    $(function () {
        $.scrollUp({
            scrollName: 'scroll-up',
            scrollImg: true,
            scrollSpeed: 600,
            easingType: 'linear',
            animation: 'fade',
            animationSpeed: 600
        });
    });//End 7.

    //8. Adjusting .entry-header h1 starting from 768px width
    function resizeH1() {
        $('.entry-header h1').each(function(){
        $h1 = $(this);
        if (window.innerWidth >= 768) {
            /*
             * Since .site-heading is hidden by default in CSS
             * (when the window width is >= 768px)
             * to avoid $h1 from flashing while resizing,
             * we .show() it back with a .delay() to preserve the new styles.
             * .delay() allows to delay the execution of functions that follow it.
             * If we only use .show(), the display property will be restored
             * to whatever it was initially, and our styles will not be applied !
             */
            $('.site-heading').delay().show();
            // Calculate the total height of the element
            var totalHeight = ($h1.height());
            /*
             * Calculate the number of lines of this element
             * Total height divided by the height of one letter
             * One letter height = 80px (font-size) x 1.1 (line-height) = 88px
             */
            var numOfLines = totalHeight / 88;
            // Force this element height to always be 88px
            $h1.height(88);
            // Adjust $h1 font-size depending on it's number of lines
            if (numOfLines === 2) {
                $h1.css('font-size', '42px');
            } else if (numOfLines === 3) {
                $h1.css('font-size', '40px');
            } else if (numOfLines === 4) {
                $h1.css('font-size', '38px');
            } else if (numOfLines >= 5) {
                $h1.css('font-size', '28px');
            }
            // Align the $h1 text verticaly at the very end
            if (numOfLines >= 2) {
                $h1.css({
                    'text-align': 'center',
                    'display': 'flex',
                    'justify-content': 'center',
                    'align-items': 'flex-end'
                });
            }
        } else {
            // Reset the $h1 state when (window.innerWidth < 768)
            $h1.css({
                'height': '',
                'font-size': '',
                'text-align': '',
                'display': '',
                'justify-content': '',
                'align-items': ''
            });
        }
        });
    }
    // Run the function on DOM ready
    resizeH1();
    // Run the function in case of window resize
    $(window).resize(function (e) {
        e.preventDefault;
        resizeH1();
    });//End 8.
    
    //9. Activate Unslider / Unslider settings
    var slider = $('.tcb-slider');
    
    // Calculate the length of thecleanblog_slider_animation data, the length of the animation's name.
    var animationNameLength = thecleanblog_set.thecleanblog_slider_animation.length;
    // Depending on the length of the animation's name, set the animation type.
    // Used apostrophes (') around numbers to exactly match the value, not only the number !
    var animationType;
    if (animationNameLength == '4') {
        animationType = 'fade';
    } else if (animationNameLength == '8') {
        animationType = 'vertical';
    } else if (animationNameLength == '10') {
        animationType = 'horizontal';
    }
    
    // Calculate the length of thecleanblog_slider_horizontal_slides_direction data, 0(LTR) or 1(RTL) (default is 0).
    var horizontalSlidesDirection = thecleanblog_set.thecleanblog_slider_horizontal_slides_direction.length;
    // Depending on the length of this data 0(LTR) or 1(RTL), set the default html for the right an left arrows of the slider.
    var prevNext; var nextPrev;
    // If RTL is choosen AND the animation is set to horizontal, invert the default classes of the arrows.
    if ((horizontalSlidesDirection > 0) && (animationNameLength == '10')) {
        prevNext = '<a class="unslider-arrow next"> </a>';
        nextPrev = '<a class="unslider-arrow prev"> </a>';
    } else { // Default classes for each arrow, prev for prev and next for next !
        prevNext = '<a class="unslider-arrow prev"> </a>';
        nextPrev = '<a class="unslider-arrow next"> </a>';
    }
    
    // Set the slider slides infinite loop to true or false (default : false = 0).
    // Retrive the default value and assign it to a variable.
    var slidesInfiniteLoopValue = thecleanblog_set.thecleanblog_slider_slides_loop.length;
    // Depending on the value of the infinite loop, set the infinite loop to true or false.
    var infiniteLoopTrueOrFalse;
    if (slidesInfiniteLoopValue === 0) {
        infiniteLoopTrueOrFalse = false;
    } else if (animationType != 'fade') { // Disable infinite loop if the choosen animation is fade, because fade is infinite !
        infiniteLoopTrueOrFalse = true;
    }
    slider.unslider({
        autoplay: true,
        nav: false,
        arrows: {
            prev: prevNext,
            next: nextPrev
        },
        animation: animationType,
        infinite: infiniteLoopTrueOrFalse
    });
    
    // If the slider slides infinite loop is true, force the second and last background header image to resize depending on $(window) size.
    if (infiniteLoopTrueOrFalse === true) {
        var $this = $('.unslider-clone').siblings(':first').children();
        var $that = $('.unslider-clone').siblings(':last-child').children();
        $(window).on('resize', function () {
            $this.add($that).css({
                'width': $(window).width(),
                'height': $(window).height()
            });
        });
    }

    // On Mobile View, stop the slider when the mobile menu is opened then restart it when the mobile menu gets closed, only if the slider is activated.
    var checkSliderActivation = thecleanblog_set.thecleanblog_slider_activated.length;
    if (checkSliderActivation !== 0) {
        $('.cb-nav-trigger').on('click', function (event) {
            event.preventDefault();
            slider.data('unslider').stop();
            if (!$('header.cb-nav').hasClass('nav-is-visible')) {
                slider.data('unslider').start();
            }
        });
    }
    // Restart the slider if we go from mobile TO DESKTOP VIEW !
    if (checkSliderActivation !== 0) {
        $(window).on('resize', function () {
            if (window.innerWidth >= 1024) {
                slider.data('unslider').start();
            /* Stop the slider if we go from desktop TO MOBILE VIEW && Sub menu from desktop to mobile */
            } else if (window.innerWidth < 1024 && $('header.cb-nav').hasClass('nav-is-visible')) {
                slider.data('unslider').stop();
            }
        });
        
    }//End 9.
    
    //10. Activate the preloader
    // Initialise loaders that are added after page load
    $('.loader-inner').loaders();
    /* fadeOut() the preloader with setTimeout() on document ready() because it's faster then on window load() 
     * Call the php variable thecleanblog_set.thecleanblog_preloader_animation_time as the time parameter of setTimeout()
     * This php variable will allow us to define the time of the fadeOut() inside the Customizer
     */
    setTimeout(function(){
        $('.preloader-wrapper').fadeOut();
    }, thecleanblog_set.thecleanblog_preloader_animation_time);
    // Finally, when the preloader fadeOut(), remove the .preloader-site class from the body to prevent preloader's styles from affecting the body
    $('body').removeClass('preloader-site');
    //End 10.

    //11. Toggle the visibility of sub-menu in menu widget
    // Target the link <a> of each <li> item that has children
    var itemHasChlidren = $('.widget.widget_nav_menu .menu-item-has-children > a');
    /**
     * When this link is clicked, we slideToggle() his parent <li> children
     * and we slideUp this <li> siblings' children if they where opened previously.
     */
    itemHasChlidren.on('click', function (e) {
        e.preventDefault();
        $(this).addClass('item-has-children-link-clicked'); // Added to control the :hover effect after :focus state
        $(this).parent().children('.sub-menu').slideToggle(1000);
        $(this).parent().siblings().children('.sub-menu').slideUp(1000);
    });
    //End 11.

    //12. Some styles for the calendar widget
    // Modified linear-gradient to work in IE and Edge.
    $('.widget_calendar #today').parent().prevAll().children(':not(.pad)').css('background-image', 'linear-gradient(to right bottom, transparent 49%, red 50%, transparent 51%)');
    $('.widget_calendar #today').prevAll().css('background-image', 'linear-gradient(to right bottom, transparent 49%, red 50%, transparent 51%)');
    //End 12.
});