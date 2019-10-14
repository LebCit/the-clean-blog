<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package The_Clean_Blog
 */

?>

			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #content -->

	<hr>

	<!-- Footer -->
	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-10 mx-auto">
					<ul id="tcb-social" class="list-inline text-center">
						<?php thecleanblog_social_media_icons(); ?>
					</ul>
					<p id="site-info" class="site-info copyright text-muted">
						<?php thecleanblog_site_info(); ?>
					</p><!-- .site-info -->
				</div><!-- .col-lg-8.col-md-10.mx-auto -->
			</div><!-- .row -->
		</div><!-- .container -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
