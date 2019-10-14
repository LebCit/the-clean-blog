<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package The_Clean_Blog
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
// Shim for backwards compatibility of wp_body_open.
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} else {
	do_action( 'wp_body_open' );
}
?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'the-clean-blog' ); ?></a>

	<!-- Navigation -->
	<nav id="mainNav" class="navbar navbar-expand-lg navbar-light fixed-top" role="navigation">
		<div class="container">
			<?php the_custom_logo(); ?>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<?php esc_html_e( 'Menu', 'the-clean-blog' ); ?>
				<span class="navbartogglericon"></span>
			</button>
			<?php
			wp_nav_menu(
				array(
					'container'       => 'div',
					'container_class' => 'collapse navbar-collapse',
					'container_id'    => 'navbarResponsive',
					'menu_class'      => 'navbar-nav ml-auto',
					'theme_location'  => 'menu-1',
					'fallback_cb'     => 'thecleanblog_fallback_menu',
				)
			);
			?>
		</div>
	</nav><!-- #mainNav -->

	<!-- Page Header -->
	<?php
	$homepage_slider_checkbox_value = get_theme_mod( 'homepage_slider_checkbox', false );
	if ( is_front_page() && is_home() && true == $homepage_slider_checkbox_value ) : // phpcs:ignore
		get_template_part( 'template-parts/slider', 'masthead' );
	else :
		get_template_part( 'template-parts/masthead' );
	endif;
	?>

	<!-- Main Content -->
	<div id="content" class="site-content">
		<div class="container">
			<div class="row">
