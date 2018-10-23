<?php
/**
 * This file generates the background header image for search.php
 *
 * @package The_Clean_Blog
 */

$hero_img_search = get_theme_mod( 'search_header_background_image' );
if ( empty( $hero_img_search ) ) {
	$hero_img_search = get_template_directory_uri() . '/components/header/images/search-hero.jpg';
}

?>
<!-- Set background image for this header . -->
<header id="masthead" class="site-header intro-header" style="background-image: url('<?php echo esc_url( $hero_img_search ); ?>')" role="banner">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
				<div class="site-heading">
					<header class="entry-header">
						<h1 class="entry-title">
							<?php
							$search_title = get_theme_mod( 'search_page_title_text' );
							if ( empty( $search_title ) ) {
								$search_title = esc_html_e( 'Searching gives all answers', 'the-clean-blog' );
							} else {
								echo esc_html( $search_title );
							}
							?>
						</h1>
						<div class="strike bounce">
							<span>
								<a href="#content"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
							</span>
						</div>
						<h2 class="subheading">
							<?php
							$search_subtitle = get_theme_mod( 'search_page_subtitle_text' );
							if ( empty( $search_subtitle ) ) {
								$search_subtitle = esc_html_e( 'KEEP SEARCHING !', 'the-clean-blog' );
							} else {
								echo esc_html( $search_subtitle );
							}
							?>
						</h2>
					</header>
				</div>
			</div>
		</div>
	</div>
</header>
