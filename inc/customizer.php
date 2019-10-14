<?php
/**
 * The Clean Blog Theme Customizer
 *
 * @package The_Clean_Blog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function thecleanblog_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport      = 'postMessage';
	$wp_customize->get_setting( 'header_image_data' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title',
				'render_callback' => 'thecleanblog_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'thecleanblog_customize_partial_blogdescription',
			)
		);
	}

	/**
	 * PANEL - The Clean Blog Theme
	 */
	$wp_customize->add_panel(
		'thecleanblog_theme_panel',
		array(
			'title'       => __( 'The Clean Blog Theme', 'the-clean-blog' ),
			'description' => esc_html__( 'Customize The Clean Blog Theme', 'the-clean-blog' ),
			'priority'    => 10,
		)
	);

	/**
	 * SECTION - Social Sites Links
	 */
	$wp_customize->add_section(
		'social_sites_section',
		array(
			'title'       => esc_html__( 'Footer Social Sites Links', 'the-clean-blog' ),
			'description' => __( 'Links to your social sites accounts.<br>Type a social account link in the correspondant input box, it\'s icon will appear in the footer.<br>For the email address, please note that the icon will appear only if a valid email address format is detected !', 'the-clean-blog' ),
			'panel'       => 'thecleanblog_theme_panel',
			'priority'    => 60,
		)
	);

	// Facebook URL.
	$wp_customize->add_setting(
		'facebook',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'facebook',
		array(
			'label'       => esc_html__( 'Facebook URL', 'the-clean-blog' ),
			'section'     => 'social_sites_section',
			'type'        => 'url',
			'input_attrs' => array(
				'placeholder' => esc_attr__( 'Facebook URL', 'the-clean-blog' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'facebook',
		array(
			'selector'        => '#tcb-social',
			'settings'        => array( 'facebook' ),
			'render_callback' => 'thecleanblog_social_media_icons',
		)
	);

	// Twitter URL.
	$wp_customize->add_setting(
		'twitter',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'twitter',
		array(
			'label'       => esc_html__( 'Twitter URL', 'the-clean-blog' ),
			'section'     => 'social_sites_section',
			'type'        => 'url',
			'input_attrs' => array(
				'placeholder' => esc_attr__( 'Twitter URL', 'the-clean-blog' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'twitter',
		array(
			'selector'        => '#tcb-social',
			'settings'        => array( 'twitter' ),
			'render_callback' => 'thecleanblog_social_media_icons',
		)
	);

	// LinkedIn URL.
	$wp_customize->add_setting(
		'linkedin',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'linkedin',
		array(
			'label'       => esc_html__( 'LinkedIn URL', 'the-clean-blog' ),
			'section'     => 'social_sites_section',
			'type'        => 'url',
			'input_attrs' => array(
				'placeholder' => esc_attr__( 'LinkedIn URL', 'the-clean-blog' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'linkedin',
		array(
			'selector'        => '#tcb-social',
			'settings'        => array( 'linkedin' ),
			'render_callback' => 'thecleanblog_social_media_icons',
		)
	);

	// Instagram URL.
	$wp_customize->add_setting(
		'instagram',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'instagram',
		array(
			'label'       => esc_html__( 'Instagram URL', 'the-clean-blog' ),
			'section'     => 'social_sites_section',
			'type'        => 'url',
			'input_attrs' => array(
				'placeholder' => esc_attr__( 'Instagram URL', 'the-clean-blog' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'instagram',
		array(
			'selector'        => '#tcb-social',
			'settings'        => array( 'instagram' ),
			'render_callback' => 'thecleanblog_social_media_icons',
		)
	);

	// YouTube URL.
	$wp_customize->add_setting(
		'youtube',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'youtube',
		array(
			'label'       => esc_html__( 'YouTube URL', 'the-clean-blog' ),
			'section'     => 'social_sites_section',
			'type'        => 'url',
			'input_attrs' => array(
				'placeholder' => esc_attr__( 'YouTube URL', 'the-clean-blog' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'youtube',
		array(
			'selector'        => '#tcb-social',
			'settings'        => array( 'youtube' ),
			'render_callback' => 'thecleanblog_social_media_icons',
		)
	);

	// Pinterest URL.
	$wp_customize->add_setting(
		'pinterest',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'pinterest',
		array(
			'label'       => esc_html__( 'Pinterest URL', 'the-clean-blog' ),
			'section'     => 'social_sites_section',
			'type'        => 'url',
			'input_attrs' => array(
				'placeholder' => esc_attr__( 'Pinterest URL', 'the-clean-blog' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'pinterest',
		array(
			'selector'        => '#tcb-social',
			'settings'        => array( 'pinterest' ),
			'render_callback' => 'thecleanblog_social_media_icons',
		)
	);

	// WordPress URL.
	$wp_customize->add_setting(
		'wordpress', // phpcs:ignore
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'wordpress', // phpcs:ignore
		array(
			'label'       => esc_html__( 'WordPress URL', 'the-clean-blog' ),
			'section'     => 'social_sites_section',
			'type'        => 'url',
			'input_attrs' => array(
				'placeholder' => esc_attr__( 'WordPress URL', 'the-clean-blog' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'wordpress', // phpcs:ignore
		array(
			'selector'        => '#tcb-social',
			'settings'        => array( 'wordpress' ),
			'render_callback' => 'thecleanblog_social_media_icons',
		)
	);

	// GitHub URL.
	$wp_customize->add_setting(
		'github',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'github',
		array(
			'label'       => esc_html__( 'GitHub URL', 'the-clean-blog' ),
			'section'     => 'social_sites_section',
			'type'        => 'url',
			'input_attrs' => array(
				'placeholder' => esc_attr__( 'GitHub URL', 'the-clean-blog' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'github',
		array(
			'selector'        => '#tcb-social',
			'settings'        => array( 'github' ),
			'render_callback' => 'thecleanblog_social_media_icons',
		)
	);

	// Email Address.
	$wp_customize->add_setting(
		'email',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_email',
		)
	);

	$wp_customize->add_control(
		'email',
		array(
			'label'       => esc_html__( 'Email Address', 'the-clean-blog' ),
			'description' => esc_html__( 'Only a Valid Email Address Will Work !', 'the-clean-blog' ),
			'section'     => 'social_sites_section',
			'type'        => 'email',
			'input_attrs' => array(
				'placeholder' => esc_attr__( 'Enter a valid email address !', 'the-clean-blog' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'email',
		array(
			'selector'        => '#tcb-social',
			'settings'        => array( 'email' ),
			'render_callback' => 'thecleanblog_social_media_icons',
		)
	);

	/**
	 * SECTION - Homepage Header Slider
	 */
	$wp_customize->add_section(
		'homepage_header_slider_section',
		array(
			'title'       => esc_html__( 'Homepage Header Slider', 'the-clean-blog' ),
			'description' => __( 'Enable/Disable the <b>HOMEPAGE</b> header slider.', 'the-clean-blog' ),
			'panel'       => 'thecleanblog_theme_panel',
			'priority'    => 20,
		)
	);

	$wp_customize->add_setting(
		'homepage_slider_checkbox',
		array(
			'default'           => false,
			'transport'         => 'refresh',
			'sanitize_callback' => 'thecleanblog_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'homepage_slider_checkbox',
		array(
			'label'       => __( 'Check to enable, uncheck to disable.', 'the-clean-blog' ),
			'description' => __( 'This checkbox, once <b>checked</b>,<br>enables a slider only on the <b>Homepage</b>.<br>Most <b>3 recent posts</b> with the <b>slider</b> category will be displayed.<br>So, to display posts in the slider, just add the <b>slider</b> category to those posts.', 'the-clean-blog' ),
			'section'     => 'homepage_header_slider_section',
			'type'        => 'checkbox',
		)
	);

	/**
	 * SECTION - Featured Images Display.
	 */
	$wp_customize->add_section(
		'featured_images_display_section',
		array(
			'title'       => esc_html__( 'Featured Images Display', 'the-clean-blog' ),
			'description' => __( 'Enable/Disable <b>Featured Images</b>.', 'the-clean-blog' ),
			'panel'       => 'thecleanblog_theme_panel',
			'priority'    => 40,
		)
	);

	$wp_customize->add_setting(
		'featured_images_display_checkbox',
		array(
			'default'           => true,
			'transport'         => 'refresh',
			'sanitize_callback' => 'thecleanblog_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'featured_images_display_checkbox',
		array(
			'label'       => __( 'Check to enable, uncheck to disable.', 'the-clean-blog' ),
			'description' => __( 'This checkbox, once <b>unchecked</b>,<br>removes <b>Featured Images</b> only from :<br>- the list of posts on <b>homepage</b>,<br>- the list of posts on <b>archives</b> pages,<br>- and the list of posts on <b>search</b> pages.', 'the-clean-blog' ),
			'section'     => 'featured_images_display_section',
			'type'        => 'checkbox',
		)
	);

	/**
	 * SECTION - Footer Copyright Area.
	 */
	$wp_customize->add_section(
		'footer_copyright_area_section',
		array(
			'title'       => esc_html__( 'Footer Copyright Area', 'the-clean-blog' ),
			'description' => __( 'Modify <b>Footer Copyright Area</b>.', 'the-clean-blog' ),
			'panel'       => 'thecleanblog_theme_panel',
			'priority'    => 80,
		)
	);

	// Default copyright.
	$wp_customize->add_setting(
		'footer_copyright_area_checkbox',
		array(
			'default'           => true,
			'transport'         => 'postMessage',
			'sanitize_callback' => 'thecleanblog_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'footer_copyright_area_checkbox',
		array(
			'label'       => __( 'Enable/Disable Default Copyright.', 'the-clean-blog' ),
			'description' => __( 'This checkbox, once <b>unchecked</b>,<br>removes <b>Default Copyright.</b>', 'the-clean-blog' ),
			'section'     => 'footer_copyright_area_section',
			'type'        => 'checkbox',
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'footer_copyright_area_checkbox',
		array(
			'selector'        => '#site-info',
			'settings'        => array( 'footer_copyright_area_checkbox' ),
			'render_callback' => 'thecleanblog_site_info',
		)
	);

	// Custom copyright.
	$wp_customize->add_setting(
		'custom_copyright_textarea',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'wp_kses_post', // Allow html.
		)
	);

	$wp_customize->add_control(
		'custom_copyright_textarea',
		array(
			'label'       => esc_html__( 'Custom Copyright Textarea', 'the-clean-blog' ),
			'description' => __( 'To display a <b>Custom Copyright</b>,<br><b>uncheck</b> the <b>Default Copyright</b> checkbox,<br>then type a custom copyright in the textarea.<br><b>HTML</b> is allowed !', 'the-clean-blog' ),
			'section'     => 'footer_copyright_area_section',
			'type'        => 'textarea',
			'input_attrs' => array(
				'style'       => 'border: 1px solid #999',
				'placeholder' => __( 'Enter Custom Copyright...', 'the-clean-blog' ),
			),
		)
	);

	$wp_customize->selective_refresh->add_partial(
		'custom_copyright_textarea',
		array(
			'selector'        => '#site-info',
			'settings'        => array( 'custom_copyright_textarea' ),
			'render_callback' => 'thecleanblog_site_info',
		)
	);

}
add_action( 'customize_register', 'thecleanblog_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function thecleanblog_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function thecleanblog_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if ( ! function_exists( 'thecleanblog_sanitize_checkbox' ) ) {
	/**
	 * Switch sanitization
	 *
	 * @param string $input Switch value.
	 * @return integer  Sanitized value
	 */
	function thecleanblog_sanitize_checkbox( $input ) {
		if ( false === $input ) {
			return 0;
		} else {
			return 1;
		}
	}
}

/**
 * Hooking in JS code to affect the controls in the Customizer.
 */
function thecleanblog_customize_controls_js() {
	wp_enqueue_script( 'thecleanblog-controls', get_template_directory_uri() . '/js/controls.js', array( 'customize-controls' ), filemtime( get_theme_file_path( '/js/controls.js' ) ), true );
}
add_action( 'customize_controls_enqueue_scripts', 'thecleanblog_customize_controls_js' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function thecleanblog_customize_preview_js() {
	wp_enqueue_script( 'thecleanblog-customizer', get_template_directory_uri() . '/js/customizer.min.js', array( 'jquery', 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'thecleanblog_customize_preview_js' );
