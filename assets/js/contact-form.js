jQuery(document).ready(function ($) {
    // Remove the website url div from users' eyes.
    $('input[name=website]').closest('div.control-group').hide();
    
    // Contact form validation script with validate.js
    $(function() {
        
        // Set contact form fields to empty values.
        $("#sender").val("");
        $("#email").val("");
        $("#website").val("");
        $("#message").val("");
        
        // Custom sender name pattern for the sender field.
        $.validator.addMethod("sender", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9\_]{2,20}/.test(value);
        }, object.sender_pattern);
        
        // Custom email pattern for the built-in email validation rule.
        $.validator.methods.email = function( value, element ) {
            return this.optional( element ) || /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test( value );
        };        
        
        // Initialize form validation on the registration form.
        // It has the id "contactform".
        var v = $('#contactform').validate({            
                    
            errorElement: "p",
            rules: {
                // The key name on the left side is the name attribute of an input field.
                // Validation rules are defined on the right side.
                sender: {
                    required: true,
                    // Specify that sender should be validated by the custom sender name pattern defined above.
                    sender: true,
                    rangelength: [2, 30]
                },
                email: {
                    required: true,
                    // Specify that email should be validated by the custom email pattern defined above.
                    email: true,
                    maxlength: 45
                },
                website: {
                    url: true,
                    maxlength: 0
                },
                message: {
                    required: true,
                    maxlength: 500
                }
            },
            // Specify validation error messages.
            messages: {
                sender: {
                    required: object.sender_required,
                    rangelength: object.sender_rangelength
                },
                email: {
                    required : object.email_required,
                    maxlenght : object.email_maxlength
                },
                website: {
                    url: object.website_url,
                    maxlength : object.website_maxlength
                },
                message: {
                    required: object.message_required,
                    maxlength: object.message_maxlength
                }
            },
            // Make sure the form is submitted to the correct destination.
            submitHandler: function(form) {
                var params = $(form).serialize();
                $.ajax({
                    type: 'POST',
                    url: '/wp-admin/admin-ajax.php',
                    data: params + '&action=cleanblog_ajax_sendmail',
                    success: function(success) {
                        $('#success').hide();
                        $('#success').html(success);
                        $('#success').fadeIn('slow', function () {
                            $(this).delay(3000).fadeOut('slow');
                        });
                        // Reset the form fields to empty values.
                        $("#sender").val("");
                        $("#email").val("");
                        $("#message").val("");
                    },
                    error: function() {
                        $('#contactform').fadeTo( "slow", 0.15, function() {
                            $('p').fadeIn();
                        });
                    }
                });
            }
        });
                
        // Programmatically reset above form.
        $("#reset").click(function() {
            v.resetForm();
            $('#success').hide();
        });
        
    });//End contact form validation script with validate.js
});