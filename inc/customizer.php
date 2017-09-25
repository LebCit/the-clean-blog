<?php
/**
 * The Clean Blog Theme Customizer.
 *
 * @package The_Clean_Blog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function thecleanblog_customize_register($wp_customize)
{
    $wp_customize->get_section('background_image')->title = __( 'Background Image/Color', 'the-clean-blog' );
    $wp_customize->remove_section( 'colors' );
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_control( 'background_color'  )->section   = 'background_image';
}
add_action('customize_register', 'thecleanblog_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function thecleanblog_customize_preview_js()
{
    wp_enqueue_script('thecleanblog_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), '20151215', true);
}
add_action('customize_preview_init', 'thecleanblog_customize_preview_js');

/**
 * Ensuring that all CSS & fonts will work if the plugin is not installed or removed.
 */
The_Clean_Blog_Kirki::add_config( 'thecleanblog', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'theme_mod',
) );

/**
 * The Clean Blog Customizer options.
 */

// The Clean Blog Theme Panel
The_Clean_Blog_Kirki::add_panel( 'thecleanblog_theme', array(
    'priority'    => 10,
    'title'       => __( 'The Clean Blog Theme', 'the-clean-blog' ),
    'description' => __( 'Customize The Clean Blog Theme', 'the-clean-blog' ),
) );

// 1- Menu Colors Section - DESKTOP
The_Clean_Blog_Kirki::add_section( 'menu-colors', array(
    'title'          => __( 'DESKTOP Menu Colors', 'the-clean-blog' ),
    'description'    => __( 'Change DESKTOP Menu Colors', 'the-clean-blog' ),
    'panel'          => 'thecleanblog_theme',
    'priority'       => 5,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

// 1.1- Menu Background Color - DESKTOP
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'menu_background_color',
    'label' => __('Menu Background Color', 'the-clean-blog'),
    'section' => 'menu-colors',
    'default' => '#33414a',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                'header.cb-nav',
                'header.cb-nav.is-fixed.is-visible',
            ),
            'property' => 'background-color',
            'media_query' => '@media (min-width: 1024px)',
        ),
        array(
            'element' => 'header.cb-nav.is-fixed.is-visible',
            'property' => 'border-bottom',
            'media_query' => '@media (min-width: 1024px)',
        ),
    ),
));

// 1.2- Menu Links Color - DESKTOP
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'menu_links_color',
    'label' => __('Menu Links Color', 'the-clean-blog'),
    'section' => 'menu-colors',
    'default' => '#fff',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.cb-main-nav a',
            'property' => 'color',
            'suffix' => '!important', // Added important to override default in style.css
            'media_query' => '@media (min-width: 1024px)',
        ),
        array(
            'element' => array(
                '.cb-main-nav .cb-subnav-trigger::before',
                '.cb-main-nav .cb-subnav-trigger::after',
            ),
            'property' => 'background-color',
            'media_query' => '@media (min-width: 1024px)',
        ),
    ),
));

// 1.3- Selected Link Arrow Color - DESKTOP
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'selected_link_arrow_color',
    'label' => __('Selected Link Arrow Color', 'the-clean-blog'),
    'section' => 'menu-colors',
    'default' => '#0085A1',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                // Added .selected to style only the selected <li>'s arrow/close
                '.cb-main-nav .selected .cb-subnav-trigger::before',
                '.cb-main-nav .selected .cb-subnav-trigger::after',
            ),
            'property' => 'background-color',
            'media_query' => '@media (min-width: 1024px)',
        ),
    ),
));

// 1.4- Sub Menu Background Color - DESKTOP
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'sub_menu_background_color',
    'label' => __('Sub Menu Background Color', 'the-clean-blog'),
    'section' => 'menu-colors',
    'default' => '#405060',
    'priority' => 20,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.cb-main-nav li ul',
            'property' => 'background-color',
            'media_query' => '@media (min-width: 1024px)',
        ),
    ),
    'active_callback' => '@media (min-width: 1024px)',
));

// 1.5- Sub Menu Links Color - DESKTOP
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'sub_menu_links_color',
    'label' => __('Sub Menu Links Color', 'the-clean-blog'),
    'section' => 'menu-colors',
    'default' => '#fff',
    'priority' => 25,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.sub-menu a',
            'property' => 'color',
            'suffix' => '!important', // Added important to override default in style.css
            'media_query' => '@media (min-width: 1024px)',
        ),
    ),
));

// 2- Menu Colors Section - MOBILE
The_Clean_Blog_Kirki::add_section( 'mobile-menu-colors', array(
    'title'          => __( 'MOBILE Menu Colors', 'the-clean-blog' ),
    'description'    => __( 'Change MOBILE Menu Colors', 'the-clean-blog' ),
    'panel'          => 'thecleanblog_theme',
    'priority'       => 10,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

// 2.1- Menu Bar Background Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'mobile_menu_bar_background_color',
    'label' => __('Menu Bar Background Color', 'the-clean-blog'),
    'section' => 'mobile-menu-colors',
    'default' => '#33414a',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => 'header.cb-nav',
            'property' => 'background-color',
            'media_query' => '@media (max-width: 1023px)',
        ),
    ),
));

// 2.2- Menu Trigger Background Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'mobile_menu_trigger_background_color',
    'label' => __('Menu Trigger Background Color', 'the-clean-blog'),
    'section' => 'mobile-menu-colors',
    'default' => '#fff',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '.cb-nav-trigger span',
                '.cb-nav-trigger span:before',
                '.cb-nav-trigger span:after',
            ),
            'property' => 'background-color',
            'media_query' => '@media (max-width: 1023px)',
        ),
    ),
));

// 2.3- Mobile Menu Background Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'mobile_menu_background_color',
    'label' => __('Mobile Menu Background Color', 'the-clean-blog'),
    'section' => 'mobile-menu-colors',
    'default' => '#1e262c',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.cb-main-nav',
            'property' => 'background',
            'media_query' => '@media (max-width: 1023px)',
        ),
    ),
));

// 2.4- Mobile Menu Links Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'mobile_menu_links_color',
    'label' => __('Mobile Menu Links Color', 'the-clean-blog'),
    'section' => 'mobile-menu-colors',
    'default' => '#fff',
    'priority' => 20,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.cb-main-nav a',
            'property' => 'color',
            'suffix' => '!important', // Added important to override default in style.css
            'media_query' => '@media (max-width: 1023px)',
        ),
        array(
            'element' => array(
                '.cb-main-nav .cb-subnav-trigger::before',
                '.cb-main-nav .cb-subnav-trigger::after',
            ),
            'property' => 'background-color',
            'media_query' => '@media (max-width: 1023px)',
        ),
    ),
));

// 2.5- Mobile Sub Menu Background Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'mobile_sub_menu_background_color',
    'label' => __('Mobile Sub Menu Background Color', 'the-clean-blog'),
    'section' => 'mobile-menu-colors',
    'default' => '#1e262c',
    'priority' => 25,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.cb-main-nav.moves-out',
            'property' => 'background',
            'media_query' => '@media (max-width: 1023px)',
        ),
    ),
));

// 2.6- Sub Menu Links Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'mobile_sub_menu_links_color',
    'label' => __('Sub Menu Links Color', 'the-clean-blog'),
    'section' => 'mobile-menu-colors',
    'default' => '#fff',
    'priority' => 30,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.sub-menu a',
            'property' => 'color',
            'suffix' => '!important', // Added important to override default in style.css
            'media_query' => '@media (max-width: 1023px)',
        ),
    ),
));

// 2.7- Sub Menu Go Back Arrow Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'mobile_sub_menugo-back_arrow_color',
    'label' => __('Sub Menu Go Back Arrow Color', 'the-clean-blog'),
    'section' => 'mobile-menu-colors',
    'default' => '#485c68',
    'priority' => 35,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '.cb-main-nav .go-back a::before',
                '.cb-main-nav .go-back a::after',
            ),
            'property' => 'background',
            'media_query' => '@media (max-width: 1023px)',
        ),
    ),
));

// 3- Search Icon and Dropdown Section
The_Clean_Blog_Kirki::add_section( 'search-icon-and-dropdown-colors', array(
    'title'          => __( 'Search Icon and Dropdown Colors', 'the-clean-blog' ),
    'description'    => __( 'Change Search Icon and Dropdown Colors', 'the-clean-blog' ),
    'panel'          => 'thecleanblog_theme',
    'priority'       => 15,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

// 3.1- Search Icon Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'search_icon_color',
    'label' => __('Search Icon Color', 'the-clean-blog'),
    'section' => 'search-icon-and-dropdown-colors',
    'default' => '#fff',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                'li.search-trigger',
                'button.search-trigger',
            ),
            'property' => 'color',
        ),
    ),
));

// 3.2- Search Icon Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'search_icon_hover_color',
    'label' => __('Search Icon Hover Color', 'the-clean-blog'),
    'section' => 'search-icon-and-dropdown-colors',
    'default' => '#d03b39',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                'li.search-trigger:hover',
                'button.search-trigger:hover',
            ),
            'property' => 'color',
        ),
    ),
));

// 3.3- Dropdown Search Background Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'dropdown_search_background_color',
    'label' => __('Dropdown Search Background Color', 'the-clean-blog'),
    'section' => 'search-icon-and-dropdown-colors',
    'default' => '#486B82',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '.search-dropdown',
                '.search-dropdown input#s',
            ),
            'property' => 'background',
        ),
    ),
));

// 3.4- Dropdown Search Placeholder Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'dropdown_search_placeholder_color',
    'label' => __('Dropdown Search Placeholder Color', 'the-clean-blog'),
    'section' => 'search-icon-and-dropdown-colors',
    'default' => '#2B1A1A',
    'priority' => 20,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.search-dropdown ::placeholder',
            'property' => 'color',
        ),
    ),
));

// 3.5- Dropdown Search Placeholder Text
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'text',
    'settings' => 'dropdown_search_placeholder_text',
    'label' => __('Dropdown Search Placeholder Text', 'the-clean-blog'),
    'section' => 'search-icon-and-dropdown-colors',
    'default'  => '',
    'priority' => 25,
    'transport' => 'postMessage',
    'js_vars' => array(
        array(
            'element' => '.search-dropdown input#header-search',
            'function' => 'html',
            'attr' => 'placeholder',
        ),
    ),
));

// 4- Header Background Image
The_Clean_Blog_Kirki::add_section( 'header_background_images', array(
    'title'          => __( 'Header Background Image & Texts', 'the-clean-blog' ),
    'description'    => __( 'Change Default Image & Texts ', 'the-clean-blog' ),
    'panel'          => 'thecleanblog_theme',
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

// 4.1- Deafult Header Background Image
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'image',
    'settings' => 'default_header_background_image',
    'label' => __('Deafult Header Background Image', 'the-clean-blog'),
    'section' => 'header_background_images',
    'default'  => get_template_directory_uri() . '/components/header/images/default-hero.jpg',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '#masthead',
            'property' => 'background-image',
        ),
    ),
    'active_callback' => 'is_home',
));

// 4.2- Search Header Background Image
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'image',
    'settings' => 'search_header_background_image',
    'label' => __('Search Header Background Image', 'the-clean-blog'),
    'section' => 'header_background_images',
    'default'  => get_template_directory_uri() . '/components/header/images/search-hero.jpg',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => 'body.search #masthead',
            'property' => 'background-image',
        ),
    ),
    'js_vars' => array(
        array(
            'element' => 'body.search #masthead',
            'function' => 'css',
            'property' => 'background-image',
        ),
    ),
    'active_callback' => 'is_search',
));

// 4.3- Search Page Title Text
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'text',
    'settings' => 'search_page_title_text',
    'label' => __('Search Page Title Text', 'the-clean-blog'),
    'section' => 'header_background_images',
    'default' => '',
    'priority' => 20,
    'transport' => 'postMessage',
    'js_vars' => array(
        array(
            'element' => 'body.search .intro-header .site-heading h1',
            'function' => 'html',
        ),
    ),
    'active_callback' => 'is_search',
));

// 4.4- Search Page Subtitle Text
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'text',
    'settings' => 'search_page_subtitle_text',
    'label' => __('Search Page Subtitle Text', 'the-clean-blog'),
    'section' => 'header_background_images',
    'default' => '',
    'priority' => 25,
    'transport' => 'postMessage',
    'js_vars' => array(
        array(
            'element' => 'body.search .intro-header .site-heading h2',
            'function' => 'html',
        ),
    ),
    'active_callback' => 'is_search',
));

// 4.5- Error404 Header Background Image
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'image',
    'settings' => 'error404_header_background_image',
    'label' => __('Error404 Header Background Image', 'the-clean-blog'),
    'section' => 'header_background_images',
    'default'  => get_template_directory_uri() . '/components/header/images/404-hero.jpg',
    'priority' => 30,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => 'body.error404 .intro-header',
            'property' => 'background-image',
        ),
    ),
    'js_vars' => array(
        array(
            'element' => 'body.error404 .intro-header',
            'function' => 'css',
            'property' => 'background-image',
        ),
    ),
    'active_callback' => 'is_404',
));

// 4.6- Error404 Page Title Text
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'text',
    'settings' => 'error404_page_title_text',
    'label' => __('Error404 Page Title Text', 'the-clean-blog'),
    'section' => 'header_background_images',
    'default' => '',
    'priority' => 30,
    'transport' => 'postMessage',
    'js_vars' => array(
        array(
            'element' => 'body.error404 .intro-header .site-heading h1',
            'function' => 'html',
        ),
    ),
    'active_callback' => 'is_404',
));

// 4.7- Error404 Page Subtitle Text
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'text',
    'settings' => 'error404_page_subtitle_text',
    'label' => __('Error404 Page Subtitle Text', 'the-clean-blog'),
    'section' => 'header_background_images',
    'default' => '',
    'priority' => 35,
    'transport' => 'postMessage',
    'js_vars' => array(
        array(
            'element' => 'body.error404 .intro-header .site-heading h2',
            'function' => 'html',
        ),
    ),
    'active_callback' => 'is_404',
));

// 5- Search Pages Texts
The_Clean_Blog_Kirki::add_section( 'search_pages_texts', array(
    'title'          => __( 'Search Pages Texts', 'the-clean-blog' ),
    'description'    => __( 'Change Default Search Texts ', 'the-clean-blog' ),
    'panel'          => 'thecleanblog_theme',
    'priority'       => 25,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

function is_search_has_results() {
    // Check if the search has results
    return 0 != $GLOBALS['wp_query']->found_posts && is_search();
}
function is_search_has_no_results() {
    // Check if the search has no results and is not 404
    return 0 == $GLOBALS['wp_query']->found_posts && !is_404();
}

// 5.1- Search Results Page Text
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'text',
    'settings' => 'search_results_page_text',
    'label' => __('Search Results Page Title Text', 'the-clean-blog'),
    'section' => 'search_pages_texts',
    'default' => '',
    'priority' => 5,
    'transport' => 'postMessage',
    'js_vars' => array(
        array(
            'element' => 'body.search .page-header h1.page-title',
            'function' => 'html',
        ),
    ),
    'active_callback' => 'is_search_has_results',
));

// 5.2- Search No Results Page Title Text
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'text',
    'settings' => 'search_no_results_page_title_text',
    'label' => __('Search No Results Page Title Text', 'the-clean-blog'),
    'section' => 'search_pages_texts',
    'default' => '',
    'priority' => 10,
    'transport' => 'postMessage',
    'js_vars' => array(
        array(
            'element' => 'body.search-no-results .page-header h1.page-title',
            'function' => 'html',
        ),
    ),
    'active_callback' => 'is_search_has_no_results',
));

// 5.3- Search No Results Page Paragraph Text
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'text',
    'settings' => 'search_no_results_page_paragraph_text',
    'label' => __('Search No Results Page Paragraph Text', 'the-clean-blog'),
    'section' => 'search_pages_texts',
    'default' => '',
    'priority' => 15,
    'transport' => 'postMessage',
    'js_vars' => array(
        array(
            'element' => 'body.search-no-results .page-content p',
            'function' => 'html',
        ),
    ),
    'active_callback' => 'is_search_has_no_results',
));

// 5.4- Search 404 Page Title Text
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'text',
    'settings' => 'search_404_page_title_text',
    'label' => __('Search 404 Page Title Text', 'the-clean-blog'),
    'section' => 'search_pages_texts',
    'default' => '',
    'priority' => 20,
    'transport' => 'postMessage',
    'js_vars' => array(
        array(
            'element' => 'body.error404 .page-header h1.page-title',
            'function' => 'html',
        ),
    ),
    'active_callback' => 'is_404',
));

// 5.5- Search 404 Page Paragraph Text
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'text',
    'settings' => 'search_404_page_paragraph_text',
    'label' => __('Search 404 Page Paragraph Text', 'the-clean-blog'),
    'section' => 'search_pages_texts',
    'default' => '',
    'priority' => 25,
    'transport' => 'postMessage',
    'js_vars' => array(
        array(
            'element' => 'body.error404 .page-content > p',
            'function' => 'html',
        ),
    ),
    'active_callback' => 'is_404',
));

// 6.1- Site Title and Description Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'site_title_description_color',
    'label' => __('Site Title and Description Color', 'the-clean-blog'),
    'section' => 'title_tagline',
    'default' => '#fff',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '.intro-header .site-heading',
                '.intro-header .site-heading a',
            ),
            'property' => 'color',
        ),
    ),
    'active_callback' => 'is_home',
));
// 6.2- Site Title Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'site_title_hover_color',
    'label' => __('Site Title Hover Color', 'the-clean-blog'),
    'section' => 'title_tagline',
    'default' => 'rgba(255, 255, 255, 0.8)',
    'priority' => 20,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                'h1.site-title a:focus',
                'h1.site-title a:hover'
                ),
            'property' => 'color',
        ),
    ),
    'active_callback' => 'is_home',
));
// 6.3- Strike and Arrow Down Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'strike_arrow_down_color',
    'label' => __('Strike and Arrow Down Color', 'the-clean-blog'),
    'section' => 'title_tagline',
    'default' => '#fff',
    'priority' => 25,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.strike i',
            'property' => 'color',
        ),
        array(
            'element' => array(
                '.strike > span:before',
                '.strike > span:after'
                ),
            'property' => 'background',
        )
    ),
));

// 7- BODY COLORS !
The_Clean_Blog_Kirki::add_panel( 'body_colors', array(
    'title'          => __( 'BODY COLORS !', 'the-clean-blog' ),
    'description'    => __( 'Change Default Body Colors', 'the-clean-blog' ),
    'panel'          => 'thecleanblog_theme',
) );

// 7.1- Body Background Color
The_Clean_Blog_Kirki::add_section( 'body_background_color', array(
    'title'          => __( 'Body Background Color', 'the-clean-blog' ),
    'description'    => __( 'Change Default Background Body Color', 'the-clean-blog' ),
    'panel'          => 'body_colors',
    'priority'       => 5,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.1.1- Body Background Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'body_background_color',
    'label' => __('Body Background Color', 'the-clean-blog'),
    'section' => 'body_background_color',
    'default' => '#f2f2f2',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.cb-main-content',
            'property' => 'background-color',
        ),
    ),
));

// 7.2- Posts Colors
The_Clean_Blog_Kirki::add_section( 'posts_colors', array(
    'title'          => __( 'Posts Colors', 'the-clean-blog' ),
    'description'    => __( 'Change Default Posts Colors', 'the-clean-blog' ),
    'panel'          => 'body_colors',
    'priority'       => 10,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.2.1- Post Title Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'post_title_color',
    'label' => __('Post Title Color', 'the-clean-blog'),
    'section' => 'posts_colors',
    'default' => '#333333',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                'h2.entry-title a',
                'h2.entry-title'
            ),
            'property' => 'color',
        ),
    ),
));
// 7.2.2- Post Title Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'post_title_hover_color',
    'label' => __('Post Title Hover Color', 'the-clean-blog'),
    'section' => 'posts_colors',
    'default' => '#0085A1',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                'h2.post-title a:hover',
                'h2.post-title a:focus'
            ),
            'property' => 'color',
        ),
    ),
));
// 7.2.3- Post Paragraphs Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'post_paragraphs_color',
    'label' => __('Post Paragraphs Color', 'the-clean-blog'),
    'section' => 'posts_colors',
    'default' => '#333333',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '.entry-summary > p',
                '.entry-content > p',
                'h3.post-subtitle'
            ),
            'property' => 'color',
        ),
    ),
));
// 7.2.4- Read More Link Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'read_more_color',
    'label' => __('Read More Link Color', 'the-clean-blog'),
    'section' => 'posts_colors',
    'default' => '#333333',
    'priority' => 20,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => 'a.read-more',
            'property' => 'color',
        ),
    ),
));
// 7.2.5- Read More Link Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'read_more_hover_color',
    'label' => __('Read More Link Hover Color', 'the-clean-blog'),
    'section' => 'posts_colors',
    'default' => '#337ab7',
    'priority' => 25,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                'a.read-more:hover',
                'a.read-more:focus'
            ),
            'property' => 'color',
        ),
    ),
));
// 7.2.6- Byline&Posted Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'byline_posted_color',
    'label' => __('Byline&Posted Color', 'the-clean-blog'),
    'section' => 'posts_colors',
    'default' => '#777777',
    'priority' => 30,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '.post-preview .post-meta',
                '.search .post-meta'
            ),
            'property' => 'color',
        ),
    ),
));

// 7.3- Links Colors
The_Clean_Blog_Kirki::add_section( 'links_colors', array(
    'title'          => __( 'Links Colors', 'the-clean-blog' ),
    'description'    => __( 'Change Default Links Colors', 'the-clean-blog' ),
    'panel'          => 'body_colors',
    'priority'       => 15,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.3.1- Body Links Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'body_links_color',
    'label' => __('Body Links Color', 'the-clean-blog'),
    'section' => 'links_colors',
    'default' => '#333333',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '#content .author.vcard a',
                '#content .posted-on a',
                '#content .cat-links a',
                '#content .tags-links a',
                '#content .page-links a'
            ),
            'property' => 'color',
        ),
    ),
));
// 7.3.2- Body Links Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'body_links_hover_color',
    'label' => __('Body Links Hover Color', 'the-clean-blog'),
    'section' => 'links_colors',
    'default' => '#0085A1',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '#content .author.vcard a:hover',
                '#content .posted-on a:hover',
                '#content .cat-links a:hover',
                '#content .tags-links a:hover',
                '#content .page-links a:hover'
            ),
            'property' => 'color',
        ),
    ),
));

// 7.4- Horizontal Rule Colors
The_Clean_Blog_Kirki::add_section( 'horizontal_rule_colors', array(
    'title'          => __( 'Horizontal Rule Colors', 'the-clean-blog' ),
    'description'    => __( 'Change Default Horizontal Rule Colors', 'the-clean-blog' ),
    'panel'          => 'body_colors',
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.4.1- Horizontal Rule Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'horizontal_rule_color',
    'label' => __('Horizontal Rule Color', 'the-clean-blog'),
    'section' => 'horizontal_rule_colors',
    'default' => 'rgb(140, 139, 139)',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => 'hr',
            'property' => 'border-top-color',
        ),
    ),
));
// 7.4.2- Horizontal Rule Background Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'horizontal_rule_background_color',
    'label' => __('Horizontal Rule Background Color', 'the-clean-blog'),
    'section' => 'horizontal_rule_colors',
    'default' => '#fff',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => 'hr',
            'property' => 'background-color',
        ),
    ),
));

// 7.5- Pagination Colors
The_Clean_Blog_Kirki::add_section( 'pagination_colors', array(
    'title'          => __( 'Pagination Colors', 'the-clean-blog' ),
    'description'    => __( 'Change Default Pagination Colors', 'the-clean-blog' ),
    'panel'          => 'body_colors',
    'priority'       => 25,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.5.1- Pagination Background Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'pagination_background_color',
    'label' => __('Pagination Background Color', 'the-clean-blog'),
    'section' => 'pagination_colors',
    'default' => '#ffffff',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '.pager li > a',
                '.pager li > span'
            ),
            'property' => 'background-color',
        ),
    ),
));
// 7.5.2- Pagination Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'pagination_hover_color',
    'label' => __('Pagination Hover Color', 'the-clean-blog'),
    'section' => 'pagination_colors',
    'default' => '#0085A1',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '.pager li > a:hover',
                '.pager li > a:focus'
            ),
            'property' => 'background-color',
        ),
        array(
            'element' => array(
                '.pager li > a:hover',
                '.pager li > a:focus'
            ),
            'property' => 'border-color',
        ),
    ),
));
// 7.5.3- Pagination Text Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'pagination_text_color',
    'label' => __('Pagination Text Color', 'the-clean-blog'),
    'section' => 'pagination_colors',
    'default' => '#333333',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.pager li > a',
            'property' => 'color',
        ),
    ),
));
// 7.5.4- Pagination Text Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'pagination_text_hover_color',
    'label' => __('Pagination Text Hover Color', 'the-clean-blog'),
    'section' => 'pagination_colors',
    'default' => '#ffffff',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => array(
                '.pager li > a:hover',
                '.pager li > a:focus'
            ),
            'property' => 'color',
        ),
    ),
));

// 7.6- Social Sharing Colors
The_Clean_Blog_Kirki::add_panel( 'social_sharing_colors', array(
    'title'          => __( 'Posts Social Sharing Colors', 'the-clean-blog' ),
    'description'    => __( 'Change Posts Default Social Sharing Colors', 'the-clean-blog' ),
    'panel'          => 'body_colors',
) );
// 7.6.1- Social Sharing Background Color
The_Clean_Blog_Kirki::add_section( 'social_sharing_background', array(
    'title'          => __( 'Social Sharing Background', 'the-clean-blog' ),
    'description'    => __( 'Change Default Social Sharing Background Color', 'the-clean-blog' ),
    'panel'          => 'social_sharing_colors',
    'priority'       => 5,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.6.1.1- Social Sharing Background Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'social_sharing_background_color',
    'label' => __('Social Sharing Background Color', 'the-clean-blog'),
    'section' => 'social_sharing_background',
    'default' => '#403439',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.panel-footer',
            'property' => 'background-color',
        ),
    ),
));
// 7.6.2- Social Sharing Text
The_Clean_Blog_Kirki::add_section( 'social_sharing_text', array(
    'title'          => __( 'Social Sharing Text', 'the-clean-blog' ),
    'description'    => __( 'Change Default Social Sharing Text Color', 'the-clean-blog' ),
    'panel'          => 'social_sharing_colors',
    'priority'       => 10,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.6.2.1- Social Sharing Text Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'social_sharing_text_color',
    'label' => __('Social Sharing Text Color', 'the-clean-blog'),
    'section' => 'social_sharing_text',
    'default' => '#fff',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network span',
            'property' => 'color',
        ),
    ),
));
// 7.6.3- Email Icon
The_Clean_Blog_Kirki::add_section( 'email_icon', array(
    'title'          => __( 'Email Icon', 'the-clean-blog' ),
    'description'    => __( 'Change Default Email Icon Colors', 'the-clean-blog' ),
    'panel'          => 'social_sharing_colors',
    'priority'       => 15,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.6.3.1- Email Icon Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'email_icon_color',
    'label' => __('Email Icon Color', 'the-clean-blog'),
    'section' => 'email_icon',
    'default' => '#fff',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-email i',
            'property' => 'color',
        ),
    ),
));
// 7.6.3.2- Email Icon Background Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'email_icon_background_hover_color',
    'label' => __('Email Icon Background Hover Color', 'the-clean-blog'),
    'section' => 'email_icon',
    'default' => '#783bd2',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-email:hover',
            'property' => 'background-color',
        ),
    ),
));
// 7.6.3.3- Email Icon Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'email_icon_hover_color',
    'label' => __('Email Icon Hover Color', 'the-clean-blog'),
    'section' => 'email_icon',
    'default' => '#fff',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-email:hover i',
            'property' => 'color',
        ),
    ),
));
// 7.6.4- Twitter Icon
The_Clean_Blog_Kirki::add_section( 'twitter_icon', array(
    'title'          => __( 'Twitter Icon', 'the-clean-blog' ),
    'description'    => __( 'Change Default Twitter Icon Colors', 'the-clean-blog' ),
    'panel'          => 'social_sharing_colors',
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.6.4.1- Twitter Icon Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'twitter_icon_color',
    'label' => __('Twitter Icon Color', 'the-clean-blog'),
    'section' => 'twitter_icon',
    'default' => '#fff',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-twitter i',
            'property' => 'color',
        ),
    ),
));
// 7.6.4.2- Twitter Icon Background Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'twitter_icon_background_hover_color',
    'label' => __('Twitter Icon Background Hover Color', 'the-clean-blog'),
    'section' => 'twitter_icon',
    'default' => '#55acee',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-twitter:hover',
            'property' => 'background-color',
        ),
    ),
));
// 7.6.4.3- Twitter Icon Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'twitter_icon_hover_color',
    'label' => __('Twitter Icon Hover Color', 'the-clean-blog'),
    'section' => 'twitter_icon',
    'default' => '#fff',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-twitter:hover i',
            'property' => 'color',
        ),
    ),
));
// 7.6.5- Facebook Icon
The_Clean_Blog_Kirki::add_section( 'facebook_icon', array(
    'title'          => __( 'Facebook Icon', 'the-clean-blog' ),
    'description'    => __( 'Change Default Facebook Icon Colors', 'the-clean-blog' ),
    'panel'          => 'social_sharing_colors',
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.6.5.1- Facebook Icon Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'facebook_icon_color',
    'label' => __('Facebook Icon Color', 'the-clean-blog'),
    'section' => 'facebook_icon',
    'default' => '#fff',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-facebook i',
            'property' => 'color',
        ),
    ),
));
// 7.6.5.2- Facebook Icon Background Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'facebook_icon_background_hover_color',
    'label' => __('Facebook Icon Background Hover Color', 'the-clean-blog'),
    'section' => 'facebook_icon',
    'default' => '#3b5998',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-facebook:hover',
            'property' => 'background-color',
        ),
    ),
));
// 7.6.5.3- Facebook Icon Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'facebook_icon_hover_color',
    'label' => __('Facebook Icon Hover Color', 'the-clean-blog'),
    'section' => 'facebook_icon',
    'default' => '#fff',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-facebook:hover i',
            'property' => 'color',
        ),
    ),
));
// 7.6.6- Google Plus Icon
The_Clean_Blog_Kirki::add_section( 'googleplus_icon', array(
    'title'          => __( 'Google Plus Icon', 'the-clean-blog' ),
    'description'    => __( 'Change Default Google Plus Icon Colors', 'the-clean-blog' ),
    'panel'          => 'social_sharing_colors',
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.6.6.1- Google Plus Icon Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'googleplus_icon_color',
    'label' => __('Google Plus Icon Color', 'the-clean-blog'),
    'section' => 'googleplus_icon',
    'default' => '#fff',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-googleplus i',
            'property' => 'color',
        ),
    ),
));
// 7.6.6.2- Google Plus Icon Background Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'googleplus_icon_background_hover_color',
    'label' => __('Google Plus Icon Background Hover Color', 'the-clean-blog'),
    'section' => 'googleplus_icon',
    'default' => '#dd4b39',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-googleplus:hover',
            'property' => 'background-color',
        ),
    ),
));
// 7.6.6.3- Google Plus Icon Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'googleplus_icon_hover_color',
    'label' => __('Google Plus Icon Hover Color', 'the-clean-blog'),
    'section' => 'googleplus_icon',
    'default' => '#fff',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-googleplus:hover i',
            'property' => 'color',
        ),
    ),
));
// 7.6.7- Pinterest Icon
The_Clean_Blog_Kirki::add_section( 'pinterest_icon', array(
    'title'          => __( 'Pinterest Icon', 'the-clean-blog' ),
    'description'    => __( 'Change Default Pinterest Icon Colors', 'the-clean-blog' ),
    'panel'          => 'social_sharing_colors',
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.6.7.1- Pinterest Icon Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'pinterest_icon_color',
    'label' => __('Pinterest Icon Color', 'the-clean-blog'),
    'section' => 'pinterest_icon',
    'default' => '#fff',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-pinterest i',
            'property' => 'color',
        ),
    ),
));
// 7.6.7.2- Pinterest Icon Background Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'pinterest_icon_background_hover_color',
    'label' => __('Pinterest Icon Background Hover Color', 'the-clean-blog'),
    'section' => 'pinterest_icon',
    'default' => '#cb2027',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-pinterest:hover',
            'property' => 'background-color',
        ),
    ),
));
// 7.6.7.3- Pinterest Icon Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'pinterest_icon_hover_color',
    'label' => __('Pinterest Icon Hover Color', 'the-clean-blog'),
    'section' => 'pinterest_icon',
    'default' => '#fff',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-pinterest:hover i',
            'property' => 'color',
        ),
    ),
));
// 7.6.8- WhatsApp Icon
The_Clean_Blog_Kirki::add_section( 'whatsapp_icon', array(
    'title'          => __( 'WhatsApp Icon (Tablet / Mobile)', 'the-clean-blog' ),
    'description'    => __( 'Change Default WhatsApp Icon Colors', 'the-clean-blog' ),
    'panel'          => 'social_sharing_colors',
    'priority'       => 20,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.6.8.1- WhatsApp Icon Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'whatsapp_icon_color',
    'label' => __('WhatsApp Icon Color', 'the-clean-blog'),
    'section' => 'whatsapp_icon',
    'default' => '#fff',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-whatsapp i',
            'property' => 'color',
        ),
    ),
));
// 7.6.8.2- WhatsApp Icon Background Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'whatsapp_icon_background_hover_color',
    'label' => __('WhatsApp Icon Background Hover Color', 'the-clean-blog'),
    'section' => 'whatsapp_icon',
    'default' => '#4dc247',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-whatsapp:hover',
            'property' => 'background-color',
        ),
    ),
));
// 7.6.8.3- WhatsApp Icon Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'whatsapp_icon_hover_color',
    'label' => __('WhatsApp Icon Hover Color', 'the-clean-blog'),
    'section' => 'whatsapp_icon',
    'default' => '#fff',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.social-network a.thecleanblog-whatsapp:hover i',
            'property' => 'color',
        ),
    ),
));

// 7.7- Comments Colors
The_Clean_Blog_Kirki::add_panel( 'comments_colors', array(
    'title'          => __( 'Posts Comments Colors', 'the-clean-blog' ),
    'description'    => __( 'Change Posts Default Comments Colors', 'the-clean-blog' ),
    'panel'          => 'body_colors',
) );
// 7.7.1- Comments Title & Notes
The_Clean_Blog_Kirki::add_section( 'comments_title_notes', array(
    'title'          => __( 'Comments Title & Notes', 'the-clean-blog' ),
    'description'    => __( 'Change Default Comments Title & Notes Colors', 'the-clean-blog' ),
    'panel'          => 'comments_colors',
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.7.1.1- Comments Title Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'comments_title_color',
    'label' => __('Comments Title Color', 'the-clean-blog'),
    'section' => 'comments_title_notes',
    'default' => '#333333',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '#reply-title',
            'property' => 'color',
        ),
    ),
));
// 7.7.1.2- Comments Notes Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'comments_notes_color',
    'label' => __('Comments Notes Color', 'the-clean-blog'),
    'section' => 'comments_title_notes',
    'default' => '#333333',
    'priority' => 10,
    'tooltip' => 'This control affects : "Your email address will not be published. Required fields are marked *"',
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.comment-notes',
            'property' => 'color',
        ),
    ),
));
// 7.7.2- Comments Boxes
The_Clean_Blog_Kirki::add_section( 'comments_boxes', array(
    'title'          => __( 'Comments Boxes', 'the-clean-blog' ),
    'description'    => __( 'Change Default Comments Boxes Colors', 'the-clean-blog' ),
    'panel'          => 'comments_colors',
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.7.2.1- Comments Placeholders Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'comments_placeholders_color',
    'label' => __('Comments Placeholders Color', 'the-clean-blog'),
    'section' => 'comments_boxes',
    'default' => '#999999',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '#commentform ::placeholder',
            'property' => 'color',
        ),
    ),
));
// 7.7.2.2- Comments Background Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'comments_background_color',
    'label' => __('Comments Background Color', 'the-clean-blog'),
    'section' => 'comments_boxes',
    'default' => '#fff',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '#comments .form-control',
            'property' => 'background-color',
        ),
    ),
));
// 7.7.2.3- Comments Background Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'comments_focus_border_color',
    'label' => __('Comments Focus Border Color', 'the-clean-blog'),
    'section' => 'comments_boxes',
    'default' => '#66afe9',
    'priority' => 15,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '#comments .form-control:focus',
            'property' => 'border-color',
        ),
    ),
));
// 7.7.3- Comments Submit Button Color
The_Clean_Blog_Kirki::add_section( 'comments_submit_button_colors', array(
    'title'          => __( 'Comments Submit Button Color', 'the-clean-blog' ),
    'description'    => __( 'Change Default Comments Submit Button Colors', 'the-clean-blog' ),
    'panel'          => 'comments_colors',
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );
// 7.7.3.1- Comments Submit Text Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'comments_submit_text_color',
    'label' => __('Comments Submit Text Color', 'the-clean-blog'),
    'section' => 'comments_submit_button_colors',
    'default' => '#000008',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.form-submit input[type="submit"]',
            'property' => 'color',
        ),
    ),
));
// 7.7.3.2- Comments Submit Background Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color-alpha',
    'settings' => 'comments_submit_background_color',
    'label' => __('Comments Submit Background Color', 'the-clean-blog'),
    'section' => 'comments_submit_button_colors',
    'default' => '#e6e6e6',
    'priority' => 10,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => '.form-submit input[type="submit"]',
            'property' => 'background',
        ),
    ),
));
// 7.7.3.3- Comments Submit Borders Colors
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'multicolor',
    'settings' => 'comments_submit_borders_colors',
    'label' => __('Comments Submit Borders Colors', 'the-clean-blog'),
    'section' => 'comments_submit_button_colors',
    'default'     => array(
        'border-top-color'    => '#ccc',
        'border-right-color'   => '#ccc',
        'border-bottom-color'  => '#bbb',
        'border-left-color'  => '#ccc',
    ),
    'priority' => 15,
    'transport' => 'auto',
    'choices'     => array(
        'border-top-color'    => esc_attr__( 'Border Top', 'the-clean-blog' ),
        'border-right-color'   => esc_attr__( 'Border Right', 'the-clean-blog' ),
        'border-bottom-color'  => esc_attr__( 'Border Bottom', 'the-clean-blog' ),
        'border-left-color'  => esc_attr__( 'Border Left', 'the-clean-blog' ),
    ),
    'output' => array(
        array(
            'element' => '.form-submit input[type="submit"]',
            'property' => 'border-color',
        ),
    ),
));