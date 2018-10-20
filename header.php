<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package The_Clean_Blog
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class( "preloader-site" ); ?>> <!-- Add .preloader-site class to the body every time the page loads until the document is ready()  -->
        
        <!-- Preloader  -->
        <?php
		if ( get_theme_mod( 'activate_preloader' ) == true && get_theme_mod( 'activate_preloader_homepage' ) == true ) {
			if ( is_home() ) {
				?>
                <div class="preloader-wrapper">
                    <div class="preloader">
                        <div class="loader">
                            <div class="loader-inner <?php echo get_theme_mod( 'preloader_animation', 'ball-pulse-rise' ); ?>"></div>
                        </div>
                    </div>
                </div>
            <?php }
        } elseif ( get_theme_mod( 'activate_preloader' ) == true ) { ?>
            <div class="preloader-wrapper">
                <div class="preloader">
                    <div class="loader">
                        <div class="loader-inner <?php echo get_theme_mod( 'preloader_animation', 'ball-pulse-rise' ); ?>"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Preloader  -->
        
        <div id="page" class="site">
            <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'the-clean-blog'); ?></a>

            <!-- Navigation -->
            <header class="cb-nav">
                <?php get_template_part('components/navigation/navigation', 'top'); ?>
                <button class="search-trigger"><i class="icon-search"></i></button>
                <li class="search-trigger"><i class="icon-search"></i></li>
            </header>
            
            <main class="cb-main-content">

            <!-- Page Header -->
            <?php
            if (is_404()) {
                get_template_part('components/header/bg', '404');
            } elseif (is_search()) {
                get_template_part('components/header/bg', 'search');
            } else {
                get_template_part('components/header/bg', 'header');
            }

            ?>

            <!-- Main Content -->
            <div id="content" class="site-content container">
                <div class="row">