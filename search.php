<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package The_Clean_Blog
 */

get_header();

?>
<?php get_template_part( 'components/main/main', 'template' ); ?>
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					$search_results = get_theme_mod( 'search_results_page_text' );
					if ( empty( $search_results ) ) {
						/* translators: search text for results */
						$search_results = printf( esc_html__( 'Search Results for: %s', 'the-clean-blog' ), '<span>' . get_search_query() . '</span>' );
					} else {
						printf( esc_html( $search_results . ' %s' ), '<span>' . get_search_query() . '</span>' );
					}
					?>
				</h1>
			</header>
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'components/post/content', 'search' );

			endwhile;

			thecleanblog_posts_navigation();

		else :

			get_template_part( 'components/post/content', 'none' );

		endif;

		?>

	</main>
</div>
<!-- #primary .content-area -->
<?php
get_sidebar();
get_footer();
