<?php
/**
 * Clean Blog custom functions and definitions.
 *
 * @package The_Clean_Blog
 */

/**
 * Set background image for the header.
 * 
 * Add inline style to the backgroung header image.
 * @link https://developer.wordpress.org/reference/functions/wp_add_inline_style/
 */
function cleanblog_header_style() {
    // Declare $post global if used outside of the loop.
    $post = get_post();
    // Check if post is object otherwise we're not in singular post.
    if (!is_object($post)) {
        return;
    }
    // If Object
    $backgroundImg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '');
    // Add inline style to the backgroung header image.
    if (has_post_thumbnail()) {
        $custom_header_style = '
            .intro-header {
                background-image: url( ' . $backgroundImg[0] . ' );
            }
        ';
    } else {
        $custom_header_style = '
            .intro-header {
                background-image: url( ' . get_template_directory_uri() . '/components/header/images/default-hero.jpg' . ' );
            }
        ';
    }
    wp_add_inline_style( 'cleanblog-main-style', $custom_header_style );
}
add_action( 'wp_enqueue_scripts', 'cleanblog_header_style' );

/**
 * Add Subtitle in admin post.
 *
 * @param WP_Post $post Post object.
 *
 * @return void
 *
 * @link https://codepad.co/snippet/UrzTcQId
 */
function unprefix_subtitle($post)
{
    if (!in_array($post->post_type, [ 'post', 'page'], true)) {
        return;
    }

    // The subtitle field.
    $_stitle = sanitize_text_field(get_post_meta($post->ID, '_unprefix_subtitle', true));

    echo '<label class="screen-reader-text" for="unprefix_subtitle">' . esc_html__('Enter subtitle here', 'the-clean-blog') . '</label>';
    echo '<input style="width:50%;" type="text" name="unprefix_subtitle" id="unprefix_subtitle" value="' . esc_attr($_stitle) . '" size="30" spellcheck="true" autocomplete="off" placeholder="Enter subtitle here" maxlength="45" />';
}

/**
 * Save Subtitle
 *
 * @param int     $post_ID Post ID.
 * @param WP_Post $post    Post object.
 * @param bool    $update  Whether this is an existing post being updated or not.
 *
 * @return void
 */
function unprefix_save_subtitle($post_ID, $post, $update)
{
    if (!in_array($post->post_type, [ 'post', 'page'], true)) {
        return;
    }

    // Prevent to execute twice.
    if (defined('DOING_AJAX') && DOING_AJAX) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Get the subtitle value from $_POST.
    $_stitle = filter_input(INPUT_POST, 'unprefix_subtitle', FILTER_SANITIZE_STRING);

    if ($update) {
        // Update the post meta.
        update_post_meta($post_ID, '_unprefix_subtitle', sanitize_text_field($_stitle));
    } elseif (!empty($_stitle)) {
        // Add unique post meta.
        add_post_meta($post_ID, '_unprefix_subtitle', sanitize_text_field($_stitle), true);
    }
}
add_action('edit_form_after_title', 'unprefix_subtitle', 20);
add_action('wp_insert_post', 'unprefix_save_subtitle', 20, 3);

/**
 * Customizimg the excerpt function.
 *
 * @link https://developer.wordpress.org/reference/functions/the_excerpt/
 */
function cleanblog_custom_excerpt_length($length)
{
    return 15;
}
add_filter('excerpt_length', 'cleanblog_custom_excerpt_length', 999);

function cleanblog_excerpt_more($more)
{
    return sprintf(' <a class="read-more" href="%1$s">%2$s</a>', get_permalink(get_the_ID()), __('Read More', 'the-clean-blog')
    );
}
add_filter('excerpt_more', 'cleanblog_excerpt_more');
/**
 * Remove p tag arround the excerpt function.
 *
 * @link https://codex.wordpress.org/Function_Reference/wpautop
 */
remove_filter( 'the_excerpt', 'wpautop' );

/**
 * Add social sharing icons to posts.
 *
 * Thanks to App Shah
 * @link http://crunchify.com/how-to-create-social-sharing-button-without-any-plugin-and-script-loading-wordpress-speed-optimization-goal/
 */
function cleanblog_social_sharing_buttons($content) {
    global $post, $variable;
    if(is_single()){

        // Get current post URL.
        $cleanblogURL = urlencode(get_permalink());

        // Get current post title.
        $cleanblogTitle = str_replace( ' ', '%20', get_the_title());

        // Get Post Thumbnail for pinterest.
        $cleanblogThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

        // Construct sharing URL without using any script
        $emailURL = 'mailto:?subject=' . $cleanblogTitle . '&body=Check out this post: '. $cleanblogURL;
        $twitterURL = 'https://twitter.com/intent/tweet?text='.$cleanblogTitle.'&amp;url='.$cleanblogURL;
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$cleanblogURL;
        $googleURL = 'https://plus.google.com/share?url='.$cleanblogURL;
        $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$cleanblogURL.'&amp;media='.$cleanblogThumbnail[0].'&amp;description='.$cleanblogTitle;
        $whatsappURL = 'whatsapp://send?text='.$cleanblogTitle . ' ' . $cleanblogURL;        

        // Add sharing button at the end of post's content.
        $variable .= '<div class="panel-footer">';
        $variable .= '<ul class="social-network social-circle">';
        $variable .= '<li><span>SHARE :</span></li>';
        $variable .= '<li><a class="cleanblog-email" href="'.$emailURL.'" target="_blank"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>';
        $variable .= '<li><a class="cleanblog-twitter" href="'. $twitterURL .'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
        $variable .= '<li><a class="cleanblog-facebook" href="'.$facebookURL.'" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';        
        $variable .= '<li><a class="cleanblog-googleplus" href="'.$googleURL.'" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>';        
        $variable .= '<li><a class="cleanblog-pinterest" href="'.$pinterestURL.'" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>';
        $variable .= '<li><a class="cleanblog-whatsapp" href="'.$whatsappURL.'" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>';
        $variable .= '</ul>';
        $variable .= '</div>';

        return $content.$variable;
    }else{
        // if not a post/page then don't include sharing button
        return $content;
    }
}
add_filter( 'the_content', 'cleanblog_social_sharing_buttons');

/**
 * Use placeholders instead of labels in comment form.
 *
 * Thanks to Bill Erickson
 * @link http://www.billerickson.net/code/use-placeholders-instead-of-labels-in-comment-form/
 *
 */

/**
 * Change comment form textarea to use placeholder.
 */
function cleanblog_comment_textarea_placeholder($args)
{
    $args['comment_field'] = str_replace('textarea', 'textarea placeholder="Comment" class="form-control"', $args['comment_field']);
    return $args;
}
add_filter('comment_form_defaults', 'cleanblog_comment_textarea_placeholder');

/**
 * Comment Form Fields Placeholder.
 */
function cleanblog_comment_form_fields($fields)
{
    unset($fields['url']);
    foreach ($fields as &$field) {
        $field = str_replace('id="author"', 'id="author" class="form-control" placeholder="Name *"', $field);
        $field = str_replace('id="email"', 'id="email" class="form-control" placeholder="Email *"', $field);
    }
    return $fields;
}
add_filter('comment_form_default_fields', 'cleanblog_comment_form_fields');

/**
 * Editing wp_list_comments() output.
 *
 * Thanks to Bruno Kos
 * @link http://bbird.me/editing-wp_list_comments-output/
 */
function cleanblog_comments($comment, $depth, $args)
{
    $tag = ('div' === $args['style']) ? 'div' : 'li'; ?>
<?php echo esc_attr($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($this->has_children ? 'parent' : '', $comment); ?>>
    <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <footer class="comment-meta">
            <div class="comment-author vcard">
                <?php
                if (0 != $args['avatar_size']) {
                    echo get_avatar($comment, $args['avatar_size']);
                } ?>
                <?php
                /* translators: %s: comment author link */
                printf(esc_html__('%s <span class="says">says:</span>', 'the-clean-blog'), sprintf('<b class="fn">%s</b>', get_comment_author_link($comment))
                ); ?>
            </div><!-- .comment-author -->

            <div class="comment-metadata">
                <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                    <time datetime="<?php comment_time('c'); ?>">
                        <?php
                        /* translators: 1: comment date, 2: comment time */
                        printf(esc_attr__('%1$s at %2$s', 'the-clean-blog'), get_comment_date('', $comment), get_comment_time()); ?>
                    </time>
                </a>
                <?php edit_comment_link(__('Edit', 'the-clean-blog'), '<span class="edit-link">', '</span>'); ?>
            </div><!-- .comment-metadata -->

            <?php if ('0' == $comment->comment_approved) : ?>
                <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'the-clean-blog'); ?></p>
            <?php endif; ?>
        </footer><!-- .comment-meta -->

        <div class="comment-content">
            <?php comment_text(); ?>
        </div><!-- .comment-content -->

        <?php
        comment_reply_link(array_merge($args, array(
            'add_below' => 'div-comment',
            'depth' => $depth,
            'max_depth' => $args['max_depth'],
            'before' => '<div class="reply">',
            'after' => '</div>'
        ))); ?>
    </article><!-- .comment-body -->
    <?php

}

/**
 * Localize contact form script to translate it's strings.
 * 
 * @link https://codex.wordpress.org/I18n_for_WordPress_Developers
 */
function cleanblog_contact_form_script() {
    // Fires only if we are on the Contact Form Template.
    if ( is_page_template( 'page-contact.php' ) ) {
        // Adding jQuery Validation Plugin.
        wp_enqueue_script('cleanblog-validate', get_theme_file_uri() . '/assets/js/jquery.validate.min.js', array('jquery'), '1.15.0', true);
        
        // Adding custom javascript contact form file to theme.
        wp_enqueue_script('contact_form_script', get_template_directory_uri().'/assets/js/contact-form.js', array('jquery', 'cleanblog-validate'));

        // Create array with values that are going to be used in Javascript file itself
        $translations = array(
            'sender_required'    => __('Please enter your Name.', 'the-clean-blog'),
            'sender_rangelength' => __('Your Name must be 2 to 30 characters long !', 'the-clean-blog'),
            'sender_pattern'     => __('Your Name can only contain _, 1-9, A-Z or a-z and 2 to 20 characters long !', 'the-clean-blog'),
            'email_required'     => __('Please enter a valid email address !', 'the-clean-blog'),
            'email_maxlength'    => __('Email address should not exceed 45 Charachters !', 'the-clean-blog'),
            'website_url'        => __('Please enter a valid website url !', 'the-clean-blog'),
            'website_maxlength'  => __('HO HO HO ! JS GOT YOU ! THANKS FOR TRYING !', 'the-clean-blog'),
            'message_required'   => __('Please enter your message.', 'the-clean-blog'),
            'message_maxlength'  => __('Your message should not exceed 500 characters !', 'the-clean-blog')
        );
        wp_localize_script('contact_form_script', 'object', $translations);
    }
}
add_action('wp_enqueue_scripts', 'cleanblog_contact_form_script');

/* 
 * Create the Clean_Blog_Contact_Form_Handler class.
 * Please note that the original class from the link below has been heavily modified.
 * Ajaxify contact form to all users.
 * 
 * Thanks to WP Knowledge Base
 * @link https://www.wpkb.com/how-to-code-your-own-wordpress-contact-form-with-jquery-validation/
 */
add_action('wp_ajax_cleanblog_ajax_sendmail', 'cleanblog_contact_form_class');
add_action('wp_ajax_nopriv_cleanblog_ajax_sendmail', 'cleanblog_contact_form_class');
function cleanblog_contact_form_class() {
    class Clean_Blog_Contact_Form_Handler {

        function cleanblog_handle_form() {
            // Check if the form is submitted && verify the Nonce set.
            if($this->cleanblog_is_form_submitted() && $this->cleanblog_is_nonce_set()) {
                // If form is submitted and Nonce set, validate form's fields.
                if($this->cleanblog_is_form_valid()) {
                    // If form's fields are valide, send the message.
                    $this->cleanblog_send_contact_form_message();
                } else { // If form's fields are not valid, display the form.
                    $this->cleanblog_display_form();
                }
            } else { // If the form is not submitted &&/|| the Nonce set not verified, display the form.
                $this->cleanblog_display_form();
            }
        }

        function cleanblog_is_form_submitted() {
            if(isset($_POST['submitted'])) {
                return true;
            } else {
                return false;
            }
        }

        function cleanblog_is_nonce_set() {
            if(isset( $_POST['submit_contact_form_nonce_field'])  &&
                wp_verify_nonce(sanitize_key($_POST['submit_contact_form_nonce_field']), 'submit_contact_form_action')) {
                    return true;
            } else{
                return false;
            }
        }

        function cleanblog_is_form_valid() {

            // Initialize error array!
            $errors = array();

            // Check all mandatory fields are present.
            // Check for a proper Name.
            if (!empty($_POST['sender'])) {
                global $sender;
                $sender = sanitize_text_field(wp_unslash($_POST['sender']));
                $sender_pattern = "/^[a-zA-Z0-9\_]{2,20}/";// Regular expression that checks if the name is valid characters
                if (preg_match($sender_pattern,$sender)) {
                    $sender = $sender;
                } else {
                    $errors[] = esc_html__('Your Name can only contain _, 1-9, A-Z or a-z and 2 to 20 characters long !', 'the-clean-blog');
                }
            } else {
                $errors[] = esc_html__('You forgot to enter your Name.', 'the-clean-blog');
            }

            // Check for a proper Email.
            if (!empty($_POST['email'])) {
                global $email;
                $email = sanitize_email(wp_unslash($_POST['email']));
                if (is_email($email)) { // Validate email.
                    $email = $email;
                } else {
                    $errors[] = esc_html__('Please, enter a valid email address !', 'the-clean-blog');
                }
            } else {
                $errors[] = esc_html__('You forgot to enter your email address.', 'the-clean-blog');
            }

            // Make sure the website field is empty !
            if (!empty($_POST['website'])) {
                $website = esc_url_raw(wp_unslash($_POST['website']));
                if (filter_var($website, FILTER_VALIDATE_URL) === false) { // Invalid URL.
                    $errors[] = esc_html__('Please enter a valid URL.', 'the-clean-blog');
                } else { // Valid URL.
                    $errors[] = esc_html__('HO HO HO ! PHP GOT YOU ! THANKS FOR TRYING !', 'the-clean-blog');
                }
            }

            // Validate the textarea message.
            global $message;
            if (!empty($_POST['message'])) {               
                $message = sanitize_text_field(wp_unslash($_POST['message']));
                if (strlen($message) > 500) {
                    $errors[] = esc_html__('Your message should not exceed 500 characters !', 'the-clean-blog');
                }
            } else {
                $errors[] = esc_html__('You forgot to enter your message.', 'the-clean-blog');
            }
            // End of validation!

            // Check if any error was detected in validation and print error(s) or success message(s).
            // Print any error message.
            if (!empty($errors)) {
                echo '<hr><h3>' . esc_html__('The following occurred:', 'the-clean-blog') . '</h3><ul>';
                // Print each error.
                foreach ($errors as $error) {
                    echo '<li>'. esc_html($error) . '</li>';
                }
                echo '</ul><h3>' . esc_html__('Your mail could not be sent due to input errors.', 'the-clean-blog') . '</h3><hr>';
                return false;
            } else {
                    echo '<div class="panel-success"><hr><h3 align="center">' . esc_html__('Your mail was sent. Thank you for contacting us !', 'the-clean-blog') . '</h3><hr></div>';
            }
            // End of errors array !

            return true;
        }

        public function cleanblog_send_contact_form_message() {
            if (empty($errors) && empty($website)) {
                // If the form is submitted and no error found && website field is empty, send email.                
                global $sender;
                global $email;
                global $message;
                // Email information.
                $to = get_option( 'admin_email');
                $subject = 'From: ' .$sender . ' / ' . $email;

                // Send email.
                var_dump($success = wp_mail($to, $subject, $message));
                wp_die();
            }
        }

        //This function displays the Contact form.
        public function cleanblog_display_form() {

        ?>
        <form method="post" action="" enctype="multipart/form-data" name="contactform" id="contactform" autocomplete="off">
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Name</label>
                    <input name="sender" type="text" class="form-control" placeholder="Name" id="sender" required>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Email Address</label>
                    <input name="email" type="email" class="form-control" placeholder="Email Address" id="email" required>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Website URL</label>
                    <input name="website" type="url" class="form-control" placeholder="Website URL" id="website" tabindex="-1" autocomplete="nope">
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <div class="row control-group">
                <div class="form-group col-xs-12 floating-label-form-group controls">
                    <label>Message</label>
                    <textarea name="message" rows="5" class="form-control" placeholder="Message" id="message" required></textarea>
                    <p class="help-block text-danger"></p>
                </div>
            </div>
            <br>
            <div id="success" class="success-div"></div>
            <div class="row">
                <div class="form-group col-xs-12">
                    <button type="submit" name="submitted" class="btn btn-default">Send</button>
                    <button type="reset" value="Reset" class="btn btn-default" id="reset">Reset</button>
                </div>
            </div>
            <?php wp_nonce_field( 'submit_contact_form_action' , 'submit_contact_form_nonce_field'); ?>
        </form>

        <?php
        }
    }
    
    $cleanblog_contact_form_obj = new Clean_Blog_Contact_Form_Handler();
    $cleanblog_contact_form_obj -> cleanblog_handle_form();
}

/**
 * Enable Social Icons Customizer.
 *
 * Thanks to Aaron
 * @link http://justkeeplearning.xyz/theme-customizer/how-to-enable-social-icons-in-the-wordpress-theme-customizer/
 */

/**
 * Create and return an array containing the names of the social sites.
 */
function cleanblog_social_media()
{

    /* store social site names in array */
    $social_sites = array('email', 'twitter', 'facebook', 'github', 'instagram', 'youtube', 'google-plus', 'flickr', 'pinterest', 'tumblr', 'dribbble', 'linkedin', 'rss');

    return $social_sites;
}

/**
 * Add settings to create various social media text areas.
 */
function cleanblog_social_sites($wp_customize)
{
    $wp_customize->add_section('cleanblog_social_settings', array(
        'title' => __('Social Media Icons', 'the-clean-blog'),
        'priority' => 30,
        'active_callback' => 'is_front_page',
    ));

    $social_sites = cleanblog_social_media();
    $priority = 5;

    foreach ($social_sites as $social_site) {
        $wp_customize->add_setting("$social_site", array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw'
        ));

        $wp_customize->add_control($social_site, array(
            'label' => ucwords(esc_attr("$social_site URL:", 'social_icon')),
            'section' => 'cleanblog_social_settings',
            'type' => 'text',
            'priority' => $priority,
        ));

        $priority = $priority + 5;
    }
}
add_action('customize_register', 'cleanblog_social_sites');

/**
 * Get user input from the Customizer and output the linked social media icons.
 */
function cleanblog_social_media_icons()
{
    $social_sites = cleanblog_social_media();

    /* any inputs that aren't empty are stored in $active_sites array */
    foreach ($social_sites as $social_site) {
        if (strlen(get_theme_mod($social_site)) > 0) {
            $active_sites[] = $social_site;
        }
    }

    /* for each active social site, add it as a list item */
    if (!empty($active_sites)) {
        echo "<ul class='list-inline text-center'>";

        foreach ($active_sites as $active_site) {

            /* setup the class */
            $class = 'fa fa-' . $active_site . ' fa-stack-1x fa-inverse';

            if ($active_site == 'email') {
                ?>
                <li>
                    <a class="email" target="_blank" href="mailto:<?php echo esc_attr(antispambot(is_email(get_theme_mod($active_site)))); ?>">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-envelope fa-stack-1x fa-inverse" title="<?php esc_attr_e('email icon', 'the-clean-blog'); ?>"></i>
                        </span>
                    </a>
                </li>
                <?php

            } else {
                ?>
                <li>
                    <a class="<?php echo esc_attr($active_site); ?>" target="_blank" href="<?php echo esc_url(get_theme_mod($active_site)); ?>">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="<?php echo esc_attr($class); ?>" title="<?php printf(esc_attr__('%s icon', 'the-clean-blog'), esc_attr($active_site)); ?>"></i>
                        </span>                            
                    </a>
                </li>
                <?php

            }
        }
        echo "</ul>";
    }
}

/**
 * Add copyright date from first post date to last post date.
 *
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-add-a-dynamic-copyright-date-in-wordpress-footer/
 */
function cleanblog_copyright_date()
{
    global $wpdb;
    $copyright_dates = $wpdb->get_results("
    SELECT
    YEAR(min(post_date_gmt)) AS firstdate,
    YEAR(max(post_date_gmt)) AS lastdate
    FROM
    $wpdb->posts
    WHERE
    post_status = 'publish'
    ");
    $output = '';
    if ($copyright_dates) {
        $copyright = "Copyright &copy; " . get_bloginfo('name') . ' : ' . $copyright_dates[0]->firstdate;
        if ($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
            $copyright .= '-' . $copyright_dates[0]->lastdate;
        }
        $output = $copyright;
    }
    return $output;
}