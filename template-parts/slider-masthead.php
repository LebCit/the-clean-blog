<?php
/**
 * This file generates the background header image with the title and the subtitle for the slider in header.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package The_Clean_Blog
 */

?>

<header id="masthead" class="site-header masthead">
	<div class="overlay"></div>
	<div id="carouselIndicators" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner" role="listbox">
			<!-- Slides -->
			<?php
			$carousel = new WP_Query(
				array(
					'posts_per_page' => 3,
					'category_name'  => 'slider',
				)
			);
			if ( $carousel->have_posts() ) :
				while ( $carousel->have_posts() ) :
					$carousel->the_post();
					?>
					<div class="carousel-item <?php echo $carousel->current_post >= 1 ? '' : 'active'; ?>"
					<?php
					if ( has_post_thumbnail() ) :
						$slider_background = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
						?>
					style="background-image: url(<?php echo esc_url( $slider_background[0] ); ?>)"
						<?php
						endif;
					?>
					>
						<div class="carousel-caption">
						<?php
						printf(
							'<a href="%s" title="%s" rel="bookmark"><h2 class="entry-title post-title slide-title font-weight-bold">%s</h2></a>',
							esc_url( get_permalink() ),
							the_title_attribute( 'echo=0' ),
							esc_html( get_the_title() )
						);
						?>
							<p class="lead">
							<?php
							thecleanblog_posted_by();
							thecleanblog_posted_on();
							?>
							</p>
						</div>
					</div>
					<?php
				endwhile;
			endif;
			wp_reset_postdata();
			?>
		</div>
		<a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
			<div class="carousel-control-arrows">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</div>
		</a>
		<a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
			<div class="carousel-control-arrows">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</div>
		</a>
	</div>

</header><!-- #masthead -->
