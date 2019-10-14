<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package The_Clean_Blog
 */

if ( ! function_exists( 'thecleanblog_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function thecleanblog_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( ' on %s', 'post date', 'the-clean-blog' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore

	}
endif;

if ( ! function_exists( 'thecleanblog_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function thecleanblog_posted_by() {
		global $post;
		$author_id = $post->post_author;
		$byline    = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'Posted by %s', 'post author', 'the-clean-blog' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name', $author_id ) ) . '</a></span>'
		);

		echo '<span class="byline"> ' .
		wp_kses(
			$byline,
			array(
				'span' => array(
					'class' => array(),
				),
				'a'    => array(
					'class' => array(),
					'href'  => array(),
				),
			)
		) .
		'</span>';

	}
endif;

if ( ! function_exists( 'thecleanblog_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function thecleanblog_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'the-clean-blog' ) );
			if ( $categories_list ) {
				printf(
					/* translators: 1: list of categories. */
					'<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'the-clean-blog' ) . '</span><br>',
					wp_kses(
						$categories_list,
						array(
							'a' => array(
								'href' => array(),
								'rel'  => array(),
							),
						)
					)
				);
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'the-clean-blog' ) );
			if ( $tags_list ) {
				printf(
					/* translators: 1: list of tags. */
					'<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'the-clean-blog' ) . '</span><br>',
					wp_kses(
						$tags_list,
						array(
							'a' => array(
								'href' => array(),
								'rel'  => array(),
							),
						)
					)
				);
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'the-clean-blog' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span><br>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'the-clean-blog' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'thecleanblog_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function thecleanblog_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail(
				'post-thumbnail',
				array(
					'alt' => the_title_attribute(
						array(
							'echo' => false,
						)
					),
				)
			);
			?>
		</a>

			<?php
		endif; // End is_singular().
	}
endif;
