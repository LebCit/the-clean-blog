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
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
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
    'description' => __( 'My Description', 'the-clean-blog' ),
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
    'type' => 'color',
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
    'alpha' => true,
));

// 1.2- Menu Links Color - DESKTOP
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));

// 1.3- Selected Link Arrow Color - DESKTOP
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));

// 1.4- Sub Menu Background Color - DESKTOP
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));

// 1.5- Sub Menu Links Color - DESKTOP
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
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
    'type' => 'color',
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
    'alpha' => true,
));

// 2.2- Menu Trigger Background Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));

// 2.3- Mobile Menu Background Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));

// 2.4- Mobile Menu Links Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));

// 2.5- Mobile Sub Menu Background Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));

// 2.6- Sub Menu Links Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));

// 2.7- Sub Menu Go Back Arrow Color - MOBILE
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
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
    'type' => 'color',
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
    'alpha' => true,
));

// 3.2- Search Icon Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));

// 3.3- Dropdown Search Background Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));

// 3.4- Dropdown Search Placeholder Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
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
    'type' => 'color',
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
    'alpha' => true,
));
// 6.2- Site Title Hover Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));
// 6.3- Strike and Arrow Down Color
The_Clean_Blog_Kirki::add_field('thecleanblog', array(
    'type' => 'color',
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
    'alpha' => true,
));
