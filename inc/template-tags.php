<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package The_Clean_Blog
 */
if (!function_exists('thecleanblog_posted_on')) :

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function thecleanblog_posted_on()
    {
        global $post;
        $author_id = $post->post_author;
        //$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') == get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
            $byline = sprintf(
                esc_html_x('Posted by %s', 'post author', 'the-clean-blog'), '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author_meta('nickname', $author_id)) . '</a></span>'
            );
        } else {
            $time_string = '<time class="updated" datetime="%3$s">%4$s</time>';
            $byline = sprintf(
                esc_html_x('Updated by %s', 'post author', 'the-clean-blog'), '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author_meta('nickname', $author_id)) . '</a></span>'
            );
        }

        $time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            esc_html_x('on %s', 'post date', 'the-clean-blog'), '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="byline">' . $byline . '</span><span class="posted-on"> ' . $posted_on . '</span>'; // WPCS: XSS OK.
    }
endif;

if (!function_exists('thecleanblog_entry_footer')) :

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function thecleanblog_entry_footer()
    {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'the-clean-blog'));
            if ($categories_list && thecleanblog_categorized_blog()) {
                printf('<span class="cat-links">' . esc_html__('Posted in : %1$s', 'the-clean-blog') . '</span><br><br>', $categories_list); // WPCS: XSS OK.
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html__(', ', 'the-clean-blog'));
            if ($tags_list) {
                printf('<span class="tags-links">' . esc_html__('Tagged : %1$s', 'the-clean-blog') . '</span>', $tags_list); // WPCS: XSS OK.
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(esc_html__('Leave a comment', 'the-clean-blog'), esc_html__('1 Comment', 'the-clean-blog'), esc_html__('% Comments', 'the-clean-blog'));
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                /* translators: %s: Name of current post */
                esc_html__('Edit %s', 'the-clean-blog'), the_title('<span class="screen-reader-text">"', '"</span>', false)
            ), '<br><br><span class="edit-link">', '</span>'
        );
    }
endif;

if (!function_exists('thecleanblog_posts_navigation')) :

    /**
     * Displays the navigation to next/previous set of posts, when applicable.
     */
    function thecleanblog_posts_navigation()
    {
        // Don't print empty markup if there's only one page.
        if ($GLOBALS['wp_query']->max_num_pages < 2) {
            return;
        } ?>
        <ul class="pager">
            <?php if (get_next_posts_link()) : ?>
                <li class="next"><?php next_posts_link(esc_html__('Older posts', 'the-clean-blog')); ?></li>
            <?php endif; ?>
            <?php if (get_previous_posts_link()) : ?>
                <li class="previous"><?php previous_posts_link(esc_html__('Newer posts', 'the-clean-blog')); ?> </li>
            <?php endif; ?>
        </ul>
        <?php

    }
endif;


if (!function_exists('thecleanblog_post_navigation')) :

    /**
     * Display navigation to next/previous post when applicable.
     */
    function thecleanblog_post_navigation()
    {
        // Don't print empty markup if there's nowhere to navigate.
        $previous = (is_attachment()) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
        $next = get_adjacent_post(false, '', false);
        if (!$next && !$previous) {
            return;
        } ?>
        <nav class="navigation post-navigation" role="navigation">
            <h2 class="screen-reader-text"><?php esc_html_e('Post navigation', 'the-clean-blog'); ?></h2>
            <div class="nav-links">
                <ul class="pager">
                    <?php
                    previous_post_link('<li class="nav-previous previous">%link</li>', '%title');
        next_post_link('<li class="nav-next next">%link</li>', '%title'); ?>
                </ul>
            </div><!-- .nav-links -->
        </nav><!-- .navigation -->
        <?php

    }
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function thecleanblog_categorized_blog()
{
    if (false === ($all_the_cool_cats = get_transient('thecleanblog_categories'))) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories(array(
            'fields' => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number' => 2,
        ));

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('thecleanblog_categories', $all_the_cool_cats);
    }

    if ($all_the_cool_cats > 1) {
        // This blog has more than 1 category so thecleanblog_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so thecleanblog_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in thecleanblog_categorized_blog.
 */
function thecleanblog_category_transient_flusher()
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('thecleanblog_categories');
}
add_action('edit_category', 'thecleanblog_category_transient_flusher');
add_action('save_post', 'thecleanblog_category_transient_flusher');
