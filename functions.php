<?php
/**
 * The Clean Blog functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package The_Clean_Blog
 */

if ( ! function_exists( 'thecleanblog_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function thecleanblog_setup() {
		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on components, use a find and replace
		 * to change 'the-clean-blog' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'the-clean-blog', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Top', 'the-clean-blog' ),
			)
		);

		/**
		 * Add support for core custom logo.
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 23,
				'width'       => 124,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'gallery',
				'caption',
			)
		);

		/*
		 * Add callback for custom TinyMCE editor stylesheet.
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
		 */
		add_editor_style( 'css/editor-style.css' );

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'thecleanblog_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'thecleanblog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function thecleanblog_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'thecleanblog_content_width', 750 );
}
add_action( 'after_setup_theme', 'thecleanblog_content_width', 0 );

/**
 * Return early if Custom Logos are not available.
 *
 * @todo Remove after WP 4.7
 */
function thecleanblog_the_custom_logo() {
	if ( ! function_exists( 'the_custom_logo' ) ) {
		return;
	} else {
		the_custom_logo();
	}
}

/**
 * Enqueue scripts and styles.
 */
function thecleanblog_scripts() {
	wp_enqueue_style( 'thecleanblog-style', get_stylesheet_uri(), array(), filemtime( get_theme_file_path( '/style.css' ) ) );

	wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/css/bootstrap.min.css' ), array(), filemtime( get_theme_file_path( '/css/bootstrap.min.css' ) ) );

	wp_enqueue_style( 'thecleanblog-nav-style', get_theme_file_uri( '/css/the-clean-blog-nav-style.css' ), array(), filemtime( get_theme_file_path( '/css/the-clean-blog-nav-style.css' ) ) );

	wp_enqueue_style( 'thecleanblog-main-style', get_theme_file_uri( '/css/the-clean-blog.css' ), array(), filemtime( get_theme_file_path( '/css/the-clean-blog.css' ) ) );

	wp_enqueue_style( 'font-awesome', get_theme_file_uri( '/fa/css/font-awesome.min.css' ), array(), filemtime( get_theme_file_path( '/fa/css/font-awesome.min.css' ) ) );

	wp_enqueue_style( 'loaders', get_theme_file_uri( '/css/loaders.min.css' ), array(), filemtime( get_theme_file_path( '/css/loaders.min.css' ) ) );

	wp_enqueue_style( 'thecleanblog-lora', '//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic', array(), wp_get_theme()->get( 'Version' ) );

	wp_enqueue_style( 'thecleanblog-open-sans', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800', array(), wp_get_theme()->get( 'Version' ) );

	wp_enqueue_script( 'thecleanblog-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array(), '20151215', true );

	wp_enqueue_script( 'thecleanblog-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '20151215', true );

	wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/assets/js/bootstrap.min.js' ), array( 'jquery' ), '3.3.7', true );

	wp_enqueue_script( 'thecleanblog-nav-script', get_theme_file_uri( '/assets/js/the-clean-blog-nav.js' ), array( 'jquery' ), filemtime( get_theme_file_path( '/assets/js/the-clean-blog-nav.js' ) ), true );
	$nav_settings = array(
		'thecleanblog_menu'        => esc_html__( 'Menu', 'the-clean-blog' ),
		'thecleanblog_placeholder' => esc_html__( 'Placeholder', 'the-clean-blog' ),
	);
	wp_localize_script( 'thecleanblog-nav-script', 'thecleanblog_nav_set', $nav_settings );

	wp_enqueue_script( 'loaders.css', get_theme_file_uri( '/assets/js/loaders.css.js' ), array( 'jquery' ), filemtime( get_theme_file_path( '/assets/js/loaders.css.js' ) ), true );

	// Localize the-clean-blog.js to pass php variables to JS.
	wp_enqueue_script( 'thecleanblog-script', get_theme_file_uri( '/assets/js/the-clean-blog.js' ), array( 'jquery' ), filemtime( get_theme_file_path( '/assets/js/the-clean-blog.js' ) ), true );
	$thecleanblog_settings = array(
		'thecleanblog_slider_activated'                   => true == get_theme_mod( 'activate_slider', false ),
		'thecleanblog_slider_animation'                   => get_theme_mod( 'slider_animation', 'horizontal' ),
		'thecleanblog_slider_slides_loop'                 => get_theme_mod( 'slider_slides_loop', 0 ),
		'thecleanblog_slider_horizontal_slides_direction' => get_theme_mod( 'slider_horizontal_slides_direction', 0 ),
		'thecleanblog_preloader_animation_time'           => get_theme_mod( 'preloader_animation_time', 1500 ),
	);
	wp_localize_script( 'thecleanblog-script', 'thecleanblog_set', $thecleanblog_settings );

	wp_enqueue_script( 'unslider', get_theme_file_uri( '/assets/js/unslider.js' ), array( 'jquery' ), '2.0', true );

	wp_enqueue_script( 'footer-reveal', get_theme_file_uri( '/assets/js/footer-reveal.min.js' ), array( 'jquery' ), filemtime( get_theme_file_path( '/assets/js/footer-reveal.min.js' ) ), true );

	wp_enqueue_script( 'jquery-scrollup', get_theme_file_uri( '/assets/js/jquery.scrollUp.min.js' ), array( 'jquery' ), '2.4.1', true );

	if ( get_post_gallery() ) {
		wp_enqueue_script( 'imagelightbox', get_theme_file_uri( '/assets/js/imagelightbox.min.js' ), array( 'jquery' ), filemtime( get_theme_file_path( '/assets/js/imagelightbox.min.js' ) ), true );
		wp_enqueue_script( 'imagegallery', get_theme_file_uri( '/assets/js/imagegallery.js' ), array( 'jquery', 'imagelightbox' ), filemtime( get_theme_file_path( '/assets/js/imagegallery.js' ) ), true );
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'thecleanblog_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/the-clean-blog-kirki.php';
require get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/include-kirki.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Require The Clean Blog Theme custom functions.
 */
require get_template_directory() . '/inc/the-clean-blog-functions.php';
