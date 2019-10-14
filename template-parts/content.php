<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package The_Clean_Blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-preview' ); ?>>
	<header class="entry-header">
		<?php
		if ( is_front_page() && is_home() || is_archive() ) :
			printf(
				'<a href="%s" title="%s" rel="bookmark"><h2 class="entry-title post-title">%s</h2></a>',
				esc_url( get_permalink() ),
				the_title_attribute( 'echo=0' ),
				esc_html( get_the_title() )
			);
		endif;
		?>
	</header><!-- .entry-header -->

	<?php
	$featured_images_display_checkbox_value = get_theme_mod( 'featured_images_display_checkbox', true );
	if ( is_front_page() && is_home() || is_archive() ) :
		if ( has_post_thumbnail() && true == $featured_images_display_checkbox_value ) : // phpcs:ignore
			thecleanblog_post_thumbnail();
		endif;
	endif;
	?>

	<div class="entry-content">
		<?php
		if ( is_singular() ) :
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'the-clean-blog' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'the-clean-blog' ),
					'after'  => '</div>',
				)
			);
		else :
			?>
			<h3 class="post-subtitle">
				<?php
				the_excerpt();
				?>
			</h3>
			<?php
			if ( 'post' === get_post_type() && ( is_front_page() && is_home() || is_archive() ) ) :
				?>
				<p class="entry-meta post-meta">
					<?php
					thecleanblog_posted_by();
					thecleanblog_posted_on();
					?>
				</p><!-- .entry-meta -->
				<?php
			endif;
		endif;
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php thecleanblog_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
<hr>
