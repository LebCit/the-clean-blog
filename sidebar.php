<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package The_Clean_Blog
 * @since The_Clean_Blog 18.11.08
 */

?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<aside id="secondary" class="sidebar widget-area col-md-4" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside><!-- .sidebar .col-md-4 -->
<?php endif; ?>
