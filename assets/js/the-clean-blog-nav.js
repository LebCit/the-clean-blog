/*
Navigation Script Taken, And TOTALLY Modified, From CodyHouse : https://codyhouse.co/
Navigation Inspired By Secondary Sliding Navigation Article :   https://codyhouse.co/gem/secondary-sliding-navigation/
A BIG THANKS Goes To The Author Of This Article, Claudia Romano : https://twitter.com/romano_cla
*/

/* 
  * BEFORE THE DOM IS READY, INSERT NEEDED ITEMS TO THE MENU,
  * TO AVOID SEEING THE MENU'S CSS BEFORE IT'S PHP CREATION !
  * 
  * EASIER THAN WRITING A WALKER !
 */
jQuery('.cb-main-nav li:has(ul) > a').addClass('cb-subnav-trigger').wrapInner('<span/>');
jQuery('.cb-main-nav li ul').prepend("<li class='go-back'><a href='#0'>" + thecleanblog_nav_set.thecleanblog_menu + "</a></li>")
        .append("<li><a href='#0' class='placeholder'>" + thecleanblog_nav_set.thecleanblog_placeholder + "</a></li>");

jQuery(document).ready(function ($) {

    //move nav element position according to window width
    moveNavigation();
    $(window).on('resize', function () { /* WHEN WE RESIZE THE SCREEN/WINDOW */
        (!window.requestAnimationFrame) ? setTimeout(moveNavigation, 300) : window.requestAnimationFrame(moveNavigation);

        if (window.innerWidth >= 1024) { /* from mobile TO DESKTOP VIEW */

            // 1- Main menu from mobile to desktop.
            $('header.cb-nav, .cb-main-nav, .cb-main-content').removeClass('nav-is-visible');
            $('body').css('overflow-y', 'auto');
            $('body').css('pointer-events', 'auto');
            $('.search-trigger').css('pointer-events', 'auto');
            $('.strike').addClass('bounce');
            if ($(document).scrollTop() >= 300) {
                $('#scroll-up').show();
            }

            // 2- Sub menu from mobile to desktop.
            if ($('.cb-main-nav').hasClass('moves-out')) {
                $('.selected .cb-subnav-trigger').parent().siblings().hide();
                $('.selected .cb-subnav-trigger').on('click.subMobToDesk', function (event) {
                    event.preventDefault();
                    $(this).parent().siblings().find('ul').show();
                    $(this).off('click.subMobToDesk');
                });
            }
        } else { /* (window.innerWidth < 1024)  from desktop TO MOBILE VIEW */
            
            // 1- Main menu from desktop to mobile.
            if ($('.cb-main-content').hasClass('nav-is-visible')) {
                $('header.cb-nav').addClass('nav-is-visible');
                $('.cb-main-nav').addClass('nav-is-visible');
                $('.cb-main-content').addClass('nav-is-visible');
            }

            // 2- Sub menu from desktop to mobile.
            else if ($('.cb-main-nav').hasClass('moves-out')) {
                $('header.cb-nav, .cb-main-nav, .cb-main-content').addClass('nav-is-visible');
                $('.cb-main-nav').find('ul:not(.children)').hide();
                $('.go-back, .cb-nav-trigger').on('click.goBackOrClose', function (event) {
                    event.preventDefault();
                    $('.cb-main-nav').children().show();
                    $(this).off('click.goBackOrClose');
                });
                $('body').css('overflow', 'hidden');
                if ($(document).scrollTop() >= 300) {
                    $('#scroll-up').hide();
                }
                $('.search-dropdown').hide();
                $('.search-trigger .icon-search').removeClass('icon-close');
                $('body, .search-trigger').css('pointer-events', 'none');
                $('#wpadminbar, .cb-nav-trigger, .cb-main-nav').css('pointer-events', 'auto');
            }
            
            /* 
             * Force the featuread image to take the full width of the viewport
             * and fix #wpadminbar when resizing from desktop to mobile.
            */
            $('#masthead').css('width', '100vw');
            $('#wpadminbar').css('position', 'fixed');
        }
    });

    //mobile version - open/close navigation
    $('.cb-nav-trigger').on('click', function (event) {
        event.preventDefault();
        // Disable page scroll while viewing the menu
        $('body').css('overflow', 'hidden');
        // Disable all click events while viewing the menu except on the menu
        $('body, .search-trigger').css('pointer-events', 'none');
        $('.cb-nav-trigger, .cb-main-nav').css('pointer-events', 'auto');
        // Close dropdown search if it's opened when viewing the menu
        $('.search-dropdown').hide();
        // Reset the .search-trigger button to it's initial state
        $('.search-trigger .icon-search').removeClass('icon-close');
        // Stop the arrow down bouncing
        $('.strike').removeClass('bounce');
        // Set the margin-botom of the #page to 0px
        $('#page').css('margin-bottom', '0');
        
        if ($('header.cb-nav').hasClass('nav-is-visible')) {
            $('.moves-out').removeClass('moves-out');
            // Enable page scroll after closing the menu
            $('body').css('overflow', 'auto');
            // Enable the click events after closing the menu
            $('body, .search-trigger').css('pointer-events', 'auto');
            // Give back the arrown down the bouncing effect after 300ms
            var $strike = $('.strike');
            setTimeout(function () {
                $strike.addClass('bounce');
            }, 300);
            // On close click, give back the #page it's margin-bottom, 166px
            $('#page').css('margin-bottom', '166px');
        }

        $('header.cb-nav').toggleClass('nav-is-visible');
        $('.cb-main-nav').toggleClass('nav-is-visible');
        $('.cb-main-content').toggleClass('nav-is-visible');
        
        // Reset the state of the main menu
        $('.cb-subnav-trigger').parent().siblings().children().show();

        // Hide/Show #scroll-up
        if ($('.cb-main-content').hasClass('nav-is-visible') || $(document).scrollTop() < 300) {
            $('#scroll-up').hide();
        } else {
            setTimeout(function () {
                $('#scroll-up').show();
            }, 300);
        }
    });

    //mobile version - go back to main navigation
    $('.go-back').on('click', function (event) {
        event.preventDefault();
        $('.cb-main-nav').removeClass('moves-out');

        // Reset the state of the main menu on mobile
        $('.cb-subnav-trigger').parent().siblings().children().show();

        // Reset the original state of the main menu on mobile
        $('.selected').removeClass('selected');
        $('.children').removeClass('children');
    });

    //open sub-navigation
    $('.cb-subnav-trigger').on('click', function (event) {
        event.preventDefault();
        $('.cb-main-nav').toggleClass('moves-out');

        // Add classes .selected and .children
        $(this).parent().addClass('selected').siblings().removeClass('selected');
        $(this).parent().find('ul').addClass('children').parent().siblings().find('ul').removeClass('children');


        /* If the screen size is greater or equal to 1024px. DESKTOP VIEW */
        if (window.matchMedia('(min-width: 1024px)').matches) {

            // Hide/Show main menu
            if ($('.cb-main-nav').hasClass('moves-out')) {
                $(this).parent().siblings().hide();
                var $this = $(this);
                $this.hide();
                $this.parent().css("pointer-events", "none");
                setTimeout(function () {
                    $this.show();
                }, 300);
                setTimeout(function () {
                    $this.parent().css("pointer-events", "auto");
                }, 600);
            } else {
                var $this = $(this);
                $this.children().hide();
                $this.css("border", "transparent");
                $this.parent().css("pointer-events", "none");
                setTimeout(function () {
                    $this.children().show();
                    $this.css("border", "");
                    $this.parent().siblings().show();
                }, 300);
                setTimeout(function () {
                    $this.parent().css("pointer-events", "auto");
                }, 600);
            }
        }

        /* If the screen size is strictly smaller than 1024px. MOBILE VIEW */
        else {
            // Show only .selected <li> children
            if ($('.cb-main-nav').hasClass('moves-out')) {
                $(this).parent().siblings().find('ul').hide();
            }
        }

    });

    function moveNavigation() {
        var navigation = $('.cb-main-nav-wrapper');
        var screenSize = checkWindowWidth();
        if (screenSize) {
            //desktop screen - insert navigation inside header.cb-nav element
            navigation.detach();
            navigation.insertBefore('.cb-nav-trigger');
        } else {
            //mobile screen - insert navigation after .cb-main-content element
            navigation.detach();
            navigation.insertAfter('.cb-main-content');
        }
    }

    function checkWindowWidth() {
        var mq = window.getComputedStyle(document.querySelector('header.cb-nav'), '::before').getPropertyValue('content').replace(/"/g, '').replace(/'/g, "");
        return (mq === 'mobile') ? false : true;
    }
});