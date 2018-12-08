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
function thecleanblog_customize_register( $wp_customize ) {
	$wp_customize->get_section( 'background_image' )->title = __( 'Background Image/Color', 'the-clean-blog' );
	$wp_customize->remove_section( 'colors' );
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	} else {
		$wp_customize->selective_refresh->add_partial(
			'site_title',
			array(
				'selector'        => '.site-title a',
				'settings'        => array( 'blogname' ),
				'render_callback' => function() {
					return get_bloginfo( 'name', 'display' );
				},
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'site_description',
			array(
				'selector'        => 'p.site-description',
				'settings'        => array( 'blogdescription' ),
				'render_callback' => function() {
					return bloginfo( 'description' );
				},
			)
		);
	}
	$wp_customize->get_control( 'background_color' )->section = 'background_image';
}
add_action( 'customize_register', 'thecleanblog_customize_register' );


/**
 * Removes the core 'Menus' panel from the Customizer.
 *
 * @see https://wordpress.stackexchange.com/questions/228770/remove-nav-menus-from-customizer-using-a-theme
 */
add_action(
	'customize_register',
	function ( $wp_customize_manager ) {
		// Check if WP_Customize_Nav_Menus object exist.
		if ( isset( $wp_customize_manager->nav_menus ) && is_object( $wp_customize_manager->nav_menus ) ) {

			// Remove all the filters/actions resiterd in WP_Customize_Nav_Menus __construct.
			remove_filter( 'customize_refresh_nonces', array( $wp_customize_manager->nav_menus, 'filter_nonces' ) );
			remove_action( 'wp_ajax_load-available-menu-items-customizer', array( $wp_customize_manager->nav_menus, 'ajax_load_available_items' ) );
			remove_action( 'wp_ajax_search-available-menu-items-customizer', array( $wp_customize_manager->nav_menus, 'ajax_search_available_items' ) );
			remove_action( 'customize_controls_enqueue_scripts', array( $wp_customize_manager->nav_menus, 'enqueue_scripts' ) );
			remove_action( 'customize_register', array( $wp_customize_manager->nav_menus, 'customize_register' ), 11 );
			remove_filter( 'customize_dynamic_setting_args', array( $wp_customize_manager->nav_menus, 'filter_dynamic_setting_args' ), 10, 2 );
			remove_filter( 'customize_dynamic_setting_class', array( $wp_customize_manager->nav_menus, 'filter_dynamic_setting_class' ), 10, 3 );
			remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize_manager->nav_menus, 'print_templates' ) );
			remove_action( 'customize_controls_print_footer_scripts', array( $wp_customize_manager->nav_menus, 'available_items_template' ) );
			remove_action( 'customize_preview_init', array( $wp_customize_manager->nav_menus, 'customize_preview_init' ) );
			remove_filter( 'customize_dynamic_partial_args', array( $wp_customize_manager->nav_menus, 'customize_dynamic_partial_args' ), 10, 2 );

		}
	},
	-1
); // Give it a lowest priority so we can remove it on right time.

/**
 * Hooking in JS code to affect the controls in the Customizer.
 * FOR LATER USE !
 */
function thecleanblog_customize_controls() {
	wp_enqueue_script( 'thecleanblog-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls.js', array( 'customize-controls' ), filemtime( get_theme_file_path( '/assets/js/customize-controls.js' ) ), true );
	$customizer_settings = array();
	wp_localize_script( 'thecleanblog-customize-controls', 'tcb_cc', $customizer_settings );
}
add_action( 'customize_controls_enqueue_scripts', 'thecleanblog_customize_controls' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function thecleanblog_customize_preview_js() {
	wp_enqueue_script( 'thecleanblog-customizer-preview', get_theme_file_uri() . '/assets/js/customize-preview.js', array( 'customize-preview' ), '20151215', true );
	wp_localize_script(
		'thecleanblog-customizer-preview',
		'tcb_cp',
		array(
			'tcb_site_title'                            => esc_html( wp_parse_url( home_url() )['host'] ),
			'tcb_activate_slider'                       => get_theme_mod( 'activate_slider', false ),
			'tcb_placeholder_text'                      => esc_attr( 'Search &hellip;' ),
			'tcb_search_page_title_text'                => esc_html( 'Searching gives all answers' ),
			'tcb_search_results_page_text'              => esc_html( 'Search Results for' ),
			'tcb_error404_page_title_text'              => esc_html( 'Wrong Archives Row !' ),
			'tcb_search_404_page_title_text'            => esc_html( 'Oops! That page can&rsquo;t be found.' ),
			'tcb_error404_page_subtitle_text'           => esc_html( 'Try to search below' ),
			'tcb_search_404_page_paragraph_text'        => esc_html( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?' ),
			'tcb_search_page_subtitle_title_text'       => esc_html( 'KEEP SEARCHING !' ),
			'tcb_default_header_background_image'       => get_template_directory_uri() . '/components/header/images/default-hero.jpg',
			'tcb_search_no_results_page_title_text'     => esc_html( 'Nothing Found' ),
			'tcb_search_no_results_page_paragraph_text' => esc_html( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.' ),
		)
	);
}
add_action( 'customize_preview_init', 'thecleanblog_customize_preview_js' );

/**
 * Ensuring that all CSS & fonts will work if the plugin is not installed or removed.
 */
The_Clean_Blog_Kirki::add_config(
	'thecleanblog',
	array(
		'capability'  => 'edit_theme_options',
		'option_type' => 'theme_mod',
	)
);

/**
 * The Clean Blog Customizer options.
 */

// The Clean Blog Theme Panel.
The_Clean_Blog_Kirki::add_panel(
	'thecleanblog_theme',
	array(
		'priority'    => 10,
		'title'       => __( 'The Clean Blog Theme', 'the-clean-blog' ),
		'description' => __( 'Customize The Clean Blog Theme', 'the-clean-blog' ),
	)
);

// 1- Menu Colors Section - DESKTOP
The_Clean_Blog_Kirki::add_section(
	'menu-colors',
	array(
		'title'          => __( 'DESKTOP Menu Colors', 'the-clean-blog' ),
		'description'    => __( 'Change DESKTOP Menu Colors', 'the-clean-blog' ),
		'panel'          => 'thecleanblog_theme',
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);

// 1.1- Menu Background Color - DESKTOP
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'menu_background_color',
		'label'     => __( 'Menu Background Color', 'the-clean-blog' ),
		'section'   => 'menu-colors',
		'default'   => '#33414a',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => array(
					'header.cb-nav',
					'header.cb-nav.is-fixed.is-visible',
				),
				'property'    => 'background-color',
				'media_query' => '@media (min-width: 1024px)',
			),
			array(
				'element'     => 'header.cb-nav.is-fixed.is-visible',
				'property'    => 'border-bottom',
				'media_query' => '@media (min-width: 1024px)',
			),
		),
	)
);

// 1.2- Menu Links Color - DESKTOP
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'menu_links_color',
		'label'     => __( 'Menu Links Color', 'the-clean-blog' ),
		'section'   => 'menu-colors',
		'default'   => '#fff',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => '.cb-main-nav a',
				'property'    => 'color',
				'suffix'      => '!important', // Added important to override default in style.css !
				'media_query' => '@media (min-width: 1024px)',
			),
			array(
				'element'     => array(
					'.cb-main-nav .cb-subnav-trigger::before',
					'.cb-main-nav .cb-subnav-trigger::after',
				),
				'property'    => 'background-color',
				'media_query' => '@media (min-width: 1024px)',
			),
		),
	)
);

// 1.3- Selected Link Arrow Color - DESKTOP
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'selected_link_arrow_color',
		'label'     => __( 'Selected Link Arrow Color', 'the-clean-blog' ),
		'section'   => 'menu-colors',
		'default'   => '#0085A1',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => array(
					// Added .selected to style only the selected <li>'s arrow/close.
					'.cb-main-nav .selected .cb-subnav-trigger::before',
					'.cb-main-nav .selected .cb-subnav-trigger::after',
				),
				'property'    => 'background-color',
				'media_query' => '@media (min-width: 1024px)',
			),
		),
	)
);

// 1.4- Sub Menu Background Color - DESKTOP
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'sub_menu_background_color',
		'label'           => __( 'Sub Menu Background Color', 'the-clean-blog' ),
		'section'         => 'menu-colors',
		'default'         => '#405060',
		'priority'        => 20,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'     => '.cb-main-nav li ul',
				'property'    => 'background-color',
				'media_query' => '@media (min-width: 1024px)',
			),
		),
		'active_callback' => '@media (min-width: 1024px)',
	)
);

// 1.5- Sub Menu Links Color - DESKTOP
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'sub_menu_links_color',
		'label'     => __( 'Sub Menu Links Color', 'the-clean-blog' ),
		'section'   => 'menu-colors',
		'default'   => '#fff',
		'priority'  => 25,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => '.sub-menu a',
				'property'    => 'color',
				'suffix'      => '!important', // Added important to override default in style.css !
				'media_query' => '@media (min-width: 1024px)',
			),
		),
	)
);

// 2- Menu Colors Section - MOBILE
The_Clean_Blog_Kirki::add_section(
	'mobile-menu-colors',
	array(
		'title'          => __( 'MOBILE Menu Colors', 'the-clean-blog' ),
		'description'    => __( 'Change MOBILE Menu Colors', 'the-clean-blog' ),
		'panel'          => 'thecleanblog_theme',
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);

// 2.1- Menu Bar Background Color - MOBILE
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'mobile_menu_bar_background_color',
		'label'     => __( 'Menu Bar Background Color', 'the-clean-blog' ),
		'section'   => 'mobile-menu-colors',
		'default'   => '#33414a',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => 'header.cb-nav',
				'property'    => 'background-color',
				'media_query' => '@media (max-width: 1023px)',
			),
		),
	)
);

// 2.2- Menu Trigger Background Color - MOBILE
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'mobile_menu_trigger_background_color',
		'label'     => __( 'Menu Trigger Background Color', 'the-clean-blog' ),
		'section'   => 'mobile-menu-colors',
		'default'   => '#fff',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => array(
					'.cb-nav-trigger span',
					'.cb-nav-trigger span:before',
					'.cb-nav-trigger span:after',
				),
				'property'    => 'background-color',
				'media_query' => '@media (max-width: 1023px)',
			),
		),
	)
);

// 2.3- Mobile Menu Background Color - MOBILE
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'mobile_menu_background_color',
		'label'     => __( 'Mobile Menu Background Color', 'the-clean-blog' ),
		'section'   => 'mobile-menu-colors',
		'default'   => '#1e262c',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => '.cb-main-nav',
				'property'    => 'background',
				'media_query' => '@media (max-width: 1023px)',
			),
		),
	)
);

// 2.4- Mobile Menu Links Color - MOBILE
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'mobile_menu_links_color',
		'label'     => __( 'Mobile Menu Links Color', 'the-clean-blog' ),
		'section'   => 'mobile-menu-colors',
		'default'   => '#fff',
		'priority'  => 20,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => '.cb-main-nav a',
				'property'    => 'color',
				'suffix'      => '!important', // Added important to override default in style.css !
				'media_query' => '@media (max-width: 1023px)',
			),
			array(
				'element'     => array(
					'.cb-main-nav .cb-subnav-trigger::before',
					'.cb-main-nav .cb-subnav-trigger::after',
				),
				'property'    => 'background-color',
				'media_query' => '@media (max-width: 1023px)',
			),
		),
	)
);

// 2.5- Mobile Sub Menu Background Color - MOBILE
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'mobile_sub_menu_background_color',
		'label'     => __( 'Mobile Sub Menu Background Color', 'the-clean-blog' ),
		'section'   => 'mobile-menu-colors',
		'default'   => '#1e262c',
		'priority'  => 25,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => '.cb-main-nav.moves-out',
				'property'    => 'background',
				'media_query' => '@media (max-width: 1023px)',
			),
		),
	)
);

// 2.6- Sub Menu Links Color - MOBILE
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'mobile_sub_menu_links_color',
		'label'     => __( 'Sub Menu Links Color', 'the-clean-blog' ),
		'section'   => 'mobile-menu-colors',
		'default'   => '#fff',
		'priority'  => 30,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => '.sub-menu a',
				'property'    => 'color',
				'suffix'      => '!important', // Added important to override default in style.css !
				'media_query' => '@media (max-width: 1023px)',
			),
		),
	)
);

// 2.7- Sub Menu Go Back Arrow Color - MOBILE
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'mobile_sub_menugo-back_arrow_color',
		'label'     => __( 'Sub Menu Go Back Arrow Color', 'the-clean-blog' ),
		'section'   => 'mobile-menu-colors',
		'default'   => '#485c68',
		'priority'  => 35,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'     => array(
					'.cb-main-nav .go-back a::before',
					'.cb-main-nav .go-back a::after',
				),
				'property'    => 'background',
				'media_query' => '@media (max-width: 1023px)',
			),
		),
	)
);

// 3- Search Icon and Dropdown Section
The_Clean_Blog_Kirki::add_section(
	'search-icon-and-dropdown-colors',
	array(
		'title'          => __( 'Search Icon and Dropdown Colors', 'the-clean-blog' ),
		'description'    => __( 'Change Search Icon and Dropdown Colors', 'the-clean-blog' ),
		'panel'          => 'thecleanblog_theme',
		'priority'       => 15,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);

// 3.1- Search Icon Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'search_icon_color',
		'label'     => __( 'Search Icon Color', 'the-clean-blog' ),
		'section'   => 'search-icon-and-dropdown-colors',
		'default'   => '#fff',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'li.search-trigger',
					'button.search-trigger',
				),
				'property' => 'color',
			),
		),
	)
);

// 3.2- Search Icon Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'search_icon_hover_color',
		'label'     => __( 'Search Icon Hover Color', 'the-clean-blog' ),
		'section'   => 'search-icon-and-dropdown-colors',
		'default'   => '#d03b39',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'li.search-trigger:hover',
					'button.search-trigger:hover',
				),
				'property' => 'color',
			),
		),
	)
);

// 3.3- Dropdown Search Background Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'dropdown_search_background_color',
		'label'     => __( 'Dropdown Search Background Color', 'the-clean-blog' ),
		'section'   => 'search-icon-and-dropdown-colors',
		'default'   => '#486B82',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'.search-dropdown',
					'.search-dropdown input#s',
				),
				'property' => 'background',
			),
		),
	)
);

// 3.4- Dropdown Search Placeholder Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'dropdown_search_placeholder_color',
		'label'     => __( 'Dropdown Search Placeholder Color', 'the-clean-blog' ),
		'section'   => 'search-icon-and-dropdown-colors',
		'default'   => '#2B1A1A',
		'priority'  => 20,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.search-dropdown ::placeholder',
				'property' => 'color',
			),
		),
	)
);

// 3.5- Dropdown Search Placeholder Text
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'        => 'text',
		'settings'    => 'dropdown_search_placeholder_text',
		'label'       => __( 'Dropdown Search Placeholder Text', 'the-clean-blog' ),
		'section'     => 'search-icon-and-dropdown-colors',
		'default'     => '',
		'input_attrs' => array(
			'placeholder' => __( 'Replace Default Search Placeholder Text', 'the-clean-blog' ),
		),
		'priority'    => 25,
		'transport'   => 'postMessage',
		'js_vars'     => array(
			array(
				'element'  => '.search-dropdown input#header-search',
				'function' => 'html',
				'attr'     => 'placeholder',
			),
		),
	)
);

// 4- Header Background Image
The_Clean_Blog_Kirki::add_section(
	'header_background_images',
	array(
		'title'          => __( 'Header Background Image & Texts', 'the-clean-blog' ),
		'description'    => __( 'Change Default Image & Texts ', 'the-clean-blog' ),
		'panel'          => 'thecleanblog_theme',
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);

// 4.1- Deafult Header Background Image
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'image',
		'settings'        => 'default_header_background_image',
		'label'           => __( 'Deafult Header Background Image', 'the-clean-blog' ),
		'section'         => 'header_background_images',
		'default'         => get_template_directory_uri() . '/components/header/images/default-hero.jpg',
		'priority'        => 5,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => '#masthead',
				'property' => 'background-image',
			),
		),
		'active_callback' => 'is_home',
	)
);

// 4.2- Search Header Background Image
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'image',
		'settings'        => 'search_header_background_image',
		'label'           => __( 'Search Header Background Image', 'the-clean-blog' ),
		'section'         => 'header_background_images',
		'default'         => get_template_directory_uri() . '/components/header/images/search-hero.jpg',
		'priority'        => 10,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => 'body.search #masthead',
				'property' => 'background-image',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => 'body.search #masthead',
				'function' => 'css',
				'property' => 'background-image',
			),
		),
		'active_callback' => 'is_search',
	)
);

// 4.3- Search Page Title Text
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'text',
		'settings'        => 'search_page_title_text',
		'label'           => __( 'Search Page Title Text', 'the-clean-blog' ),
		'section'         => 'header_background_images',
		'default'         => '',
		'input_attrs'     => array(
			'placeholder' => __( 'Replace Default Search Page Title Text', 'the-clean-blog' ),
		),
		'priority'        => 20,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => 'body.search .intro-header .site-heading h1',
				'function' => 'html',
			),
		),
		'active_callback' => 'is_search',
	)
);

// 4.4- Search Page Subtitle Text
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'text',
		'settings'        => 'search_page_subtitle_text',
		'label'           => __( 'Search Page Subtitle Text', 'the-clean-blog' ),
		'section'         => 'header_background_images',
		'default'         => '',
		'input_attrs'     => array(
			'placeholder' => __( 'Replace Default Search Subtitle Text', 'the-clean-blog' ),
		),
		'priority'        => 25,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => 'body.search .intro-header .site-heading h2',
				'function' => 'html',
			),
		),
		'active_callback' => 'is_search',
	)
);

// 4.5- Error404 Header Background Image
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'image',
		'settings'        => 'error404_header_background_image',
		'label'           => __( 'Error404 Header Background Image', 'the-clean-blog' ),
		'section'         => 'header_background_images',
		'default'         => get_template_directory_uri() . '/components/header/images/404-hero.jpg',
		'priority'        => 30,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => 'body.error404 #masthead',
				'property' => 'background-image',
			),
		),
		'js_vars'         => array(
			array(
				'element'  => 'body.error404 #masthead',
				'function' => 'css',
				'property' => 'background-image',
			),
		),
		'active_callback' => 'is_404',
	)
);

// 4.6- Error404 Page Title Text
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'text',
		'settings'        => 'error404_page_title_text',
		'label'           => __( 'Error404 Page Title Text', 'the-clean-blog' ),
		'section'         => 'header_background_images',
		'default'         => '',
		'input_attrs'     => array(
			'placeholder' => __( 'Replace Error404 Page Title Text', 'the-clean-blog' ),
		),
		'priority'        => 30,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => 'body.error404 .intro-header .site-heading h1',
				'function' => 'html',
			),
		),
		'active_callback' => 'is_404',
	)
);

// 4.7- Error404 Page Subtitle Text
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'text',
		'settings'        => 'error404_page_subtitle_text',
		'label'           => __( 'Error404 Page Subtitle Text', 'the-clean-blog' ),
		'section'         => 'header_background_images',
		'default'         => '',
		'input_attrs'     => array(
			'placeholder' => __( 'Replace Error404 Page Subtitle Text', 'the-clean-blog' ),
		),
		'priority'        => 35,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => 'body.error404 .intro-header .site-heading h2',
				'function' => 'html',
			),
		),
		'active_callback' => 'is_404',
	)
);

// 5- Search Pages Texts
The_Clean_Blog_Kirki::add_section(
	'search_pages_texts',
	array(
		'title'          => __( 'Search Pages Texts', 'the-clean-blog' ),
		'description'    => __( 'Change Default Search Texts ', 'the-clean-blog' ),
		'panel'          => 'thecleanblog_theme',
		'priority'       => 25,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);

/**
 * Function to check if search has results.
 */
function is_search_has_results() {
	// Check if the search has results.
	return 0 != $GLOBALS['wp_query']->found_posts && is_search();
}
/**
 * Function to check if search has no results.
 */
function is_search_has_no_results() {
	// Check if the search has no results and is not 404.
	return 0 == $GLOBALS['wp_query']->found_posts && ! is_404();
}

// 5.1- Search Results Page Text
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'text',
		'settings'        => 'search_results_page_text',
		'label'           => __( 'Search Results Page Title Text', 'the-clean-blog' ),
		'section'         => 'search_pages_texts',
		'default'         => '',
		'input_attrs'     => array(
			'placeholder' => __( 'Replace Search Results Page Title Text', 'the-clean-blog' ),
		),
		'priority'        => 5,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => 'body.search .page-header h1.page-title #srft',
				'function' => 'html',
			),
		),
		'active_callback' => 'is_search_has_results',
	)
);

// 5.2- Search No Results Page Title Text
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'text',
		'settings'        => 'search_no_results_page_title_text',
		'label'           => __( 'Search No Results Page Title Text', 'the-clean-blog' ),
		'section'         => 'search_pages_texts',
		'default'         => '',
		'input_attrs'     => array(
			'placeholder' => __( 'Replace Search No Results Page Title Text', 'the-clean-blog' ),
		),
		'priority'        => 10,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => 'body.search-no-results .page-header h1.page-title',
				'function' => 'html',
			),
		),
		'active_callback' => 'is_search_has_no_results',
	)
);

// 5.3- Search No Results Page Paragraph Text
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'text',
		'settings'        => 'search_no_results_page_paragraph_text',
		'label'           => __( 'Search No Results Page Paragraph Text', 'the-clean-blog' ),
		'section'         => 'search_pages_texts',
		'default'         => '',
		'input_attrs'     => array(
			'placeholder' => __( 'Replace Search No Results Page Paragraph Text', 'the-clean-blog' ),
		),
		'priority'        => 15,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => 'body.search-no-results .page-content p',
				'function' => 'html',
			),
		),
		'active_callback' => 'is_search_has_no_results',
	)
);

// 5.4- Search 404 Page Title Text
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'text',
		'settings'        => 'search_404_page_title_text',
		'label'           => __( 'Search 404 Page Title Text', 'the-clean-blog' ),
		'section'         => 'search_pages_texts',
		'default'         => '',
		'input_attrs'     => array(
			'placeholder' => __( 'Replace Search 404 Page Title Text', 'the-clean-blog' ),
		),
		'priority'        => 20,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => 'body.error404 .page-header h1.page-title',
				'function' => 'html',
			),
		),
		'active_callback' => 'is_404',
	)
);

// 5.5- Search 404 Page Paragraph Text
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'text',
		'settings'        => 'search_404_page_paragraph_text',
		'label'           => __( 'Search 404 Page Paragraph Text', 'the-clean-blog' ),
		'section'         => 'search_pages_texts',
		'default'         => '',
		'input_attrs'     => array(
			'placeholder' => __( 'Replace Search 404 Page Paragraph Text', 'the-clean-blog' ),
		),
		'priority'        => 25,
		'transport'       => 'postMessage',
		'js_vars'         => array(
			array(
				'element'  => 'body.error404 .page-content > p',
				'function' => 'html',
			),
		),
		'active_callback' => 'is_404',
	)
);

// 6.1- Site Title and Description Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'site_title_description_color',
		'label'           => __( 'Site Title and Description Color', 'the-clean-blog' ),
		'section'         => 'title_tagline',
		'default'         => '#fff',
		'priority'        => 15,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => array(
					'.intro-header .site-heading',
					'.intro-header .site-heading a',
				),
				'property' => 'color',
			),
		),
		'active_callback' => 'is_home',
	)
);
// 6.2- Site Title Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'site_title_hover_color',
		'label'           => __( 'Site Title Hover Color', 'the-clean-blog' ),
		'section'         => 'title_tagline',
		'default'         => 'rgba(255, 255, 255, 0.8)',
		'priority'        => 20,
		'transport'       => 'auto',
		'output'          => array(
			array(
				'element'  => array(
					'h1.site-title a:focus',
					'h1.site-title a:hover',
				),
				'property' => 'color',
			),
		),
		'active_callback' => 'is_home',
	)
);
// 6.3- Strike and Arrow Down Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'strike_arrow_down_color',
		'label'     => __( 'Strike and Arrow Down Color', 'the-clean-blog' ),
		'section'   => 'title_tagline',
		'default'   => '#fff',
		'priority'  => 25,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.strike i',
				'property' => 'color',
			),
			array(
				'element'  => array(
					'.strike > span:before',
					'.strike > span:after',
				),
				'property' => 'background',
			),
		),
	)
);

// 7- BODY COLORS !
The_Clean_Blog_Kirki::add_panel(
	'body_colors',
	array(
		'title'       => __( 'BODY COLORS !', 'the-clean-blog' ),
		'description' => __( 'Change Default Body Colors', 'the-clean-blog' ),
		'panel'       => 'thecleanblog_theme',
	)
);

// 7.1- Body Background Color
The_Clean_Blog_Kirki::add_section(
	'body_background_color',
	array(
		'title'          => __( 'Body Background Color', 'the-clean-blog' ),
		'description'    => __( 'Change Default Background Body Color', 'the-clean-blog' ),
		'panel'          => 'body_colors',
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.1.1- Body Background Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'body_background_color',
		'label'     => __( 'Body Background Color', 'the-clean-blog' ),
		'section'   => 'body_background_color',
		'default'   => '#f2f2f2',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.cb-main-content',
				'property' => 'background-color',
			),
		),
	)
);

// 7.2- Posts Colors
The_Clean_Blog_Kirki::add_section(
	'posts_colors',
	array(
		'title'          => __( 'Posts Colors', 'the-clean-blog' ),
		'description'    => __( 'Change Default Posts Colors', 'the-clean-blog' ),
		'panel'          => 'body_colors',
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.2.1- Post Title Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'post_title_color',
		'label'     => __( 'Post Title Color', 'the-clean-blog' ),
		'section'   => 'posts_colors',
		'default'   => '#333333',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'h2.entry-title a',
					'h2.entry-title',
				),
				'property' => 'color',
			),
		),
	)
);
// 7.2.2- Post Title Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'post_title_hover_color',
		'label'     => __( 'Post Title Hover Color', 'the-clean-blog' ),
		'section'   => 'posts_colors',
		'default'   => '#0085A1',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'h2.post-title a:hover',
					'h2.post-title a:focus',
				),
				'property' => 'color',
			),
		),
	)
);
// 7.2.3- Post Paragraphs Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'post_paragraphs_color',
		'label'     => __( 'Post Paragraphs Color', 'the-clean-blog' ),
		'section'   => 'posts_colors',
		'default'   => '#333333',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'.entry-summary > p',
					'.entry-content > p',
					'h3.post-subtitle',
				),
				'property' => 'color',
			),
		),
	)
);
// 7.2.4- Read More Link Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'read_more_color',
		'label'     => __( 'Read More Link Color', 'the-clean-blog' ),
		'section'   => 'posts_colors',
		'default'   => '#333333',
		'priority'  => 20,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => 'a.read-more',
				'property' => 'color',
			),
		),
	)
);
// 7.2.5- Read More Link Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'read_more_hover_color',
		'label'     => __( 'Read More Link Hover Color', 'the-clean-blog' ),
		'section'   => 'posts_colors',
		'default'   => '#337ab7',
		'priority'  => 25,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'a.read-more:hover',
					'a.read-more:focus',
				),
				'property' => 'color',
			),
		),
	)
);
// 7.2.6- Byline&Posted Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'byline_posted_color',
		'label'     => __( 'Byline&Posted Color', 'the-clean-blog' ),
		'section'   => 'posts_colors',
		'default'   => '#777777',
		'priority'  => 30,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'.post-preview .post-meta',
					'.search .post-meta',
				),
				'property' => 'color',
			),
		),
	)
);

// 7.3- Links Colors
The_Clean_Blog_Kirki::add_section(
	'links_colors',
	array(
		'title'          => __( 'Links Colors', 'the-clean-blog' ),
		'description'    => __( 'Change Default Links Colors', 'the-clean-blog' ),
		'panel'          => 'body_colors',
		'priority'       => 15,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.3.1- Body Links Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'body_links_color',
		'label'     => __( 'Body Links Color', 'the-clean-blog' ),
		'section'   => 'links_colors',
		'default'   => '#333333',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'#content .author.vcard a',
					'#content .posted-on a',
					'#content .cat-links a',
					'#content .tags-links a',
					'#content .page-links a',
				),
				'property' => 'color',
			),
		),
	)
);
// 7.3.2- Body Links Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'body_links_hover_color',
		'label'     => __( 'Body Links Hover Color', 'the-clean-blog' ),
		'section'   => 'links_colors',
		'default'   => '#0085A1',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'#content .author.vcard a:hover',
					'#content .posted-on a:hover',
					'#content .cat-links a:hover',
					'#content .tags-links a:hover',
					'#content .page-links a:hover',
				),
				'property' => 'color',
			),
		),
	)
);

// 7.4- Horizontal Rule Colors
The_Clean_Blog_Kirki::add_section(
	'horizontal_rule_colors',
	array(
		'title'          => __( 'Horizontal Rule Colors', 'the-clean-blog' ),
		'description'    => __( 'Change Default Horizontal Rule Colors', 'the-clean-blog' ),
		'panel'          => 'body_colors',
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.4.1- Horizontal Rule Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'horizontal_rule_color',
		'label'     => __( 'Horizontal Rule Color', 'the-clean-blog' ),
		'section'   => 'horizontal_rule_colors',
		'default'   => 'rgb(140, 139, 139)',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => 'hr',
				'property' => 'border-top-color',
			),
		),
	)
);
// 7.4.2- Horizontal Rule Background Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'horizontal_rule_background_color',
		'label'     => __( 'Horizontal Rule Background Color', 'the-clean-blog' ),
		'section'   => 'horizontal_rule_colors',
		'default'   => '#fff',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => 'hr',
				'property' => 'background-color',
			),
		),
	)
);

// 7.5- Pagination Colors
The_Clean_Blog_Kirki::add_section(
	'pagination_colors',
	array(
		'title'          => __( 'Pagination Colors', 'the-clean-blog' ),
		'description'    => __( 'Change Default Pagination Colors', 'the-clean-blog' ),
		'panel'          => 'body_colors',
		'priority'       => 25,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.5.1- Pagination Background Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'pagination_background_color',
		'label'     => __( 'Pagination Background Color', 'the-clean-blog' ),
		'section'   => 'pagination_colors',
		'default'   => '#ffffff',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'.pager li > a',
					'.pager li > span',
				),
				'property' => 'background-color',
			),
		),
	)
);
// 7.5.2- Pagination Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'pagination_hover_color',
		'label'     => __( 'Pagination Hover Color', 'the-clean-blog' ),
		'section'   => 'pagination_colors',
		'default'   => '#0085A1',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'.pager li > a:hover',
					'.pager li > a:focus',
				),
				'property' => 'background-color',
			),
			array(
				'element'  => array(
					'.pager li > a:hover',
					'.pager li > a:focus',
				),
				'property' => 'border-color',
			),
		),
	)
);
// 7.5.3- Pagination Text Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'pagination_text_color',
		'label'     => __( 'Pagination Text Color', 'the-clean-blog' ),
		'section'   => 'pagination_colors',
		'default'   => '#333333',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.pager li > a',
				'property' => 'color',
			),
		),
	)
);
// 7.5.4- Pagination Text Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'pagination_text_hover_color',
		'label'     => __( 'Pagination Text Hover Color', 'the-clean-blog' ),
		'section'   => 'pagination_colors',
		'default'   => '#ffffff',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => array(
					'.pager li > a:hover',
					'.pager li > a:focus',
				),
				'property' => 'color',
			),
		),
	)
);

// 7.6- Social Sharing Colors
The_Clean_Blog_Kirki::add_panel(
	'social_sharing_colors',
	array(
		'title'       => __( 'Posts Social Sharing Colors', 'the-clean-blog' ),
		'description' => __( 'Change Posts Default Social Sharing Colors', 'the-clean-blog' ),
		'panel'       => 'body_colors',
	)
);
// 7.6.1- Social Sharing Background Color
The_Clean_Blog_Kirki::add_section(
	'social_sharing_background',
	array(
		'title'          => __( 'Social Sharing Background', 'the-clean-blog' ),
		'description'    => __( 'Change Default Social Sharing Background Color', 'the-clean-blog' ),
		'panel'          => 'social_sharing_colors',
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.6.1.1- Social Sharing Background Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'social_sharing_background_color',
		'label'     => __( 'Social Sharing Background Color', 'the-clean-blog' ),
		'section'   => 'social_sharing_background',
		'default'   => '#403439',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.panel-footer',
				'property' => 'background-color',
			),
		),
	)
);
// 7.6.2- Social Sharing Text
The_Clean_Blog_Kirki::add_section(
	'social_sharing_text',
	array(
		'title'          => __( 'Social Sharing Text', 'the-clean-blog' ),
		'description'    => __( 'Change Default Social Sharing Text Color', 'the-clean-blog' ),
		'panel'          => 'social_sharing_colors',
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.6.2.1- Social Sharing Text Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'social_sharing_text_color',
		'label'     => __( 'Social Sharing Text Color', 'the-clean-blog' ),
		'section'   => 'social_sharing_text',
		'default'   => '#fff',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network span',
				'property' => 'color',
			),
		),
	)
);
// 7.6.3- Email Icon
The_Clean_Blog_Kirki::add_section(
	'email_icon',
	array(
		'title'          => __( 'Email Icon', 'the-clean-blog' ),
		'description'    => __( 'Change Default Email Icon Colors', 'the-clean-blog' ),
		'panel'          => 'social_sharing_colors',
		'priority'       => 15,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.6.3.1- Email Icon Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'email_icon_color',
		'label'     => __( 'Email Icon Color', 'the-clean-blog' ),
		'section'   => 'email_icon',
		'default'   => '#fff',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-email i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.3.2- Email Icon Background Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'email_icon_background_hover_color',
		'label'     => __( 'Email Icon Background Hover Color', 'the-clean-blog' ),
		'section'   => 'email_icon',
		'default'   => '#783bd2',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-email:hover',
				'property' => 'background-color',
			),
		),
	)
);
// 7.6.3.3- Email Icon Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'email_icon_hover_color',
		'label'     => __( 'Email Icon Hover Color', 'the-clean-blog' ),
		'section'   => 'email_icon',
		'default'   => '#fff',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-email:hover i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.4- Twitter Icon
The_Clean_Blog_Kirki::add_section(
	'twitter_icon',
	array(
		'title'          => __( 'Twitter Icon', 'the-clean-blog' ),
		'description'    => __( 'Change Default Twitter Icon Colors', 'the-clean-blog' ),
		'panel'          => 'social_sharing_colors',
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.6.4.1- Twitter Icon Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'twitter_icon_color',
		'label'     => __( 'Twitter Icon Color', 'the-clean-blog' ),
		'section'   => 'twitter_icon',
		'default'   => '#fff',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-twitter i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.4.2- Twitter Icon Background Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'twitter_icon_background_hover_color',
		'label'     => __( 'Twitter Icon Background Hover Color', 'the-clean-blog' ),
		'section'   => 'twitter_icon',
		'default'   => '#55acee',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-twitter:hover',
				'property' => 'background-color',
			),
		),
	)
);
// 7.6.4.3- Twitter Icon Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'twitter_icon_hover_color',
		'label'     => __( 'Twitter Icon Hover Color', 'the-clean-blog' ),
		'section'   => 'twitter_icon',
		'default'   => '#fff',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-twitter:hover i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.5- Facebook Icon
The_Clean_Blog_Kirki::add_section(
	'facebook_icon',
	array(
		'title'          => __( 'Facebook Icon', 'the-clean-blog' ),
		'description'    => __( 'Change Default Facebook Icon Colors', 'the-clean-blog' ),
		'panel'          => 'social_sharing_colors',
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.6.5.1- Facebook Icon Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'facebook_icon_color',
		'label'     => __( 'Facebook Icon Color', 'the-clean-blog' ),
		'section'   => 'facebook_icon',
		'default'   => '#fff',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-facebook i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.5.2- Facebook Icon Background Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'facebook_icon_background_hover_color',
		'label'     => __( 'Facebook Icon Background Hover Color', 'the-clean-blog' ),
		'section'   => 'facebook_icon',
		'default'   => '#3b5998',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-facebook:hover',
				'property' => 'background-color',
			),
		),
	)
);
// 7.6.5.3- Facebook Icon Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'facebook_icon_hover_color',
		'label'     => __( 'Facebook Icon Hover Color', 'the-clean-blog' ),
		'section'   => 'facebook_icon',
		'default'   => '#fff',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-facebook:hover i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.6- Google Plus Icon
The_Clean_Blog_Kirki::add_section(
	'googleplus_icon',
	array(
		'title'          => __( 'Google Plus Icon', 'the-clean-blog' ),
		'description'    => __( 'Change Default Google Plus Icon Colors', 'the-clean-blog' ),
		'panel'          => 'social_sharing_colors',
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.6.6.1- Google Plus Icon Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'googleplus_icon_color',
		'label'     => __( 'Google Plus Icon Color', 'the-clean-blog' ),
		'section'   => 'googleplus_icon',
		'default'   => '#fff',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-googleplus i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.6.2- Google Plus Icon Background Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'googleplus_icon_background_hover_color',
		'label'     => __( 'Google Plus Icon Background Hover Color', 'the-clean-blog' ),
		'section'   => 'googleplus_icon',
		'default'   => '#dd4b39',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-googleplus:hover',
				'property' => 'background-color',
			),
		),
	)
);
// 7.6.6.3- Google Plus Icon Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'googleplus_icon_hover_color',
		'label'     => __( 'Google Plus Icon Hover Color', 'the-clean-blog' ),
		'section'   => 'googleplus_icon',
		'default'   => '#fff',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-googleplus:hover i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.7- Pinterest Icon
The_Clean_Blog_Kirki::add_section(
	'pinterest_icon',
	array(
		'title'          => __( 'Pinterest Icon', 'the-clean-blog' ),
		'description'    => __( 'Change Default Pinterest Icon Colors', 'the-clean-blog' ),
		'panel'          => 'social_sharing_colors',
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.6.7.1- Pinterest Icon Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'pinterest_icon_color',
		'label'     => __( 'Pinterest Icon Color', 'the-clean-blog' ),
		'section'   => 'pinterest_icon',
		'default'   => '#fff',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-pinterest i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.7.2- Pinterest Icon Background Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'pinterest_icon_background_hover_color',
		'label'     => __( 'Pinterest Icon Background Hover Color', 'the-clean-blog' ),
		'section'   => 'pinterest_icon',
		'default'   => '#cb2027',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-pinterest:hover',
				'property' => 'background-color',
			),
		),
	)
);
// 7.6.7.3- Pinterest Icon Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'pinterest_icon_hover_color',
		'label'     => __( 'Pinterest Icon Hover Color', 'the-clean-blog' ),
		'section'   => 'pinterest_icon',
		'default'   => '#fff',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-pinterest:hover i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.8- WhatsApp Icon
The_Clean_Blog_Kirki::add_section(
	'whatsapp_icon',
	array(
		'title'          => __( 'WhatsApp Icon (Tablet / Mobile)', 'the-clean-blog' ),
		'description'    => __( 'Change Default WhatsApp Icon Colors', 'the-clean-blog' ),
		'panel'          => 'social_sharing_colors',
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.6.8.1- WhatsApp Icon Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'whatsapp_icon_color',
		'label'     => __( 'WhatsApp Icon Color', 'the-clean-blog' ),
		'section'   => 'whatsapp_icon',
		'default'   => '#fff',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-whatsapp i',
				'property' => 'color',
			),
		),
	)
);
// 7.6.8.2- WhatsApp Icon Background Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'whatsapp_icon_background_hover_color',
		'label'     => __( 'WhatsApp Icon Background Hover Color', 'the-clean-blog' ),
		'section'   => 'whatsapp_icon',
		'default'   => '#4dc247',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-whatsapp:hover',
				'property' => 'background-color',
			),
		),
	)
);
// 7.6.8.3- WhatsApp Icon Hover Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'whatsapp_icon_hover_color',
		'label'     => __( 'WhatsApp Icon Hover Color', 'the-clean-blog' ),
		'section'   => 'whatsapp_icon',
		'default'   => '#fff',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.social-network a.thecleanblog-whatsapp:hover i',
				'property' => 'color',
			),
		),
	)
);

// 7.7- Comments Colors
The_Clean_Blog_Kirki::add_panel(
	'comments_colors',
	array(
		'title'       => __( 'Posts Comments Colors', 'the-clean-blog' ),
		'description' => __( 'Change Posts Default Comments Colors', 'the-clean-blog' ),
		'panel'       => 'body_colors',
	)
);
// 7.7.1- Comments Title & Notes
The_Clean_Blog_Kirki::add_section(
	'comments_title_notes',
	array(
		'title'          => __( 'Comments Title & Notes', 'the-clean-blog' ),
		'description'    => __( 'Change Default Comments Title & Notes Colors', 'the-clean-blog' ),
		'panel'          => 'comments_colors',
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.7.1.1- Comments Title Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'comments_title_color',
		'label'     => __( 'Comments Title Color', 'the-clean-blog' ),
		'section'   => 'comments_title_notes',
		'default'   => '#333333',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '#reply-title',
				'property' => 'color',
			),
		),
	)
);
// 7.7.1.2- Comments Notes Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'comments_notes_color',
		'label'     => __( 'Comments Notes Color', 'the-clean-blog' ),
		'section'   => 'comments_title_notes',
		'default'   => '#333333',
		'priority'  => 10,
		'tooltip'   => 'This control affects : "Your email address will not be published. Required fields are marked *"',
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.comment-notes',
				'property' => 'color',
			),
		),
	)
);
// 7.7.2- Comments Boxes
The_Clean_Blog_Kirki::add_section(
	'comments_boxes',
	array(
		'title'          => __( 'Comments Boxes', 'the-clean-blog' ),
		'description'    => __( 'Change Default Comments Boxes Colors', 'the-clean-blog' ),
		'panel'          => 'comments_colors',
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.7.2.1- Comments Placeholders Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'comments_placeholders_color',
		'label'     => __( 'Comments Placeholders Color', 'the-clean-blog' ),
		'section'   => 'comments_boxes',
		'default'   => '#999999',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '#commentform ::placeholder',
				'property' => 'color',
			),
		),
	)
);
// 7.7.2.2- Comments Background Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'comments_background_color',
		'label'     => __( 'Comments Background Color', 'the-clean-blog' ),
		'section'   => 'comments_boxes',
		'default'   => '#fff',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '#comments .form-control',
				'property' => 'background-color',
			),
		),
	)
);
// 7.7.2.3- Comments Background Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'comments_focus_border_color',
		'label'     => __( 'Comments Focus Border Color', 'the-clean-blog' ),
		'section'   => 'comments_boxes',
		'default'   => '#66afe9',
		'priority'  => 15,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '#comments .form-control:focus',
				'property' => 'border-color',
			),
		),
	)
);
// 7.7.3- Comments Submit Button Color
The_Clean_Blog_Kirki::add_section(
	'comments_submit_button_colors',
	array(
		'title'          => __( 'Comments Submit Button Color', 'the-clean-blog' ),
		'description'    => __( 'Change Default Comments Submit Button Colors', 'the-clean-blog' ),
		'panel'          => 'comments_colors',
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 7.7.3.1- Comments Submit Text Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'comments_submit_text_color',
		'label'     => __( 'Comments Submit Text Color', 'the-clean-blog' ),
		'section'   => 'comments_submit_button_colors',
		'default'   => '#000008',
		'priority'  => 5,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.form-submit input[type="submit"]',
				'property' => 'color',
			),
		),
	)
);
// 7.7.3.2- Comments Submit Background Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'color-alpha',
		'settings'  => 'comments_submit_background_color',
		'label'     => __( 'Comments Submit Background Color', 'the-clean-blog' ),
		'section'   => 'comments_submit_button_colors',
		'default'   => '#e6e6e6',
		'priority'  => 10,
		'transport' => 'auto',
		'output'    => array(
			array(
				'element'  => '.form-submit input[type="submit"]',
				'property' => 'background',
			),
		),
	)
);
// 7.7.3.3- Comments Submit Borders Colors
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'      => 'multicolor',
		'settings'  => 'comments_submit_borders_colors',
		'label'     => __( 'Comments Submit Borders Colors', 'the-clean-blog' ),
		'section'   => 'comments_submit_button_colors',
		'default'   => array(
			'border-top-color'    => '#ccc',
			'border-right-color'  => '#ccc',
			'border-bottom-color' => '#bbb',
			'border-left-color'   => '#ccc',
		),
		'priority'  => 15,
		'transport' => 'auto',
		'choices'   => array(
			'border-top-color'    => esc_attr__( 'Border Top', 'the-clean-blog' ),
			'border-right-color'  => esc_attr__( 'Border Right', 'the-clean-blog' ),
			'border-bottom-color' => esc_attr__( 'Border Bottom', 'the-clean-blog' ),
			'border-left-color'   => esc_attr__( 'Border Left', 'the-clean-blog' ),
		),
		'output'    => array(
			array(
				'element'  => '.form-submit input[type="submit"]',
				'property' => 'border-color',
			),
		),
	)
);

// 8- Slider Section and Settings
The_Clean_Blog_Kirki::add_section(
	'slider_settings',
	array(
		'title'           => __( 'Slider Settings', 'the-clean-blog' ),
		'description'     => __( 'Control the slider settings', 'the-clean-blog' ),
		'panel'           => 'thecleanblog_theme',
		'priority'        => 25,
		'capability'      => 'edit_theme_options',
		'theme_supports'  => '', // Rarely needed.
		'active_callback' => 'is_home',
	)
);
// 8.1- Activate Slider !
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'        => 'switch',
		'settings'    => 'activate_slider',
		'label'       => __( 'Activate Slider', 'the-clean-blog' ),
		'description' => __( 'You can choose to display on your homepage (Your latest posts) a static header background image or a slider of header background images of posts from a choosen category.', 'the-clean-blog' ),
		'section'     => 'slider_settings',
		'default'     => '0',
		'priority'    => 5,
		'choices'     => array(
			'on'  => esc_attr__( 'Enable', 'the-clean-blog' ),
			'off' => esc_attr__( 'Disable', 'the-clean-blog' ),
		),
	)
);
// 8.2 Choose Slider Category
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'select',
		'settings'        => 'slider_category',
		'label'           => __( 'Choose a category', 'the-clean-blog' ),
		'description'     => __( 'Choose the category of posts for the slider.', 'the-clean-blog' ),
		'tooltip'         => 'Please, be sure to have <b>AT LEAST ONE</b> post in the chosen category !',
		'section'         => 'slider_settings',
		'default'         => '',
		'priority'        => 10,
		'multiple'        => 1,
		'choices'         => ( class_exists( 'Kirki_Helper' ) ) ? Kirki_Helper::get_terms(
			array( // Check if the class Kirki_Helper exists. This will prevent the theme on activation from returning a fatal error if the plugin is not yet installed !
				'taxonomy' => 'category',
				'exclude'  => 1, /**
						* Exclude uncategorized category from the dropdown categories because resizeH1() not working with it !
						*
						* @see https://developer.wordpress.org/reference/functions/get_terms/
						* @see https://developer.wordpress.org/reference/classes/wp_term_query/__construct/
						*/
			)
		) : array(),
		'active_callback' => array( // Do not display this control if the slider is disabled.
			array(
				'setting'  => 'activate_slider',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
// 8.3 Choose Number of Posts for Slider
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'slider',
		'settings'        => 'slider_number_of_posts',
		'label'           => __( 'Set the number of posts/slides', 'the-clean-blog' ),
		'description'     => __( 'Set the number of posts/slides for the slider.', 'the-clean-blog' ),
		'section'         => 'slider_settings',
		'default'         => 2,
		'priority'        => 15,
		'choices'         => array(
			'min'  => '2',
			'max'  => '10',
			'step' => '1',
		),
		'active_callback' => array( // Do not display this control if the slider is disabled.
			array(
				'setting'  => 'activate_slider',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
// 8.4 Choose Slider Animation
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'select',
		'settings'        => 'slider_animation',
		'label'           => __( 'Choose Slider Animation', 'the-clean-blog' ),
		'section'         => 'slider_settings',
		'default'         => 'horizontal',
		'priority'        => 20,
		'multiple'        => 1,
		'choices'         => array(
			'horizontal' => esc_attr__( 'horizontal', 'the-clean-blog' ),
			'vertical'   => esc_attr__( 'vertical', 'the-clean-blog' ),
			'fade'       => esc_attr__( 'fade', 'the-clean-blog' ),
		),
		'active_callback' => array( // Do not display this control if the slider is disabled.
			array(
				'setting'  => 'activate_slider',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
// 8.5 Slider Slides loop
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'toggle',
		'settings'        => 'slider_slides_loop',
		'label'           => __( 'Choose the slides loop', 'the-clean-blog' ),
		'description'     => __( 'Choose to make the slides loop infinitely or not.', 'the-clean-blog' ),
		'section'         => 'slider_settings',
		'default'         => '0',
		'priority'        => 25,
		'active_callback' => array( // Do not display this control if the slider is disabled.
			array(
				'setting'  => 'activate_slider',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);
// 8.6 Horizontal animation direction
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'toggle',
		'settings'        => 'slider_horizontal_slides_direction',
		'label'           => __( 'Horizontal animation direction', 'the-clean-blog' ),
		'description'     => __( 'Change animation from right to left.', 'the-clean-blog' ),
		'section'         => 'slider_settings',
		'default'         => '0',
		'priority'        => 30,
		'active_callback' => array( // Do not display this control if the slider is disabled.
			array(
				'setting'  => 'activate_slider',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

// 9- Preloader Section and Settings
The_Clean_Blog_Kirki::add_section(
	'preloader_settings',
	array(
		'title'          => __( 'Preloader Settings', 'the-clean-blog' ),
		'description'    => __( 'Control LoadingOverlay settings', 'the-clean-blog' ),
		'panel'          => 'thecleanblog_theme',
		'priority'       => 30,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 9.1- Activate Preloader !
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'        => 'switch',
		'settings'    => 'activate_preloader',
		'label'       => __( 'Activate Preloader', 'the-clean-blog' ),
		'description' => __( 'Choose to display a preloader or not !', 'the-clean-blog' ),
		'section'     => 'preloader_settings',
		'default'     => '0',
		'priority'    => 5,
		'choices'     => array(
			'on'  => esc_attr__( 'Enable', 'the-clean-blog' ),
			'off' => esc_attr__( 'Disable', 'the-clean-blog' ),
		),
	)
);
/**
 * Function to check if preloader is activated.
 */
function is_preloader_activated() {
	// Check if the preloader is activated.
	return get_theme_mod( 'activate_preloader' ) == true;
}
// 9.2- Preloader on Homepage Only !
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'toggle',
		'settings'        => 'activate_preloader_homepage',
		'label'           => __( 'Preloader on Homepage Only', 'the-clean-blog' ),
		'description'     => __( 'Activate Preloader Only On Homepage', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '0',
		'priority'        => 10,
		'active_callback' => 'is_preloader_activated',
	)
);
// 9.3 Preloader Backgroung Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'preloader_background_color',
		'label'           => __( 'Preloader Background Color', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '#ed5565',
		'priority'        => 15,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element'  => '.preloader-wrapper',
				'property' => 'background',
			),
		),
		'active_callback' => 'is_preloader_activated',
	)
);
// 9.4 Preloader Animation
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'select',
		'settings'        => 'preloader_animation',
		'label'           => __( 'Choose Preloader Animation', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => 'ball-pulse-rise',
		'priority'        => 20,
		'multiple'        => 1,
		'choices'         => array(
			'ball-beat'                  => esc_attr__( 'Ball Beat', 'the-clean-blog' ),
			'ball-clip-rotate'           => esc_attr__( 'Ball Clip 1', 'the-clean-blog' ),
			'ball-clip-rotate-pulse'     => esc_attr__( 'Ball Clip 2', 'the-clean-blog' ),
			'ball-clip-rotate-multiple'  => esc_attr__( 'Ball Clip 3', 'the-clean-blog' ),
			'ball-grid-beat'             => esc_attr__( 'Ball Grid Beat', 'the-clean-blog' ),
			'ball-grid-pulse'            => esc_attr__( 'Ball Grid Pulse', 'the-clean-blog' ),
			'ball-pulse'                 => esc_attr__( 'Ball Pulse', 'the-clean-blog' ),
			'ball-pulse-rise'            => esc_attr__( 'Ball Pulse Rise', 'the-clean-blog' ),
			'ball-pulse-sync'            => esc_attr__( 'Ball Pulse Sync', 'the-clean-blog' ),
			'ball-rotate'                => esc_attr__( 'Ball Rotate', 'the-clean-blog' ),
			'ball-scale'                 => esc_attr__( 'Ball Scale 1', 'the-clean-blog' ),
			'ball-scale-multiple'        => esc_attr__( 'Ball Scale 2', 'the-clean-blog' ),
			'ball-scale-ripple'          => esc_attr__( 'Ball Scale 3', 'the-clean-blog' ),
			'ball-scale-ripple-multiple' => esc_attr__( 'Ball Scale 4', 'the-clean-blog' ),
			'ball-scale-random'          => esc_attr__( 'Ball Scale 5', 'the-clean-blog' ),
			'ball-spin-fade-loader'      => esc_attr__( 'Ball Spin', 'the-clean-blog' ),
			'ball-triangle-path'         => esc_attr__( 'Ball Triangle', 'the-clean-blog' ),
			'ball-zig-zag'               => esc_attr__( 'Ball Zigzag 1', 'the-clean-blog' ),
			'ball-zig-zag-deflect'       => esc_attr__( 'Ball Zigzag 2', 'the-clean-blog' ),
			'cube-transition'            => esc_attr__( 'Cube Transition', 'the-clean-blog' ),
			'line-scale'                 => esc_attr__( 'Line Scale 1', 'the-clean-blog' ),
			'line-scale-party'           => esc_attr__( 'Line Scale 2', 'the-clean-blog' ),
			'line-scale-pulse-out'       => esc_attr__( 'Line Scale 3', 'the-clean-blog' ),
			'line-scale-pulse-out-rapid' => esc_attr__( 'Line Scale 4', 'the-clean-blog' ),
			'line-spin-fade-loader'      => esc_attr__( 'Line Spin', 'the-clean-blog' ),
			'pacman'                     => esc_attr__( 'Pacman', 'the-clean-blog' ),
			'square-spin'                => esc_attr__( 'Square Spin', 'the-clean-blog' ),
			'triangle-skew-spin'         => esc_attr__( 'Triangle Spin', 'the-clean-blog' ),
		),
		'active_callback' => 'is_preloader_activated',
	)
);
// 9.5 Preloader Animation Color 1
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'preloader_animation_color_1',
		'label'           => esc_attr__( 'Preloader Animation Color Set 1', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '',
		'priority'        => 25,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element'  => '.loader-inner > div',
				'property' => 'background-color',
			),
		),
		'active_callback' => array( // Display this control if the animation is one of the following.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'ball-pulse-rise', 'ball-pulse', 'ball-grid-pulse', 'square-spin', 'cube-transition', 'ball-zig-zag', 'ball-zig-zag-deflect', 'ball-scale', 'line-scale', 'line-scale-party', 'ball-scale-multiple', 'ball-pulse-sync', 'ball-beat', 'line-scale-pulse-out', 'line-scale-pulse-out-rapid', 'ball-spin-fade-loader', 'line-spin-fade-loader', 'ball-scale-random' ),
			),
		),
	)
);
// 9.6 Preloader Animation Color 2
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'preloader_animation_color_2',
		'label'           => esc_attr__( 'Preloader Animation Color Set 2', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '2px solid #fff',
		'priority'        => 30,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element'  => '.loader-inner > div',
				'property' => 'border-color',
			),
		),
		'active_callback' => array( // Display this control if the animation is one of the following.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'ball-triangle-path', 'ball-scale-ripple', 'ball-scale-ripple-multiple' ),
			),
		),
	)
);
// 9.7.1 Ball Clip 1 Colors
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'multicolor',
		'settings'        => 'preloader_animation_ball_clip_1_colors',
		'label'           => esc_attr__( 'Ball Clip 1 Colors', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '2px solid #fff #fff transparent #fff',
		'choices'         => array(
			'border-top-color'   => esc_attr__( 'Border Top Color', 'the-clean-blog' ),
			'border-right-color' => esc_attr__( 'Border Right Color', 'the-clean-blog' ),
			'border-left-color'  => esc_attr__( 'Border Left Color', 'the-clean-blog' ),
		),
		'default'         => array(
			'border-top-color'   => '#fff',
			'border-right-color' => '#fff',
			'border-left-color'  => '#fff',
		),
		'priority'        => 35,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element' => '.loader-inner > div',
			),
		),
		'active_callback' => array( // Display this control if the animation is this one.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'ball-clip-rotate' ),
			),
		),
	)
);
// 9.7.2 Ball Rotate Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'preloader_animation_ball_rotate_color',
		'label'           => esc_attr__( 'Ball Rotate Color', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '#fff',
		'priority'        => 40,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element'  => '.loader-inner > div',
				'property' => 'background-color',
			),
		),
		'active_callback' => array( // Display this control if the animation is this one.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'ball-rotate' ),
			),
		),
	)
);
// 9.7.3 Balls Rotate Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'preloader_animation_balls_rotate_color',
		'label'           => esc_attr__( 'Balls Rotate Color', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => 'rgba(255, 255, 255, 0.8);',
		'priority'        => 45,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element'  => array( '.loader-inner > div:before', '.loader-inner > div:after' ),
				'property' => 'background-color',
			),
		),
		'active_callback' => array( // Display this control if the animation is this one.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'ball-rotate' ),
			),
		),
	)
);
// 9.8 Triangle Spin Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'preloader_animation_triangle_spin_color',
		'label'           => esc_attr__( 'Triangle Spin Color', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '#fff',
		'priority'        => 50,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element'  => '.loader-inner > div',
				'property' => 'border-bottom-color',
			),
		),
		'active_callback' => array( // Display this control if the animation is this one.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'triangle-skew-spin' ),
			),
		),
	)
);
// 9.9.1 Ball Clip 2 Internal Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'preloader_animation_bal_clip_2_internal_color',
		'label'           => esc_attr__( 'Ball Clip 2 Internal Color', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '#fff',
		'priority'        => 55,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element'  => '.loader-inner > div:first-child',
				'property' => 'background',
			),
		),
		'active_callback' => array( // Display this control if the animation is this one.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'ball-clip-rotate-pulse' ),
			),
		),
	)
);
// 9.9.2 Ball Clip 2 External Colors
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'multicolor',
		'settings'        => 'preloader_animation_ball_clip_2_external_colors',
		'label'           => esc_attr__( 'Ball Clip 2 External Colors', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '2px solid #fff transparent #fff transparent',
		'choices'         => array(
			'border-top-color'    => esc_attr__( 'Border Top Color', 'the-clean-blog' ),
			'border-bottom-color' => esc_attr__( 'Border Bottom Color', 'the-clean-blog' ),
		),
		'default'         => array(
			'border-top-color'    => '#fff',
			'border-bottom-color' => '#fff',
		),
		'priority'        => 60,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element' => '.loader-inner > div:last-child',
			),
		),
		'active_callback' => array( // Display this control if the animation is this one.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'ball-clip-rotate-pulse' ),
			),
		),
	)
);
// 9.10.1 Ball Clip 3 Internal Colors
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'multicolor',
		'settings'        => 'preloader_animation_ball_clip_3_internal_colors',
		'label'           => esc_attr__( 'Ball Clip 3 Internal Colors', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '2px solid #fff transparent #fff transparent',
		'choices'         => array(
			'border-top-color'    => esc_attr__( 'Border Top Color', 'the-clean-blog' ),
			'border-bottom-color' => esc_attr__( 'Border Bottom Color', 'the-clean-blog' ),
		),
		'default'         => array(
			'border-top-color'    => '#fff',
			'border-bottom-color' => '#fff',
		),
		'priority'        => 65,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element' => '.loader-inner > div:last-child',
			),
		),
		'active_callback' => array( // Display this control if the animation is this one.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'ball-clip-rotate-multiple' ),
			),
		),
	)
);
// 9.10.2 Ball Clip 3 External Colors
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'multicolor',
		'settings'        => 'preloader_animation_ball_clip_3_external_colors',
		'label'           => esc_attr__( 'Ball Clip 3 External Colors', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '2px solid transparent #fff transparent #fff',
		'choices'         => array(
			'border-right-color' => esc_attr__( 'Border Right Color', 'the-clean-blog' ),
			'border-left-color'  => esc_attr__( 'Border Left Color', 'the-clean-blog' ),
		),
		'default'         => array(
			'border-right-color' => '#fff',
			'border-left-color'  => '#fff',
		),
		'priority'        => 70,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element' => '.loader-inner > div',
			),
		),
		'active_callback' => array( // Display this control if the animation is this one.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'ball-clip-rotate-multiple' ),
			),
		),
	)
);
// 9.11.1 Pacman Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'multicolor',
		'settings'        => 'preloader_animation_pacman_color',
		'label'           => esc_attr__( 'Pacman Color', 'the-clean-blog' ),
		'description'     => esc_attr__( 'PLEASE CHOOSE THE SAME COLOR FOR THE PACMAN OR IT WILL NOT WORK !', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '25px solid #fff transparent #fff #fff',
		'choices'         => array(
			'border-top-color'    => esc_attr__( 'Border Top Color', 'the-clean-blog' ),
			'border-bottom-color' => esc_attr__( 'Border Bottom Color', 'the-clean-blog' ),
			'border-left-color'   => esc_attr__( 'Border Left Color', 'the-clean-blog' ),
		),
		'default'         => array(
			'border-top-color'    => '#fff',
			'border-bottom-color' => '#fff',
			'border-left-color'   => '#fff',
		),
		'priority'        => 75,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element' => array( '.loader-inner > div:first-of-type', '.loader-inner > div:nth-child(2)' ),
			),
		),
		'active_callback' => array( // Display this control if the animation is this one.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'pacman' ),
			),
		),
	)
);
// 9.11.2 Pacman Balls Color
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'color-alpha',
		'settings'        => 'preloader_animation_pacman_balls_color',
		'label'           => esc_attr__( 'Pacman Balls Color', 'the-clean-blog' ),
		'description'     => esc_attr__( 'For a better animation, please choose the same color as the pacman !', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => '#fff',
		'priority'        => 80,
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element'  => '.loader-inner > div:nth-child(n+3)',
				'property' => 'background-color',
			),
		),
		'active_callback' => array( // Display this control if the animation is this one.
			array(
				'setting'  => 'preloader_animation',
				'operator' => 'in',
				'value'    => array( 'pacman' ),
			),
		),
	)
);
// 9.12 Choose Preloader Animation Dimension
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'slider',
		'settings'        => 'preloader_animation_dimension',
		'label'           => __( 'Choose Preloader Animation Dimension', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => 1,
		'priority'        => 85,
		'choices'         => array(
			'min'  => '0.5',
			'max'  => '2.5',
			'step' => '0.5',
		),
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element'       => '.loader-inner',
				'property'      => 'transform',
				'value_pattern' => 'scale($ , $)',
			),
		),
		'active_callback' => 'is_preloader_activated',
	)
);
// 9.13 Set Preloader Animation Time
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'slider',
		'settings'        => 'preloader_animation_time',
		'label'           => __( 'Set Preloader Animation Time', 'the-clean-blog' ),
		'section'         => 'preloader_settings',
		'default'         => 1500,
		'priority'        => 90,
		'choices'         => array(
			'min'  => '500',
			'max'  => '3000',
			'step' => '500',
		),
		'transport'       => 'refresh',
		'output'          => array(
			array(
				'element'       => '.preloader-wrapper',
				'property'      => ' transition-duration',
				'value_pattern' => '$',
			),
		),
		'active_callback' => 'is_preloader_activated',
	)
);

// Theme's Layouts Panel.
The_Clean_Blog_Kirki::add_panel(
	'theme_layouts',
	array(
		'priority'    => 5,
		'title'       => __( 'THEME\'S LAYOUTS', 'the-clean-blog' ),
		'description' => __( 'Customize Theme\'s Layouts', 'the-clean-blog' ),
		'panel'       => 'thecleanblog_theme',
	)
);
// 10.1- Change Site Layout
The_Clean_Blog_Kirki::add_section(
	'site_layouts_settings',
	array(
		'title'          => __( 'Change Site Layout', 'the-clean-blog' ),
		'description'    => __( 'Choose Site\'s Layout !', 'the-clean-blog' ),
		'panel'          => 'theme_layouts',
		'priority'       => 5,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
// 10.1.1- Site Layouts
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'radio-image',
		'settings'        => 'site_layouts',
		'label'           => __( 'Site Layouts', 'the-clean-blog' ),
		'section'         => 'site_layouts_settings',
		'default'         => 'fullwidth',
		'priority'        => 5,
		'choices'         => array(
			'fullwidth'     => plugins_url() . '/kirki/assets/images/1c.png',
			'sidebar-right' => plugins_url() . '/kirki/assets/images/2cr.png',
			'sidebar-left'  => plugins_url() . '/kirki/assets/images/2cl.png',
		),
		'active_callback' => 'is_home',
	)
);
// 10.2- Change Posts Layouts
The_Clean_Blog_Kirki::add_section(
	'posts_layouts_settings',
	array(
		'title'          => __( 'Change ALL Posts Layout', 'the-clean-blog' ),
		'description'    => __( 'Choose ALL Posts Layout !', 'the-clean-blog' ),
		'panel'          => 'theme_layouts',
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
/**
 * Function to check if we are viewing a post with no template.
 */
function is_only_single_no_template() {
	// Check if is_single returns true and is_page-template is false.
	return is_single() === true && ! is_page_template();
}
// 10.2.1- Posts Layouts
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'radio-image',
		'settings'        => 'posts_layouts',
		'label'           => __( 'ALL Posts Layouts', 'the-clean-blog' ),
		'description'     => __( 'This will change the layout of ALL posts. You can set a specific template for this post under the Post Attributes in administration.', 'the-clean-blog' ),
		'section'         => 'posts_layouts_settings',
		'default'         => 'fullwidth-posts',
		'priority'        => 5,
		'choices'         => array(
			'fullwidth-posts'     => plugins_url() . '/kirki/assets/images/1c.png',
			'sidebar-right-posts' => plugins_url() . '/kirki/assets/images/2cr.png',
			'sidebar-left-posts'  => plugins_url() . '/kirki/assets/images/2cl.png',
		),
		'active_callback' => 'is_only_single_no_template',
	)
);
// 10.3- Change Pages Layouts
The_Clean_Blog_Kirki::add_section(
	'pages_layouts_settings',
	array(
		'title'          => __( 'Change ALL Pages Layout', 'the-clean-blog' ),
		'description'    => __( 'Choose ALL Pages Layout !', 'the-clean-blog' ),
		'panel'          => 'theme_layouts',
		'priority'       => 15,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '', // Rarely needed.
	)
);
/**
 * Function to check if we are viewing a page with no template.
 */
function is_only_page_no_template() {
	// Check if is_page returns true and is_page-template is false.
	return is_page() === true && ! is_page_template();
}
// 10.3.1- Pages Layouts
The_Clean_Blog_Kirki::add_field(
	'thecleanblog',
	array(
		'type'            => 'radio-image',
		'settings'        => 'pages_layouts',
		'label'           => __( 'ALL Pages Layouts', 'the-clean-blog' ),
		'description'     => __( 'This will change the layout of ALL pages. You can set a specific template for this page under the Page Attributes in administration.', 'the-clean-blog' ),
		'section'         => 'pages_layouts_settings',
		'default'         => 'fullwidth-pages',
		'priority'        => 5,
		'choices'         => array(
			'fullwidth-pages'     => plugins_url() . '/kirki/assets/images/1c.png',
			'sidebar-right-pages' => plugins_url() . '/kirki/assets/images/2cr.png',
			'sidebar-left-pages'  => plugins_url() . '/kirki/assets/images/2cl.png',
		),
		'active_callback' => 'is_only_page_no_template',
	)
);
