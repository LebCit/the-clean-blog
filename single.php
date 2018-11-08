<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package The_Clean_Blog
 */

get_header();

?>
<?php get_template_part( 'components/main/main', 'template' ); ?>
	<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'components/post/content', get_post_format() );

			thecleanblog_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.

		?>

	</main>
</div>
<!-- #primary .content-area -->
<?php
get_sidebar();
get_footer();
