/* 
  * BEFORE THE DOM IS READY, TO AVOID SEEING THE MENU'S CSS BEFORE IT'S PHP CREATION !
  * Add  class="cb-subnav-trigger" to the link (<a>) of any main <li> that has children,
  * and wrap the inner content of this link (the link's text) with a <span>.
  * In the <ul> of any <li> that has children,
  * create and put <li class="go-back"> as first child of this <ul>,
  * also create and put a Placeholder as the last child of this <ul>.
  * 
  * This is much easier than writing a Walker...
 */
jQuery('.cb-main-nav li:has(ul) > a').addClass('cb-subnav-trigger').wrapInner('<span/>');
jQuery('.cb-main-nav li ul').prepend("<li class='go-back'><a href='#0'>" + cleanblog_nav_set.cleanblog_menu + "</a></li>")
        .append("<li><a href='#0' class='placeholder'>" + cleanblog_nav_set.cleanblog_placeholder + "</a></li>");



jQuery(document).ready(function ($) {

    //move nav element position according to window width
    moveNavigation();
    $(window).on('resize', function () { /* WHEN WE RESIZE THE SCREEN/WINDOW */
        (!window.requestAnimationFrame) ? setTimeout(moveNavigation, 300) : window.requestAnimationFrame(moveNavigation);
        /*
         * On any window resize, we remove the class .icon-close from the .icon-search, and hide the .search-dropdown.
         * We do this to reset the initial state of the .icon-search and the .search-dropdown.
         */
        $('.icon-search').removeClass('icon-close');
        $('.search-dropdown').hide();

        if (window.innerWidth >= 1024) { /* from mobile TO DESKTOP VIEW */

            /*
             * 1- When we are in the main menu on mobile view and resize the screen/window to desktop view :
             * We remove the class="nav-is-visible" from the <header.cb-nav>, the <ul class=cb-main-nav">
             * and the <main class"cb-main-content"> so their styles will not be applied.
             * Since we are coming from mobile, we could have been on the site, the main menu or the sub-menu.
             * In the last two cases, we prevent the <body> from scrolling, disable dropdown serach,
             * and .hide() the #scroll-up link. See 102, 147 & 142.
             * So, whatever is the case,
             * we give back the <body> the vertical scroll ability only, enable the dropdown search again,
             * and .show() the #scroll-up link ONLY if we where 300px and more from the top on mobile !
             * This is the normal behaviour of this link, it shows up only on or after 300px from the top. 
             */
            $('header.cb-nav, .cb-main-nav, .cb-main-content').removeClass('nav-is-visible');
            $('body').css('overflow-y', 'auto');
            $('.search-trigger').css('pointer-events', 'auto');
            if ($(document).scrollTop() >= 300) {
                $('#scroll-up').show();
            }

            /*
             * 2- When we are in the sub-menu mobile view and resize the screen/window to desktop view :
             * We hide the other <li> that are at the same level of the clicked one.
             * We will now see the selected <li>, <li class="selected"> and it's children the <ul class="children">.
             * Since we are coming from mobile,
             * the <ul> that doesn't have .children as their class are hidden. See Line 380.
             * So, we add an .on() click event to the actual .selected link <a class="cb-subnav-trigger">,
             * and attach a handler namespace subMobToDesk to this particular link.
             * When we click on this link, we .show() back the <ul> that doesn't have .children as their class.
             * We will now see the original navigation <ul class="cb-main-nav">.
             * Once this link is clicked, we take .off() this event from it,
             * to give this link an original state like the others that have children.
             * Now if we click again on this same link, it will act normally and shows us ONLY it's children.
             */
            if ($('.cb-main-nav').hasClass('moves-out')) {
                $('.selected .cb-subnav-trigger').parent().siblings().hide(); // 34
                $('.selected .cb-subnav-trigger').on('click.subMobToDesk', function (event) {
                    event.preventDefault();
                    $(this).parent().siblings().find('ul').show(); // 37
                    $(this).off('click.subMobToDesk');
                });
            }
        } else { /* (window.innerWidth < 1024)  from desktop TO MOBILE VIEW */
            
            /*
             * 1- When we are in the main menu desktop view and resize the screen/window to mobile view :
             * We give back the class="nav-is-visible" to the <header.cb-nav>,
             * the <ul class=cb-main-nav"> and the <main class"cb-main-content"> so their styles will be applied.
             * We do this by checking if the <main class="cb-main-content"> has the class="nav-is visible",
             * this can only happen when the <a class="cb-nav-trigger"> is clicked !
             * IMPORTANT NOTE : if we only remove the nav-is-visible class when we resize from desktop to mobile,
             * the main nav on mobile will be directly opened !
             */
            if ($('.cb-main-content').hasClass('nav-is-visible')) {
                $('header.cb-nav').addClass('nav-is-visible');
                $('.cb-main-nav').addClass('nav-is-visible');
                $('.cb-main-content').addClass('nav-is-visible');
            }

            /*
             * 2- When we are in the sub-menu <ul class="cb-main-nav moves-out"> on desktop
             * and resize the screen/window to mobile view,
             * we should only see the <ul class="children"> and it's children :
             * We add the class="nav-is-visible" to the <header.cb-nav>, the <ul class=cb-main-nav">
             * and the <main class"cb-main-content"> to aplly their styles.
             * We hide all the <ul> that doesn't have class="children".
             * Now we will only see the <ul class="children">
             * (of the  previously .selected <li> on desktop view) and it's children.
             * We add an .on() click event to the displayed <li class="go-back"> with a handler namespace goBackOrClose.
             * When we click on this <li class="go-back">,
             * we will see the original navigation <ul class="cb-main-nav nav-is-visible">.
             * Once this <li class="go-back"> is clicked, we take .off the added event from it.
             * WHAT IF WE DIRECTLY CLICK ON THE CLOSE ICON <a class="cb-nav-trigger">
             * AND DO NOT CLICK ON THE <li class="go-back"> ?!
             * In this case, since we are coming from destktop view,
             * the .siblings() of the .selected <li> are hidden. See Line 207.
             * We should .show() them back to guarantee that if the <a class="cb-nav-trigger"> is directly clicked,
             * instead of the <li class="go-back">,
             * those .siblings() will be visible when we open the main menu on mobile view.
             * So, since our goal is the same if we click on the <li class="go-back"> or the <a class="cb-nav-trigger">,
             * we simply add the .cb-nav-trigger selector to the same .on() click event of the goBackOrClose handler.
             * Now, if either of them is clicked, the .siblings() of the .selected <li> will regain their visible status,
             * and the .on() click event of the goBackOrClose handler will be exectuted only once.
             * Depending on the chosen action, we will be seeing the main menu or the site on mobile.
             * Last thing, since we are coming from desktop sub-nav to mobile sub-nav,
             * the <body> is scrollable and the #scrool-up link is visible if we are at 300px from top or more.
             * But on mobile we don't want the <body> to be scrollable if the sub menu is opened,
             * and don't want to see the #scrool-up link if were at 300px from top or more on desktop.
             * So first, we disable the scroll on the <body>,
             * and hide de #scrool-up link ONLY if the distance from top is at least 300px,
             * because if it's not more than 300px, the #scrool-up link is alerady hidden (see Line 142).
             * Finally, we close dropdown search if it was opened on desktop,
             * reset the .search-trigger button to it's initial state,
             * and disable the click event on the search trigger since we are now in mobile menu.
             */
            else if ($('.cb-main-nav').hasClass('moves-out')) {
                $('header.cb-nav, .cb-main-nav, .cb-main-content').addClass('nav-is-visible');
                $('.cb-main-nav').find('ul:not(.children)').hide(); // 88
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
                $('.search-trigger').css('pointer-events', 'none');
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
        /* Disable page scroll while viewing the menu */
        $('body').css('overflow', 'hidden'); // 102
        /* Disable dropdown serach while viewing the menu */
        $('.search-trigger').css('pointer-events', 'none'); // 147
        /* Close dropdown search if it's opened when viewing the menu */
        $('.search-dropdown').hide(); // 151
        /* Reset the .search-trigger button to it's initial state */
        $('.search-trigger .icon-search').removeClass('icon-close'); //153
        /* 
         * On click, set the margin-botom of the #page to 0px.
         * We do this because footer-reveal.js makes the <footer> always behind the page untill we reach it.
         * The menu on mobile is off canvas, so when the <footer> becomes visible and the menu is opened,
         * the overlapping effect is not clean at all.
         * So, we prevent it from happening by removing the original 166px margin-bottom of the #page,
         * when the <footer> is visible and .cb-nav-trigger is clicked !
         * Doing this will put the #page bottom exactly at the window bottom !
         * Important Note : every <hr> have a margin of 20px from top and bottom.
         * We remove the last <hr class="page-footer"> margin bottom in CSS ;)
         */
        $('#page').css('margin-bottom', '0');
        
        if ($('header.cb-nav').hasClass('nav-is-visible')) {
            $('.moves-out').removeClass('moves-out');
            /* Enable page scroll after closing the menu */
            $('body').css('overflow', 'auto');
            /* Enable dropdown serach after closing the menu */
            $('.search-trigger').css('pointer-events', 'auto');
            /* On close click, give back the #page it's margin-bottom, 166px */
            $('#page').css('margin-bottom', '166px');
        }

        $('header.cb-nav').toggleClass('nav-is-visible');
        $('.cb-main-nav').toggleClass('nav-is-visible');
        $('.cb-main-content').toggleClass('nav-is-visible');
        
        /* 
         * Reset the state of the main menu if we are in the sub-menu on mobile and the close icon is clicked.
         * When we are in the sub-menu on mobile, the <ul> of the .parent().siblings() of the clicked
         * <a class="cb-subnav-trigger"> are hidden, take a look at Line 380.
         * So if we click on the close icon, the main nav will be hidden,
         * and will not be visible enven when we click on the <a class="cb-nav-trigger"> to see the main menu.
         * To solve this, we reset the state of those <ul> and show them back if we click the close icon !
         */
        $('.cb-subnav-trigger').parent().siblings().children().show(); // 114

        /*
         * When the navigation is opened on mobile after 300px from the top,
         * the <a id="scroll-up"> stays visible and on top of the menu.
         * To prevent this ugly behavior we could use z-index in CSS,
         * but their will be conflicts with some other elements using also z-index.
         * So, on <a class="cb-nav-trigger"> click, the <main class="cb-main-content">
         * will have the class .nav-is-visible added to it.
         * We check if <main class="cb-main-content"> .hasClass('nav-is-visible')
         * OR if the actual scrolling distance from the top is less than 300px
         * (otherwise if the distance from the top is less than 300px
         * and we click on .cb-nav-trigger, the #scroll-up link will be visible
         * because we didn't prevent it from being displayed before 300px from top on .cb-nav-trigger click),
         * and we .hide() the #scroll-up link.
         * When we click again on <a class="cb-nav-trigger">,
         * the class .nav-is-visible will be removed from <main class="cb-main-content">.
         * So, at this particular moment OR when we are at 300px or more from the top
         * (without an opened menu, because if the menu is open .cb-main-content will have .nav-is-visible),
         * we use a setTimeout function to .show() back the #scroll-up link, but only after 300 ms,
         * the exact amout of time needed for the menu transition to end when we close it !
         */
        if ($('.cb-main-content').hasClass('nav-is-visible') || $(document).scrollTop() < 300) {
            $('#scroll-up').hide(); // 142
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

        /* 
         * Reset the state of the main menu if we are in the sub-menu on mobile, and we click on <li class="go-back">.
         * When we are in the sub-menu on mobile, the <ul> of the .parent().siblings() of the clicked
         * <a class="cb-subnav-trigger"> are hidden, take a look at Line 380.
         * So if we click on the <li class="go-back"> of the clicked <a class="cb-subnav-trigger">,
         * we will see the main navigation since this .parent().siblings().find('ul') are excluded from the .hide() method.
         * But, if we click on any other <li> that have children, their sub-menu will be hidden
         * since the .hide() method would have been previously applied to the <ul> of this other clicked <li>.
         * To solve this, we reset the state of those <ul> and show them back if we click on the <li class="go-back"> !
         */
        $('.cb-subnav-trigger').parent().siblings().children().show(); // 132

        /* 
         * Reset the state of the .selected <li> and it's <ul> if we are in the sub-menu on mobile,
         * and we click on <li class="go-back">.
         * When we are in the sub-menu on mobile, we see the <ul class="children"> and this <ul> children.
         * This happened because we've clicked on an <li> that has children.
         * Now, this clicked <li> becomes <li class="selected"> and it's <ul> becomes <ul class="children">.
         * To give back this <li> and it's <ul> their original state,
         * we just remove those classes when <li class="go-back"> is clicked. 
         * We do this to COMPLETELY reset the original state of the main menu on mobile view.
         */
        $('.selected').removeClass('selected'); // 144
        $('.children').removeClass('children'); // 145
    });

    //open sub-navigation
    $('.cb-subnav-trigger').on('click', function (event) {
        event.preventDefault();
        $('.cb-main-nav').toggleClass('moves-out');

        /* 
         * Add class="selected" to the <li> that has children when it's link <a class="cb-subnav-trigger"> is clicked.
         * Also add class="children" to the <ul> of this clicked <li class="selected">.
         * Then, remove those same classes of the other <li> and their <ul> that are at the same level of the clicked one.
         * This class="selected" will be used to :
         *  - hide/show all other <li> and their children (if any) except the one who has this class
         *      see Lines 207, 272, 380, 34, 37, 114, 132 and 144
         * This class="children" will be used to :
         *  - hide/show all other <ul> and their children except the one who has this particular class
         *      see Lines 380, 37, 88, 114, 132, 145
         */
        $(this).parent().addClass('selected').siblings().removeClass('selected');
        $(this).parent().find('ul').addClass('children').parent().siblings().find('ul').removeClass('children');


        /* If the screen size is greater or equal to 1024px. DESKTOP VIEW */
        if (window.matchMedia('(min-width: 1024px)').matches) {
            
            /*
             * To .hide() the main menu <li> children when the <a class="cb-subnav-trigger"> is clicked,
             * and then .show() back those <li> when the <a class="cb-subnav-trigger"> is clicked again
             * when we're in the sub-menu, we could simply do the following :
             * $(this).parent().siblings().toggle();
             * This will work but the TRANSITION will be VERY SLIGHTLY buggy.
             * To solve this look down at the following solution. 
             */

            /* 
             * When we are on the main menu on desktop and the <a class="cb-subnav-trigger"> is clicked,
             * the <ul class="cb-main-nav"> will have the class="moves-out" added to it.
             * So, We check if we are now in <ul class="cb-main-nav moves-out">,
             * and we .hide() the other <li> that are at the same level of the clicked one.
             * Now we assign the $(this) jQuery object to a variable named $this.
             * The variable $this will now hold the result of $(this).
             * This is specially to use it inside the setTimeout function, because $(this) won't work inside it.
             * NOW PAY CLOSE ATTENTION TO THE FOLLOWING.
             * Exactlly when the <a class="cb-subnav-trigger"> is clicked,
             * we .hide() it and disable the click on it's parent <li>.
             * HOW ARE WE GOING TO CLICK ON IT AGAIN TO COME BACK TO THE MAIN NAV IF IT'S HIDDEN AND UNCLICKABLE ?!
             * We do this by using 2 setTimeout function.
             * The first setTimeout function will show back the link (<a>) after 300 ms,
             * while the second setTimeout function will give back it's parent <li> the click ability only after 600 ms.
             * We do this to make a smoother transition for the .selected <li> between the main nav and the sub-nav,
             * and also to prevent a FAST second click on the .selected <li> once we are in sub-nav.
             * In fact, we wait for the transition of <ul class="cb-main-nav"> to end (300 ms),
             * then we show back the link (<a>) at the same time 300 ms,
             * and wait another 300 ms (600 ms) to give back the parent <li> of this link the click ability.
             * Otherwise, on FAST second click on the .selected <li>,
             * we will sometimes see the other <li> that have children in the sub-menu !
             * We are now in the sub-menu and we see only the <li class="selected">,
             * his <ul class="children"> and this <ul> children.
             */
            if ($('.cb-main-nav').hasClass('moves-out')) {
                console.log('go to sub');
                $(this).parent().siblings().hide(); // 207
                var $this = $(this);
                $this.hide();
                $this.parent().css("pointer-events", "none");
                setTimeout(function () {
                    $this.show();
                }, 300);
                setTimeout(function () {
                    $this.parent().css("pointer-events", "auto");
                }, 600);
            }

            /*
             * If the <ul class="cb-main-nav"> has not the class="moves-out" added to it.
             * This is when we are seeing the main nav only and it's main <li> children.
             * Our goal is to .show() those main <li> children (since we've .hide() them earlier, see Line 207),
             * BUT ONLY AFTER if the <ul class="cb-main-nav"> has the class="moves-out" added to it
             * and we click on the .selected <a class="cb-subnav-trigger"> again.
             * To do this, we know that the class="moves-out" is added(to)/removed(from) the <ul class="cb-main-nav">
             * each and every time the <a class="cb-subnav-trigger"> is clicked.
             * On the sub-menu view the <ul class="cb-main-nav"> already has the class="moves-out" added to it,
             * but this class will be removed from it as soon as we click on the .selected <a class="cb-subnav-trigger">.
             * NOW PAY CLOSE ATTENTION TO THE FOLLOWING.
             * We are in the sub-menu view, the  <ul class="cb-main-nav"> has the class="moves-out" added to it,
             * so EXACTLLY when the .selected <a class="cb-subnav-trigger"> is clicked,
             * the class="moves-out" will be removed from it.
             * At this particular moment, we assign the $(this) jQuery object to a variable named $this.
             * The variable $this will now hold the result of $(this).
             * This is specially to use it inside the setTimeout function, because $(this) won't work inside it.
             * Using the $this variable,
             * we .hide() the <pan> of the clicked .selected <a class="cb-subnav-trigger">,
             * this will ensure that the label of this link won't be visible, 
             * then we hide (not remove) the borders properties of this link and disable the click on it's parent <li>.
             * HOW ARE WE GOING TO CLICK ON IT AGAIN TO COME BACK AND SEE IT'S OWN SUB NAV IF IT'S HIDDEN AND UNCLICKABLE ?!
             * We do this by using 2 setTimeout function.
             * The first setTimeout function will show back the <span> of the link (<a>) to see it's label again,
             * give it back it's borders properties to have the same apperance of the other <li> that have children,
             * and show back the .siblings() of this .parent() link (since we've .hide() them previously, see Line 207),
             * all of this just after 300 ms, the exact amount of time needed for the transition of .moves-out to end !
             * We do this to make a smoother transition for the .selected <li> and it's .siblings()
             * between the sub-nav and the main nav, so we can see them all at once when the transition ends.
             * The second setTimeout function will give back it's parent <li> the click ability only after 600 ms.
             * We do this to prevent a FAST second click on the .selected <li> once we are in main nav.
             * We are now in the main menu and we see only the main <li> !
             * EXPLANATION :
             * When we are in the sub-menu view and click on the .selected <a class="cb-subnav-trigger">,
             * we .hide() this <span> link, hide it's own borders, and disable the click on it's parent <li>,
             * we wait for the transition of <ul class="cb-main-nav"> to end (300 ms),
             * then we show back the <span> link (<a>), it's own borders,
             * and it's .parent().siblings() at the same time 300 ms,
             * we now wait another 300 ms (600 ms) to give back the parent <li> of this link the click ability.
             * We are now in the main menu and we see only the main <li> !
             * Note : this approach, rather than using the transitionend event and bind it with jQuery’s .one() function,
             * is because IE sucks and the transitionend event is not working as expected in IE !
             * In IE, the transitionend event is not firing unless the cursor is moved out of the <span> or the link !
             */
            else {
                console.log('clicked to go back');
                var $this = $(this);
                $this.children().hide();
                $this.css("border", "transparent");
                $this.parent().css("pointer-events", "none");
                setTimeout(function () {
                    $this.children().show();
                    $this.css("border", "");
                    $this.parent().siblings().show(); // 272
                }, 300);
                setTimeout(function () {
                    $this.parent().css("pointer-events", "auto");
                }, 600);

                /*
                 * THE BELOW SOLUTION WORKS IN ALL BROWSERS EXCEPT FOR IE, BECAUSE IE SUCKS !!!
                 * 
                 * Prevent transitionend event firing twice 
                 * @see https://www.iambacon.co.uk/blog/prevent-transitionend-event-firing-twice
                 * 
                 
                 function whichTransitionEvent() { // 285
                 var el = document.createElement('fake'),
                 transEndEventNames = {
                 'WebkitTransition' : 'webkitTransitionEnd',// Saf 6, Android Browser
                 'MozTransition'    : 'transitionend',      // only for FF < 15
                 'transition'       : 'transitionend'       // IE10, Opera, Chrome, FF 15+, Saf 7+
                 };
                 
                 for(var t in transEndEventNames){
                 if( el.style[t] !== undefined ){
                 return transEndEventNames[t];
                 }
                 }
                 }
                 var transEndEventName = whichTransitionEvent();
                 
                 * If the <ul class="cb-main-nav"> has not the class="moves-out" added to it.
                 * This is when we are seeing the main nav only and it's main <li> children.
                 * Our goal is to .show() those main <li> children (since we've .hide() them earlier, see Line 207),
                 * BUT ONLY AFTER if the <ul class="cb-main-nav"> has the class="moves-out" added to it
                 * and we click on <a class="cb-subnav-trigger">.
                 * To do this, we know that the class="moves-out" is added(to)/removed(from) the <ul class="cb-main-nav">
                 * each and every time the <a class="cb-subnav-trigger"> is clicked.
                 * On the sub-menu view the <ul class="cb-main-nav"> already has the class="moves-out" added to it,
                 * but this class="moves-out" will be removed from it as soon as we click on <a class="cb-subnav-trigger">.
                 * So, we wait untill the transition of .moves-out ends before showing the main nav and it's main <li>.
                 * In other words, we wait for the CSS transition of .moves-out to completely ends,
                 * and then .show() the main nav and it's main <li>.
                 * We do this by using the transitionend event.
                 * The transitionend event occurs when a CSS transition has completed.
                 * So, we bind the transitionend event with the .one() function, which ensures that it runs only once.
                 * NOW PAY CLOSE ATTENTION TO THE FOLLOWING.
                 * we are in the sub-menu view, the  <ul class="cb-main-nav"> has the class="moves-out" added to it,
                 * so EXACTLLY when the .selected <a class="cb-subnav-trigger"> is clicked,
                 * the class="moves-out" will be removed from it.
                 * At this particular moment, we assign the $(this) jQuery object to a variable named $this.
                 * The variable $this will now hold the result of $(this).
                 * This is specially to use it inside the setTimeout function, because $(this) won't work inside it.
                 * Using the $this variable,
                 * we .hide() the clicked .selected <a class="cb-subnav-trigger"> link,
                 * and disable the click on it's parent <li>.
                 * HOW ARE WE GOING TO CLICK ON IT AGAIN TO COME SEE IT'S OWN SUB NAV IF IT'S HIDDEN AND UNCLICKABLE ?!
                 * We do this by using 2 setTimeout function.
                 * The first setTimeout function will show back the link (<a>),
                 * and the .siblings() of this .parent() link (since we've .hide() them previously, see Line 207),
                 * after 300 ms, the exact amount of time needed for the transition of .moves-out to end !
                 * We do this to make a smoother transition for the .selected <li> and it's .siblings()
                 * between the sub-nav and the main nav, so we can see them all at once when the transition ends.
                 * The second setTimeout function will give back it's parent <li> the click ability only after 600 ms.
                 * We do this to prevent a FAST second click on the .selected <li> once we are in main nav.
                 * We are now in the main menu and we see only the main <li> !
                 * EXPLANATION :
                 * When we are in the sub-menu view and click on the .selected <a class="cb-subnav-trigger">,
                 * we .hide() this link and disable the click on it's parent <li>,
                 * we wait for the transition of <ul class="cb-main-nav"> to end (300 ms),
                 * then we show back the link (<a>) and it's .parent().siblings() at the same time 300 ms,
                 * and wait another 300 ms (600 ms) to give back the parent <li> of this link the click ability.
                 * We are now in the main menu and we see only the main <li> !
                 * Note : You can see that we have prevented the transitionend event from firing twice
                 * with the help of the whichTransitionEvent() function at Line 285.
                 
                 $('.selected .cb-subnav-trigger').one(transEndEventName, function(event) {
                 event.preventDefault();
                 console.log('back to main');
                 var $this = $(this);
                 $this.hide();
                 $this.parent().css("pointer-events","none");
                 setTimeout(function(){
                 $this.show();
                 $this.parent().siblings().show(); // This was Line 272
                 }, 300);
                 setTimeout(function(){
                 $this.parent().css("pointer-events","auto");
                 }, 600);
                 });
                 */
            }
        }

        /* If the screen size is strictly smaller than 1024px. MOBILE VIEW */
        else {

            /*
             * We can only see the main nav if we click on the <a class="cb-nav-trigger">.
             * When we click on this trigger link, the class="nav-is-visible" will be added to
             * the <header.cb-nav>, the <ul class=cb-main-nav"> and the <main class"cb-main-content">.
             * We will then see the main nav and it's main <li> children.
             * The link (<a>) of the main <li> who has children, will have the class="cb-subnav-trigger".
             * When we click on any of those main <li> who has children,
             * the class="moves-out" will be added to the <ul class=cb-main-nav">.
             * At this point, we .hide() the other main <li> children and
             * the other <ul> that doesn't have (at this time) .children as their class,
             * to only see this clicked <li> children.
             */
            if ($('.cb-main-nav').hasClass('moves-out')) {
                $(this).parent().siblings().find('ul').hide(); // 380
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