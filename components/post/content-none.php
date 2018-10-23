<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package The_Clean_Blog
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title">
			<?php
			$search_no_results_title = get_theme_mod( 'search_no_results_page_title_text' );
			if ( empty( $search_no_results_title ) ) {
				$search_no_results_title = esc_html_e( 'Nothing Found', 'the-clean-blog' );
			} else {
				echo esc_html( $search_no_results_title );
			}
			?>
		</h1>
	</header>
	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<?php /* translators: Users' message to publish first post */ ?>
			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'the-clean-blog' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p>
				<?php
				$search_no_results_paragraph = get_theme_mod( 'search_no_results_page_paragraph_text' );
				if ( empty( $search_no_results_paragraph ) ) {
					$search_no_results_paragraph = esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'the-clean-blog' );
				} else {
					echo esc_html( $search_no_results_paragraph );
				}
				?>
			</p>
			<?php
			get_search_form();

		else :

			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'the-clean-blog' ); ?></p>
			<?php
			get_search_form();

		endif;

		?>
	</div>
</section><!-- .no-results -->
