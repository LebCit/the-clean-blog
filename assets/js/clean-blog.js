jQuery(document).ready(function ($) {

    //1. Navigation Scripts to Show Header on Scroll-Up
    var MQL = 768;

    // Primary navigation slide-in effect
    if ($(window).width() > MQL) {
        var headerHeight = $('.navbar-custom').height();
        $(window).on('scroll', {
            previousTop: 0
        },
                function () {
                    var currentTop = $(window).scrollTop();
                    //check if user is scrolling up
                    if (currentTop < this.previousTop) {
                        //if scrolling up...
                        if (currentTop > 0 && $('.navbar-custom').hasClass('is-fixed')) {
                            $('.navbar-custom').addClass('is-visible');
                        } else {
                            $('.navbar-custom').removeClass('is-visible is-fixed');
                        }
                    } else if (currentTop > this.previousTop) {
                        //if scrolling down...
                        $('.navbar-custom').removeClass('is-visible');
                        if (currentTop > headerHeight && !$('.navbar-custom').hasClass('is-fixed'))
                            $('.navbar-custom').addClass('is-fixed');
                    }
                    this.previousTop = currentTop;
                });
    }//End 1.

    //2. Click on the arrow down and scrollTo the #content 
    $('.fa-arrow-down').click(function (e) {
        e.preventDefault();
        $(window).scrollTo('#content', {
            duration: 600
        });
    });//End 2.

    //3. Open/Close Header Search Form and focus in input search field
    $('.search-trigger').click(function () {
        $(this).find('i').toggleClass('icon-close', 'icon-search');
        $('.search-dropdown').animate({
            height: 'toggle',
            opacity: 'toggle'
        });
        $('.search-dropdown .search-field').focus();
    });
    // Reset Search Input Value to Search...    
    $('input.search-field').val('');//End 3.

    /**4.
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
    	
});