<?php
/**
 * Template Name: Generic Left Template
 * Template Post Type: post, page
 *
 * This is the template that displays any post/page in a choosen format.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-custom-page-templates-for-global-use
 *
 * @package The_Clean_Blog
 */

get_header();

?>
<div id="primary" class="content-area col-md-8 col-md-push-4">
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :
			the_post();

			if ( is_page() ) {
				get_template_part( 'components/page/content', 'page' );
			} elseif ( is_single() ) {
				get_template_part( 'components/post/content', get_post_format() );

				thecleanblog_post_navigation();
			}

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.

		?>

	</main>
</div>
<!-- #primary .content-area -->
<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<aside id="secondary" class="sidebar widget-area col-md-4 col-md-pull-8" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside><!-- .sidebar .col-md-4 .col-md-pull-8 -->
<?php endif; ?>
<?php
get_footer();
