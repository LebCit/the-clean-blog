<?php
/**
 * The Clean Blog custom functions and definitions.
 *
 * @package The_Clean_Blog
 */

/**
 * Prevent theme activation if WordPress version is less than 4.7 !
 */
function thecleanblog_check_wp_version( $old_theme_name, $old_theme ) {
    
    global $wp_version;
    if ( $wp_version < 4.7 && current_user_can( 'edit_theme_options' ) ) :

      // Info message: Theme not activated
      function thecleanblog_not_activated_admin_notice() {
        echo '<div class="error notice">';
            echo '<h2>';
                esc_html_e( 'Theme not activated: this theme requires at least WordPress Version 4.7 !', 'the-clean-blog' );
            echo '</h2>';
        echo '</div>';
      }
      add_action( 'admin_notices', 'thecleanblog_not_activated_admin_notice' );

      // Switch back to previous theme
      switch_theme( $old_theme->stylesheet );
        return false;

    endif;

}
add_action( 'after_switch_theme', 'thecleanblog_check_wp_version', 10, 2 );

/**
 * Disable output of kirki styles if the plugin is disabled or removed.
 */
if( ! class_exists( 'Kirki' ) ) {
    function thecleanblog_remove_kirki_styles() {
        wp_dequeue_style( 'the-clean-blog_no-kirki' );
        wp_deregister_style( 'the-clean-blog_no-kirki' );
    }
    add_action( 'wp_enqueue_scripts', 'thecleanblog_remove_kirki_styles', 20 );
}

/**
 * Localize hero.js to asynchronously load the header image.
 */
function thecleanblog_header_script() {
    
    // Adding custom javascript file to handle the header image.
    if (is_404() || is_search()) {
        wp_dequeue_script('thecleanblog-hero');
    } else {
        wp_enqueue_script('thecleanblog-hero', get_theme_file_uri('/assets/js/the-clean-blog-hero.js'), array('jquery'), '', true);
    }
    
    // Declare $post global if used outside of the loop.
    $post = get_post();
    // Check if post is object otherwise we're not in singular post.
    if (!is_object($post)) {
        return;
    }
    
    $heroImg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), '');
    $heroImgDefault = get_theme_mod('default_header_background_image');
    if (empty($heroImgDefault)) {
        $heroImgDefault = get_template_directory_uri() . '/components/header/images/default-hero.jpg';
    }
    $heroSettings = array (
        'thecleanblog_hero_ajaxurl'       => esc_url(admin_url('admin-ajax.php')),
        'thecleanblog_has_post_thumbnail' => has_post_thumbnail(),
        'thecleanblog_featured_image'     => esc_url($heroImg[0]),
        'thecleanblog_get_theme_mod'      => $heroImgDefault,
    );
    wp_localize_script('thecleanblog-hero', 'thecleanblog_hero_set', $heroSettings);
}
add_action('wp_enqueue_scripts', 'thecleanblog_header_script');

/**
 * Set background image for the header.
 * PHP falback for the header image. 
 * 
 * Add inline style to the backgroung header image.
 * @link https://developer.wordpress.org/reference/functions/wp_add_inline_style/
 */
function thecleanblog_header_style() {
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
                background-image: url( ' . esc_url($backgroundImg[0]) . ' );
                height: 100vh;
            }
        ';
    } else {
        $custom_header_style = '
            .intro-header {
                background-image: url( ' . get_template_directory_uri() . '/components/header/images/default-hero.jpg' . ' );
                height: 100vh;
            }
        ';
    }
    wp_add_inline_style('thecleanblog-main-style', $custom_header_style);
}
add_action('wp_enqueue_scripts', 'thecleanblog_header_style');
add_action('wp_ajax_thecleanblog_header_style', 'thecleanblog_header_style');
add_action('wp_ajax_nopriv_thecleanblog_header_style', 'thecleanblog_header_style');

/**
 * Provide a fallback menu featuring a 'Home' link, if no other menu has been provided.
 * Add 'Create a new menu' link only if the current_user_can('edit_theme_options').
 */
function thecleanblog_fallback_menu() {
    $html = '<nav class="cb-main-nav-wrapper">';
        $html .= '<ul class="cb-main-nav">';
            $html .= '<li class="menu-item menu-item-type-post_type menu-item-object-page">';
                $html .= '<a href="' . esc_url( home_url() ) . '">';
                    $html .= esc_html__( 'Home', 'the-clean-blog' );
                $html .= '</a>';
            $html .= '</li>';
            if (current_user_can('edit_theme_options')) {
                $html .= '<li class="menu-item menu-item-type-post_type menu-item-object-page">';
                    $html .= '<a href="' . esc_url(admin_url('nav-menus.php?action=edit&menu=0')) . '">';
                        $html .= esc_html__( 'Create a new menu', 'the-clean-blog' );
                    $html .= '</a>';
                $html .= '</li>';
            }
        $html .= '</ul>';
    $html .= '</nav>';
    echo $html; /* WPCS: xss ok. */
}

/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 * 
 * @link https://developer.wordpress.org/reference/functions/get_search_form/#comment-369
 * 
 */
function thecleanblog_search_form( $form ) {
    $form = 
        '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '" >
            <label>
                <span class="screen-reader-text">' . esc_attr__('Search for:', 'the-clean-blog') . '</span>
                <input type="search" class="search-field"
                       placeholder="' . esc_attr__('Search &hellip;', 'the-clean-blog') . '" '
                    . 'value="' . get_search_query() . '" name="s" id="s" required '
                    . 'title="' . esc_attr__('Search for:', 'the-clean-blog') . '" />
            </label>
            <button type="submit" class="search-submit"
                    value="'. esc_attr__('Search', 'the-clean-blog') .'" />
                <i class="icon-search"></i>
            </button>
        </form>';
 
    return $form;
}
add_filter( 'get_search_form', 'thecleanblog_search_form' );

function thecleanblog_header_search_form( $form ) {
    $placeholder = get_theme_mod('dropdown_search_placeholder_text');
    if (empty($placeholder)) {
        $placeholder = esc_html_x('Search &hellip;', 'placeholder', 'the-clean-blog');
    } else {
        $placeholder = esc_attr($placeholder);
    }
    $form = 
        '<form role="search" method="get" class="search-form" action="' . esc_url(home_url('/')) . '" >
            <label>
                <span class="screen-reader-text">' . esc_html_x('Search for:', 'label', 'the-clean-blog') . '</span>
                <input type="search" class="search-field"
                       placeholder="' . $placeholder . '" '
                    . 'value="' . get_search_query() . '" name="s" id="header-search" required '
                    . 'title="' . esc_attr_x('Search for:', 'label', 'the-clean-blog') . '" />
            </label>
            <button type="submit" class="search-submit"
                    value="'. esc_attr_x('Search', 'submit button', 'the-clean-blog') .'" />
                <i class="icon-search"></i>
            </button>
        </form>';
 
    return $form;
}

/**
 * Customizimg the excerpt function.
 *
 * @link https://developer.wordpress.org/reference/functions/the_excerpt/
 */
function thecleanblog_custom_excerpt_length($length)
{
    if ( is_admin() ) {
        return $length;
    } else {
        return 15;
    }
}
add_filter('excerpt_length', 'thecleanblog_custom_excerpt_length', 999);

function thecleanblog_excerpt_more($link) {
    if ( is_admin() ) {
        return $link;
    }

    $link = sprintf(' <a class="read-more" href="%1$s">%2$s</a>',
        esc_url(get_permalink(get_the_ID())),
        /* translators: %s: Name of current post */
        sprintf( __( 'Read More<span class="screen-reader-text"> "%s"</span>', 'the-clean-blog' ), get_the_title( get_the_ID() ) )
    );
    return $link;
}
add_filter('excerpt_more', 'thecleanblog_excerpt_more');

/**
 * Add social sharing icons to posts.
 *
 * Thanks to App Shah
 * @link http://crunchify.com/how-to-create-social-sharing-button-without-any-plugin-and-script-loading-wordpress-speed-optimization-goal/
 */
function thecleanblog_social_sharing_buttons($content) {
    global $post, $variable;
    if(is_single()){

        // Get current post URL.
        $thecleanblogURL = urlencode(get_permalink());

        // Get current post title.
        $thecleanblogTitle = str_replace( ' ', '%20', the_title_attribute('echo=0'));

        // Get Post Thumbnail for pinterest.
        $thecleanblogThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );

        // Construct sharing URL without using any script
        $emailURL = 'mailto:?subject=' . $thecleanblogTitle . '&body=Check out this post: '. $thecleanblogURL;
        $twitterURL = 'https://twitter.com/intent/tweet?text='.$thecleanblogTitle.'&amp;url='.$thecleanblogURL;
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$thecleanblogURL;
        $googleURL = 'https://plus.google.com/share?url='.$thecleanblogURL;
        $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$thecleanblogURL.'&amp;media='.$thecleanblogThumbnail[0].'&amp;description='.$thecleanblogTitle;
        $whatsappURL = 'whatsapp://send?text='.$thecleanblogTitle . ' ' . $thecleanblogURL;        

        // Add sharing button at the end of post's content.
        $variable .= '<div class="panel-footer">';
        $variable .= '<ul class="social-network social-circle">';
        $variable .= '<li><span>' . esc_html__('SHARE :', 'the-clean-blog') . '</span></li>';
        $variable .= '<li><a class="thecleanblog-email" href="'.$emailURL.'" target="_blank"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>';
        $variable .= '<li><a class="thecleanblog-twitter" href="'. $twitterURL .'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>';
        $variable .= '<li><a class="thecleanblog-facebook" href="'.$facebookURL.'" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>';        
        $variable .= '<li><a class="thecleanblog-googleplus" href="'.$googleURL.'" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>';        
        $variable .= '<li><a class="thecleanblog-pinterest" href="'.$pinterestURL.'" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>';
        $variable .= '<li><a class="thecleanblog-whatsapp" href="'.$whatsappURL.'" target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a></li>';
        $variable .= '</ul>';
        $variable .= '</div>';

        return $content.$variable;
    }else{
        // if not a post/page then don't include sharing button
        return $content;
    }
}
add_filter( 'the_content', 'thecleanblog_social_sharing_buttons');

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
function thecleanblog_comment_textarea_placeholder($args)
{
    $args['comment_field'] = str_replace('textarea', 'textarea placeholder="' . esc_attr__('Comment', 'the-clean-blog') .'" class="form-control"', $args['comment_field']);
    return $args;
}
add_filter('comment_form_defaults', 'thecleanblog_comment_textarea_placeholder');

/**
 * Comment Form Fields Placeholder.
 */
function thecleanblog_comment_form_fields($fields)
{
    unset($fields['url']);
    foreach ($fields as &$field) {
        $field = str_replace('id="author"', 'id="author" class="form-control" placeholder="' . esc_attr__('Name *', 'the-clean-blog') . '"', $field);
        $field = str_replace('id="email"', 'id="email" class="form-control" placeholder="' . esc_attr__('Email *', 'the-clean-blog') . '"', $field);
    }
    return $fields;
}
add_filter('comment_form_default_fields', 'thecleanblog_comment_form_fields');

/**
 * Editing wp_list_comments() output.
 *
 * Thanks to Bruno Kos
 * @link http://bbird.me/editing-wp_list_comments-output/
 */
function thecleanblog_comments($comment, $depth, $args)
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
 * Enable Social Icons Customizer.
 *
 * Thanks to Aaron
 * @link http://justkeeplearning.xyz/theme-customizer/how-to-enable-social-icons-in-the-wordpress-theme-customizer/
 */

/**
 * Create and return an array containing the names of the social sites.
 */
function thecleanblog_social_media()
{

    /* store social site names in array */
    $social_sites = array(
        'email'         => 'thecleanblog_email',
        'twitter'       => 'thecleanblog_twitter',
        'facebook'      => 'thecleanblog_facebook',
        'github'        => 'thecleanblog_github',
        'instagram'     => 'thecleanblog_instagram',
        'youtube'       => 'thecleanblog_youtube',
        'google-plus'   => 'thecleanblog_googleplus',
        'flickr'        => 'thecleanblog_flickr',
        'pinterest'     => 'thecleanblog_pinterest',
        'tumblr'        => 'thecleanblog_tumblr',
        'dribbble'      => 'thecleanblog_dribbble',
        'linkedin'      => 'thecleanblog_linkedin',
        'rss'           => 'thecleanblog_rss'
    );
    
    // Filtering the function, allowing user(s) to add more social sites in child theme.
    return apply_filters( 'thecleanblog_social_media', $social_sites );
}

/**
 * Add settings to create various social media text areas in the Customizer.
 */
function thecleanblog_social_sites($wp_customize)
{
    // Section
    $wp_customize->add_section('thecleanblog_social_settings', array(
        'title' => __('Social Media Icons', 'the-clean-blog'),
        'priority' => 30,
        'active_callback' => 'is_front_page',
    ));

    $social_sites = thecleanblog_social_media();
    $priority = 5;

    // Create a setting and control for each social site.
    foreach ($social_sites as $social_site => $value) {

        if ( $social_site == 'email' ) {
            $label = esc_attr__('Email URL', 'the-clean-blog');
        } elseif ( $social_site == 'twitter' ) {
            $label = esc_attr__('Twitter URL', 'the-clean-blog');
        } elseif ( $social_site == 'facebook' ) {
            $label = esc_attr__('Facebook URL', 'the-clean-blog');
        } elseif ( $social_site == 'github' ) {
            $label = esc_attr__('GitHub URL', 'the-clean-blog');
        } elseif ( $social_site == 'instagram' ) {
            $label = esc_attr__('Instagram URL', 'the-clean-blog');
        } elseif ( $social_site == 'youtube' ) {
            $label = esc_attr__('YouTube URL', 'the-clean-blog');
        } elseif ( $social_site == 'google-plus' ) {
            $label = esc_attr__('Google Plus URL', 'the-clean-blog');
        } elseif ( $social_site == 'flickr' ) {
            $label = esc_attr__('Flickr URL', 'the-clean-blog');
        } elseif ( $social_site == 'pinterest' ) {
            $label = esc_attr__('Pinterest URL', 'the-clean-blog');
        } elseif ( $social_site == 'tumblr' ) {
            $label = esc_attr__('Tumblr URL', 'the-clean-blog');
        } elseif ( $social_site == 'dribbble' ) {
            $label = esc_attr__('Dribble URL', 'the-clean-blog');
        } elseif ( $social_site == 'linkedin' ) {
            $label = esc_attr__('LinkedIn URL', 'the-clean-blog');
        } elseif ( $social_site == 'rss' ) {
            $label = esc_attr__('RSS URL', 'the-clean-blog');
        }
        
        // Setting
        $wp_customize->add_setting($social_site, array(
            'type' => 'theme_mod',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw'
        ));

        // Control
        $wp_customize->add_control($social_site, array(
            'type' => 'text',
            'label' => $label,
            'section' => 'thecleanblog_social_settings',
            'priority' => $priority,
        ));

        $priority = $priority + 5;
    }
}
add_action('customize_register', 'thecleanblog_social_sites');

/**
 * Get user input from the Customizer and output the linked social media icons.
 */
function thecleanblog_social_media_icons()
{
    $social_sites = thecleanblog_social_media();

    /* any inputs that aren't empty are stored in $active_sites array */
    foreach ($social_sites as $social_site => $profile) {
        if (strlen(get_theme_mod($social_site)) > 0) {
            $active_sites[] = $social_site;
        }
    }

    /* for each active social site, add it as a list item */
    if (!empty($active_sites)) {
        echo "<ul class='list-inline text-center'>";

        foreach ($active_sites as $key => $active_site) {

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
function thecleanblog_copyright_date()
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

/**
 * Hooking in JS code to affect the controls in the customizer.
 */
function thecleanblog_customizer_controls() {
    wp_enqueue_script( 'thecleanblog-customizer-controls', get_template_directory_uri() . '/assets/js/the-clean-blog-customizer.js', array( 'jquery', 'customize-controls' ), false, true );
    $customizerSettings = array (
        'thecleanblog_control_placeholder' => esc_html__( 'Replace Default Text', 'the-clean-blog' ),
    );
    wp_localize_script('thecleanblog-customizer-controls', 'thecleanblog_customizer_set', $customizerSettings);
}
add_action( 'customize_controls_enqueue_scripts', 'thecleanblog_customizer_controls' );