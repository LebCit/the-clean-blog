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
