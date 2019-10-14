<?php
/**
 * This file generates the background header image with the title and the subtitle in header.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package The_Clean_Blog
 */

?>

<header id="masthead" class="site-header masthead"
	<?php
	/**
	 * Set Cutom Header as background-image of site-header on Homepage.
	 *
	 * @see https://developer.wordpress.org/themes/functionality/custom-headers/#function-reference
	 * @see https://developer.wordpress.org/reference/functions/header_image/
	 */
	if ( is_front_page() && is_home() && get_header_image() ) :
		?>
		style="background-image:url(<?php header_image(); ?>)"
		<?php
	elseif ( is_front_page() && is_home() && ! get_header_image() ) :
		?>
		style="background-image:url(<?php echo esc_url( get_theme_file_uri( '/img/default-home.jpg' ) ); ?>)"
		<?php
	elseif ( is_single() && has_post_thumbnail() ) :
		$single_header_background = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		?>
		style="background-image:url(<?php echo esc_url( $single_header_background[0] ); ?>)"
		<?php
	elseif ( is_page() && has_post_thumbnail() ) :
		$page_header_background = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		?>
		style="background-image:url(<?php echo esc_url( $page_header_background[0] ); ?>)"
		<?php
	elseif ( is_search() ) :
		?>
		style="background-image:url(<?php echo esc_url( get_theme_file_uri( '/img/default-search.jpg' ) ); ?>)"
		<?php
	elseif ( is_404() ) :
		?>
		style="background-image:url(<?php echo esc_url( get_theme_file_uri( '/img/default-404.jpg' ) ); ?>)"
		<?php
	elseif ( is_category() || is_tag() ) :
		?>
		style="background-image:url(<?php echo esc_url( get_theme_file_uri( '/img/default-archive.jpg' ) ); ?>)"
		<?php
	elseif ( is_author() ) :
		?>
		style="background-image:url(<?php echo esc_url( get_theme_file_uri( '/img/default-author.jpg' ) ); ?>)"
		<?php
	elseif ( is_date() ) :
		?>
		style="background-image:url(<?php echo esc_url( get_theme_file_uri( '/img/default-date.jpg' ) ); ?>)"
		<?php
	endif;
	?>
	>
	<div class="overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-10 mx-auto">
			<?php
			if ( is_front_page() && is_home() ) :
				?>
				<div class="site-heading site-branding">
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
					<?php
					$thecleanblog_description = get_bloginfo( 'description', 'display' );
					if ( $thecleanblog_description || is_customize_preview() ) :
						?>
						<span class="site-description subheading"><?php echo esc_html( $thecleanblog_description ); ?></span>
					<?php endif; ?>
				</div>
				<?php
			elseif ( is_single() ) :
				?>
				<div class="post-heading">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-meta meta">
					<?php
					thecleanblog_posted_by();
					thecleanblog_posted_on();
					?>
					</div><!-- .entry-meta -->
				</div>
				<?php
			elseif ( is_page() ) :
				?>
				<header class="entry-header page-heading">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->
				<?php
			elseif ( is_archive() ) :
				?>
				<header class="page-header page-heading">
					<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="archive-description subheading">', '</div>' );
					?>
				</header><!-- .page-header -->
				<?php
			elseif ( is_search() ) :
				?>
				<header class="page-header page-heading">
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'the-clean-blog' ), '<span>' . get_search_query() . '</span>' );
						?>
					</h1>
				</header><!-- .page-header -->
				<?php
			elseif ( is_404() ) :
				?>
				<header class="page-header page-heading">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'the-clean-blog' ); ?></h1>
				</header><!-- .page-header -->
				<?php
			endif;
			?>
			</div><!-- .col-lg-8.col-md-10.mx-auto -->
		</div><!-- .row -->
	</div><!-- .container -->

</header><!-- #masthead -->
