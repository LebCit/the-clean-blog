/* 
 * File the-clean-blog-customizer.js
 * 
 * Access Theme Customizer Controls for a better user experience.
 */

jQuery(document).ready(function($){
    
    // Add a placeholder to the input[value] of each control that has '_text' as a part of it's ID .
    $(function() {
        var $this = $("[id*='_text'] input[value]");
        var $placeholder = thecleanblog_customizer_set.thecleanblog_control_placeholder;
        if ($this.val() === '' || $this.val() !== '') {
            $this.parent().children().prop('placeholder', $placeholder);
        }
    });

} );