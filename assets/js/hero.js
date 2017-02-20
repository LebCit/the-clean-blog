/*
 * This file assigns a dynamic height and width to the hero (#masthead) background image.
 * 
 * Create a javascript function that gets the height and width value of the window
 * and assign that values to the hero (#masthead) element,
 * that will make the hero (#masthead) section fullscreen.
 * 
 * Set this function to run every time the window is resized,
 * so that the hero section is consistent with the window size.
 *
 * Thanks to Jinson Abraham
 * @link http://codepen.io/web2feel/pen/gbjNgw
 */

jQuery(document).ready(function ($) {
    // Defining a function to set size for #masthead 
    function fullscreen() {
        jQuery('#masthead').css({
            width: jQuery(window).width(),
            height: jQuery(window).height()
        });
    }

    fullscreen();

    // Run the function in case of window resize
    jQuery(window).resize(function () {
        fullscreen();
    });

});