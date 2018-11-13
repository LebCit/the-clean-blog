<?php
/**
 * Main header part for main files
 *
 * Displays the layout structure depending on the user's choice.
 *
 * @package The_Clean_Blog
 * @since The_Clean_Blog 18.11.09
 */

if ( is_single() ) {

	$layout_value = get_theme_mod( 'posts_layouts', 'fullwidth-posts' );

	if ( 'fullwidth-posts' === $layout_value ) :
		?>
		<div id="primary" class="content-area col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

		<?php elseif ( 'sidebar-right-posts' === $layout_value ) : ?>
		<div id="primary" class="content-area col-md-8">

		<?php elseif ( 'sidebar-left-posts' === $layout_value ) : ?>
		<div id="primary" class="content-area col-md-8 col-md-push-4">

		<?php
		endif;
} elseif ( is_page() ) {

	$layout_value = get_theme_mod( 'pages_layouts', 'fullwidth-pages' );

	if ( 'fullwidth-pages' === $layout_value ) :
		?>
		<div id="primary" class="content-area col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

		<?php elseif ( 'sidebar-right-pages' === $layout_value ) : ?>
		<div id="primary" class="content-area col-md-8">

		<?php elseif ( 'sidebar-left-pages' === $layout_value ) : ?>
		<div id="primary" class="content-area col-md-8 col-md-push-4">

		<?php
		endif;
} else {

	$layout_value = get_theme_mod( 'site_layouts', 'fullwidth' );

	if ( 'fullwidth' === $layout_value ) :
		?>
		<div id="primary" class="content-area col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">

		<?php elseif ( 'sidebar-right' === $layout_value ) : ?>
		<div id="primary" class="content-area col-md-8">

		<?php elseif ( 'sidebar-left' === $layout_value ) : ?>
		<div id="primary" class="content-area col-md-8 col-md-push-4">

		<?php endif;
}
?>
