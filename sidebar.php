<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package The_Clean_Blog
 * @since The_Clean_Blog 18.11.09
 */

?>

<?php

if ( is_active_sidebar( 'sidebar-1' ) ) :
	if ( is_single() ) {

		$layout_value = get_theme_mod( 'posts_layouts', 'fullwidth-posts' );

		if ( 'fullwidth-posts' === $layout_value ) :
			?>
			<aside id="secondary" style="display:none">

			<?php elseif ( 'sidebar-right-posts' === $layout_value ) : ?>
			<aside id="secondary" class="sidebar widget-area col-md-4" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</aside><!-- .sidebar .col-md-4 -->

			<?php elseif ( 'sidebar-left-posts' === $layout_value ) : ?>
			<aside id="secondary" class="sidebar widget-area col-md-4 col-md-pull-8" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</aside><!-- .sidebar .col-md-4 .col-md-pull-8 -->

			<?php
			endif;
	} elseif ( is_page() ) {

		$layout_value = get_theme_mod( 'pages_layouts', 'fullwidth-pages' );

		if ( 'fullwidth-pages' === $layout_value ) :
			?>
			<aside id="secondary" style="display:none">

			<?php elseif ( 'sidebar-right-pages' === $layout_value ) : ?>
			<aside id="secondary" class="sidebar widget-area col-md-4" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</aside><!-- .sidebar .col-md-4 -->

			<?php elseif ( 'sidebar-left-pages' === $layout_value ) : ?>
			<aside id="secondary" class="sidebar widget-area col-md-4 col-md-pull-8" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</aside><!-- .sidebar .col-md-4 .col-md-pull-8 -->

			<?php
			endif;
	} else {

		$layout_value = get_theme_mod( 'site_layouts', 'fullwidth' );

		if ( 'fullwidth' === $layout_value ) :
			?>
			<aside id="secondary" style="display:none">

			<?php elseif ( 'sidebar-right' === $layout_value ) : ?>
			<aside id="secondary" class="sidebar widget-area col-md-4" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</aside><!-- .sidebar .col-md-4 -->

			<?php elseif ( 'sidebar-left' === $layout_value ) : ?>
			<aside id="secondary" class="sidebar widget-area col-md-4 col-md-pull-8" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</aside><!-- .sidebar .col-md-4 .col-md-pull-8 -->

			<?php
			endif;
	}
endif;
?>
