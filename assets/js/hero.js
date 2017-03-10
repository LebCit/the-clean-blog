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

(function($) {
    fullscreen();
    function fullscreen() {
        $.ajax({
            type: 'POST',
            url: imgobj.ajaxurl,
            data: {
                action : 'cleanblog_header_style'
            },
            beforeSend : function(){
                if (imgobj.key3){
                    $('#masthead').css({
                        'background-image': 'url(' + imgobj.key1 + ')',
                        width: $(window).width(),
                        height: $(window).height()
                    });
                } else {
                    $('#masthead').css({
                        'background-image': 'url(' + imgobj.key2 + ')',
                        width: $(window).width(),
                        height: $(window).height()
                    });
                }
            }
        });
    }
    
    // Run the function in case of window resize.
    $(window).resize(function(e) {
        e.preventDefault();
        fullscreen();
    });
})(jQuery);