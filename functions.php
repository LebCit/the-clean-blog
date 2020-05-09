<?php
/**
 * The Clean Blog functions and definitions
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
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on The Clean Blog, use a find and replace
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
				'menu-1' => esc_html__( 'Primary', 'the-clean-blog' ),
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
				'comment-list',
				'gallery',
				'caption',
			)
		);

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

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 50,
				'width'       => 160,
				'flex-width'  => false,
				'flex-height' => false,
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
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'thecleanblog_content_width', 640 );
}
add_action( 'after_setup_theme', 'thecleanblog_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function thecleanblog_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'the-clean-blog' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'the-clean-blog' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'thecleanblog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function thecleanblog_scripts() {
	wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/vendor/bootstrap/css/bootstrap.min.css' ), array(), filemtime( get_theme_file_path( '/vendor/bootstrap/css/bootstrap.min.css' ) ) );

	wp_enqueue_script( 'thecleanblog-navigation', get_template_directory_uri() . '/js/navigation.min.js', array(), filemtime( get_theme_file_path( '/js/navigation.min.js' ) ), true );

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'thecleanblog-fonts', '//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic|Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&display=swap', array(), wp_get_theme()->get( 'Version' ) );

	wp_enqueue_style( 'clean-blog', get_theme_file_uri( '/vendor/clean-blog/css/clean-blog.min.css' ), array(), filemtime( get_theme_file_path( '/vendor/clean-blog/css/clean-blog.min.css' ) ) );

	wp_enqueue_style( 'thecleanblog-style', get_theme_file_uri( '/style.min.css' ), array(), filemtime( get_theme_file_path( '/style.min.css' ) ) );

	wp_enqueue_script( 'slabtext', get_template_directory_uri() . '/vendor/slabtext/js/jquery.slabtext.min.js', array( 'jquery' ), filemtime( get_theme_file_path( '/vendor/slabtext/js/jquery.slabtext.min.js' ) ), true );

	wp_enqueue_script( 'thecleanblog-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), filemtime( get_theme_file_path( '/js/skip-link-focus-fix.js' ) ), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/vendor/bootstrap/js/bootstrap.bundle.min.js' ), array( 'jquery' ), filemtime( get_theme_file_path( '/vendor/bootstrap/js/bootstrap.bundle.min.js' ) ), true );

	wp_enqueue_script( 'clean-blog', get_theme_file_uri( '/vendor/clean-blog/js/clean-blog.min.js' ), array( 'jquery' ), filemtime( get_theme_file_path( '/vendor/clean-blog/js/clean-blog.min.js' ) ), true );
}
add_action( 'wp_enqueue_scripts', 'thecleanblog_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Give #wpadminbar a fixed position from 600px and under, using inline style since we can't use #wpadminbar in CSS.
 * Give #mainNav a fixed position from 991px and under, overriding defaults.
 */
function thecleanblog_wp_adminbar_main_nav() {
	$wp_adminbar_main_nav = '
		@media screen and (max-width: 600px) {
			#wpadminbar {
				position: fixed;
			}
		}
		@media screen and (max-width: 991px) {
			#mainNav {
				position: fixed;
			}
		}';
	wp_add_inline_style( 'clean-blog', $wp_adminbar_main_nav );
}
add_action( 'wp_enqueue_scripts', 'thecleanblog_wp_adminbar_main_nav' );

/**
 * Provide a fallback menu featuring a 'Home' link, if no other menu has been provided.
 * Add 'Create a new menu' link only if the current_user_can('edit_theme_options').
 */
function thecleanblog_fallback_menu() {
	$html                  = '<div id="navbarResponsive" class="collapse navbar-collapse">';
		$html             .= '<ul class="navbar-nav ml-auto">';
			$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-home">';
				$html     .= '<a href="' . esc_url( home_url() ) . '">';
					$html .= esc_html__( 'Home', 'the-clean-blog' );
				$html     .= '</a>';
			$html         .= '</li>';
	if ( current_user_can( 'edit_theme_options' ) ) {
		$html         .= '<li class="menu-item menu-item-type-custom menu-item-object-custom ">';
			$html     .= '<a href="' . esc_url( admin_url( 'nav-menus.php?action=edit&menu=0' ) ) . '">';
				$html .= esc_html__( 'Create a new menu', 'the-clean-blog' );
			$html     .= '</a>';
		$html         .= '</li>';
	}
		$html .= '</ul>';
	$html     .= '</div>';
	echo wp_kses(
		$html,
		array(
			'div' => array(
				'id'    => array(),
				'class' => array(),
			),
			'ul'  => array(
				'class' => array(),
			),
			'li'  => array(
				'class' => array(),
			),
			'a'   => array(
				'href' => array(),
			),
		)
	);
}

/**
 * Displays a bootstrap style breadcrumb.
 */
function thecleanblog_breadcrumb() {
	echo '<nav aria-label="breadcrumb">';
		echo '<ol class="breadcrumb">';
	if ( ! is_home() ) {
		echo '<li class="breadcrumb-item">
		<span class="dashicons dashicons-location" style="font-size: 32px;margin-right: 10px;"></span>
		<a href="';
		echo esc_url( home_url() );
		echo '">';
		echo 'Home';
		echo '</a></li>';
		if ( is_category() || is_single() ) {
			echo '<li class="breadcrumb-item">';
			the_category( ' </li><li class="breadcrumb-item"> ' );
			if ( is_single() ) {
				echo '</li><li class="breadcrumb-item">';
				esc_html( the_title() );
				echo '</li>';
			}
		} elseif ( is_page() ) {
			echo '<li class="breadcrumb-item">';
			echo esc_html( the_title() );
			echo '</li>';
		} elseif ( is_tag() ) {
			echo '<li class="breadcrumb-item">';
			single_tag_title();
			echo '</li>';
		} elseif ( is_day() ) {
			echo '<li class="breadcrumb-item">' . esc_html__( 'Archive for ', 'the-clean-blog' );
			the_time( 'F jS, Y' );
			echo '</li>';
		} elseif ( is_month() ) {
			echo '<li class="breadcrumb-item">' . esc_html__( 'Archive for ', 'the-clean-blog' );
			the_time( 'F, Y' );
			echo '</li>';
		} elseif ( is_year() ) {
			echo '<li class="breadcrumb-item">' . esc_html__( 'Archive for ', 'the-clean-blog' );
			the_time( 'Y' );
			echo '</li>';
		} elseif ( is_author() ) {
			echo '<li class="breadcrumb-item">' . esc_html__( 'Posted by : ', 'the-clean-blog' );
			the_author();
			echo '</li>';
		} elseif ( is_search() ) {
			echo '<li class="breadcrumb-item test">' . esc_html__( 'Search Results for : ', 'the-clean-blog' );
			echo get_search_query();
			echo '</li>';
		}
	}
		echo '</ol>';
	echo '</nav>';
}

/**
 * Filter the excerpt length to 15 words.
 *
 * @see https://developer.wordpress.org/reference/functions/the_excerpt/#comment-325
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function thecleanblog_custom_excerpt_length( $length ) {
	return 15;
}
add_filter( 'excerpt_length', 'thecleanblog_custom_excerpt_length', 999 );

/**
 * Filter the "read more" excerpt string link to the post.
 *
 * @see https://developer.wordpress.org/reference/functions/the_excerpt/#comment-327
 * @param string $more Link to the article.
 */
function thecleanblog_excerpt_more( $more ) {
	if ( ! is_single() ) {
		$more = sprintf(
			'<a href="%1$s" class="more-link btn btn-link">%2$s</a>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( __( 'Read More&hellip; %s', 'the-clean-blog' ), '<span class="screen-reader-text">' . esc_html( 'Continue reading ' ) . get_the_title( get_the_ID() ) . '</span>' )
		);
		return '&hellip; ' . $more;
	}
}
add_filter( 'excerpt_more', 'thecleanblog_excerpt_more' );

/**
 * Add "btn btn-primary" class to each anchor <a> of posts navigation.
 */
function thecleanblog_posts_link_attributes() {
	return 'class="btn btn-primary"';
}
add_filter( 'next_posts_link_attributes', 'thecleanblog_posts_link_attributes' );
add_filter( 'previous_posts_link_attributes', 'thecleanblog_posts_link_attributes' );

/**
 * Add "btn btn-primary" class to each anchor <a> of post navigation.
 *
 * @param string $output Output anchor of post navigation with class.
 */
function thecleanblog_post_link_attributes( $output ) {
	$code = 'class="btn btn-primary"';
	return str_replace( '<a href=', '<a ' . $code . ' href=', $output );
}
add_filter( 'next_post_link', 'thecleanblog_post_link_attributes' );
add_filter( 'previous_post_link', 'thecleanblog_post_link_attributes' );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function thecleanblog_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'thecleanblog_search_form_modify' );

/**
 * Create and return an array containing the names of the social sites.
 */
function thecleanblog_social_sites() {
	/* store social sites names in array */
	$social_sites = array(
		'facebook'  => '',
		'twitter'   => '',
		'linkedin'  => '',
		'instagram' => '',
		'youtube'   => '',
		'pinterest' => '',
		'wordpress' => '',
		'github'    => '',
		'email'     => '',
	);

	// Filtering the function, allowing user(s) to add more social sites in child theme.
	return apply_filters( 'thecleanblog_social_sites', $social_sites );
}

/**
 * Get user input from the Customizer and output the linked social media site icon.
 */
function thecleanblog_social_media_icons() {
	$social_sites = thecleanblog_social_sites();

	/* any inputs that aren't empty are stored in $active_sites array */
	foreach ( $social_sites as $social_site => $profile ) {
		if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
			$active_sites[] = $social_site;
		}
	}

	/* for each active social site, add it as a list item */
	if ( ! empty( $active_sites ) ) {

		foreach ( $active_sites as $key => $active_site ) {

			/* setup the class */
			$class = 'tcb-' . $active_site;

			if ( 'email' === $active_site ) {
				?>
				<li class="list-inline-item tcb-email">
					<a target="_blank" href="mailto:<?php echo esc_attr( antispambot( is_email( get_theme_mod( $active_site ) ) ) ); ?>">
						<span class="screen-reader-text">
							<?php echo esc_html( 'Email Address' ); ?>
						</span>
					</a>
				</li>
				<?php

			} else {
				?>
				<li class="list-inline-item <?php echo esc_attr( $class ); ?>">
					<a target="_blank" rel="noreferrer" href="<?php echo esc_url( get_theme_mod( $active_site ) ); ?>">
						<span class="screen-reader-text">
							<?php echo esc_html( ucfirst( $active_site ) . ' link' ); ?>
						</span>
					</a>
				</li>
				<?php

			}
		}
	}
}

/**
 * Output the theme's footer depending on user's choice.
 */
function thecleanblog_site_info() {
	$footer_copyright_area_checkbox = get_theme_mod( 'footer_copyright_area_checkbox', true );
	$custom_copyright_textarea      = get_theme_mod( 'custom_copyright_textarea', '' );
	if ( ! empty( $footer_copyright_area_checkbox ) ) :
			$html  = '<a href="' . esc_url( 'https://wordpress.org/' ) . '">' . esc_html( 'Proudly powered by WordPress' ) . '</a>';
			$html .= '<span class="sep"> | </span>';
			$html .= esc_html( 'Theme: the-clean-blog by ' ) . '<a href="' . esc_url( 'https://lebcit.github.io/' ) . '">' . esc_html( 'LebCit' ) . '</a>.';
			echo wp_kses(
				$html,
				array(
					'a'    => array(
						'href' => array(),
					),
					'span' => array(
						'class' => array(),
					),
				)
			);
	elseif ( empty( $footer_copyright_area_checkbox ) && ! empty( $custom_copyright_textarea ) ) :
		echo wp_kses_post( $custom_copyright_textarea ); // Allow html.
	endif;
}
