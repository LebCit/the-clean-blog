<?php
/**
 * Clean Blog Theme Customizer.
 *
 * @package The_Clean_Blog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cleanblog_customize_register($wp_customize)
{
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
}
add_action('customize_register', 'cleanblog_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function cleanblog_customize_preview_js()
{
    wp_enqueue_script('cleanblog_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), '20151215', true);
}
add_action('customize_preview_init', 'cleanblog_customize_preview_js');

/**
 * Ensuring that all CSS & fonts will work if the plugin is not installed or removed.
 */
Clean_Blog_Kirki::add_config( 'cleanblog', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'theme_mod',
) );

/**
 * Clean Blog Customizer options.
 */

// Clean Blog Theme Panel
Clean_Blog_Kirki::add_panel( 'cleanblog_theme', array(
    'priority'    => 10,
    'title'       => __( 'Clean Blog Theme', 'the-clean-blog' ),
    'description' => __( 'My Description', 'the-clean-blog' ),
) );

// 1- Menu Colors Section - DESKTOP
Clean_Blog_Kirki::add_section( 'menu-colors', array(
    'title'          => __( 'DESKTOP Menu Colors' ),
    'description'    => __( 'Change DESKTOP Menu Colors', 'the-clean-blog' ),
    'panel'          => 'cleanblog_theme',
    'priority'       => 5,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

// 1.1- Menu Background Color - DESKTOP
Clean_Blog_Kirki::add_field('cleanblog', array(
    'type' => 'color',
    'settings' => 'menu_background_color',
    'label' => __('Menu Background Color', 'the-clean-blog'),
    'section' => 'menu-colors',
    'default' => '#33414a',
    'priority' => 5,
    'transport' => 'auto',
    'output' => array(
        array(
            'element' => 'header.cb-nav',
            'property' => 'background-color',
            'media_query' => '@media (min-width: 1024px)',
        ),
    ),
    'alpha' => true,
));

// 1.2- Menu Links Color - DESKTOP
Clean_Blog_Kirki::add_field('cleanblog', array(
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
Clean_Blog_Kirki::add_field('cleanblog', array(
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
Clean_Blog_Kirki::add_field('cleanblog', array(
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
Clean_Blog_Kirki::add_field('cleanblog', array(
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

