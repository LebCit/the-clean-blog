<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package The_Clean_Blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-preview' ); ?>>
	<header class="entry-header">
		<?php
		printf(
			'<a href="%s" title="%s" rel="bookmark"><h2 class="entry-title post-title">%s</h2></a>',
			esc_url( get_permalink() ),
			the_title_attribute( 'echo=0' ),
			esc_html( get_the_title() )
		);
		?>
	</header><!-- .entry-header -->

	<?php
	$featured_images_display_checkbox_value = get_theme_mod( 'featured_images_display_checkbox', true );
	if ( has_post_thumbnail() && true == $featured_images_display_checkbox_value ) : // phpcs:ignore
		thecleanblog_post_thumbnail();
	endif;
	?>

	<div class="entry-summary">
		<h3 class="post-subtitle">
			<?php the_excerpt(); ?>
		</h3>
		<?php if ( 'post' === get_post_type() ) : ?>
			<p class="entry-meta post-meta">
				<?php
				thecleanblog_posted_by();
				thecleanblog_posted_on();
				?>
			</p><!-- .entry-meta -->
		<?php endif; ?>
	</div><!-- .entry-summary -->

	<footer class="entry-footer">
		<?php thecleanblog_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
<hr>
