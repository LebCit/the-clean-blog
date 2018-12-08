<?php
/**
 * This file generates the background header image with the title and the subtitle.
 *
 * The background image is added by using inline style.
 *
 * @see the-clean-blog-functions.php | thecleanblog_header_style()
 *
 * @package The_Clean_Blog
 */

?>

<?php if ( false === get_theme_mod( 'activate_slider', false ) || is_singular() || is_archive() ) : ?>
<header id="masthead" class="site-header intro-header" role="banner">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
				<div class="site-heading">
					<header class="entry-header">
	<?php
	if ( is_front_page() && is_home() ) {
		?>
						<h1 id="responsive_headline" class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<?php
								// Getting 'blogname' option.
								$tcb_blogname = get_option( 'blogname' );
								/**
								 * Parsing home_url().
								 *
								 * @see https://developer.wordpress.org/reference/functions/wp_parse_url/
								 * @see https://developer.wordpress.org/reference/functions/home_url/
								 */
								$tcb_home_url_parts = wp_parse_url( home_url() );
								if ( empty( $tcb_blogname ) ) {
									// Using esc_html since 'host' is a string.
									echo esc_html( $tcb_home_url_parts['host'] );
								} else {
									bloginfo( 'name' );
								}
								?>
							</a>
						</h1>
		<?php
	} elseif ( is_single() || is_sticky() ) {
		the_title( '<h1 class="entry-title">', '</h1>' );
	} elseif ( is_archive() ) {
		the_archive_title( '<h1 class="entry-title">', '</h1>' );
	} else {
		the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );
	}
	?>

						<div class="strike bounce">
							<span>
								<a href="#content"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
							</span>
						</div>

						<h2 class="subheading">
	<?php
	if ( is_front_page() && is_home() ) {
		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) :
			?>
								<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
			<?php
		endif; } elseif ( is_single() ) {
		thecleanblog_posted_on();
		}
		?>
						</h2>
					</header>                                             
				</div>
			</div>
		</div>
	</div>
</header>
	<?php
else :
	get_template_part( 'components/header/bg', 'slider' );
endif;
