<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package The_Clean_Blog
 */
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}

?>

<div id="comments" class="comments-area">

    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) :

        ?>
        <h2 class="comments-title">
            <?php
            printf(// WPCS: XSS OK.
                esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'the-clean-blog')), number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>'
            );

            ?>
        </h2>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through??>
            <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'the-clean-blog'); ?></h2>
                <ul class="nav-links pager">

                    <li class="nav-previous previous"><?php previous_comments_link(esc_html__('Older Comments', 'the-clean-blog')); ?></li>
                    <li class="nav-next next"><?php next_comments_link(esc_html__('Newer Comments', 'the-clean-blog')); ?></li>

                </ul>
            </nav>
        <?php endif; // Check for comment navigation.?>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'avatar_size' => 100,
                'style' => 'ol',
                'short_ping' => true,
                'reply_text' => '<i class="fa fa-reply" aria-hidden="true"></i>' . __('Reply', 'the-clean-blog'),
            ));

            ?>
        </ol>
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : // Are there comments to navigate through??>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'the-clean-blog'); ?></h2>
                <ul class="nav-links pager">

                    <li class="nav-previous previous"><?php previous_comments_link(esc_html__('Older Comments', 'the-clean-blog')); ?></li>
                    <li class="nav-next next"><?php next_comments_link(esc_html__('Newer Comments', 'the-clean-blog')); ?></li>

                </ul>
            </nav>
            <?php
        endif; // Check for comment navigation.

    endif; // Check for have_comments().
    // If comments are closed and there are comments, let's leave a little note, shall we?
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :

        ?>

        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'the-clean-blog'); ?></p>
        <?php
    endif;

    comment_form();

    ?>

</div><!-- #comments -->