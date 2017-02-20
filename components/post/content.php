<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package The_Clean_Blog
 */

?>

<article class="post-preview" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header">
        <?php
        if (is_single()) {
            the_title('<h2 class="entry-title post-title">', '</h2>');
            get_template_part('components/post/content', 'meta');
        } else {
            the_title('<h2 class="entry-title post-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        }

        ?>
    </header>
    <div class="entry-content">
        <?php
        if (is_single()) {
            the_content(sprintf(
                    /* translators: %s: Name of current post. */
                    wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'the-clean-blog'), array('span' => array('class' => array()))), the_title('<span class="screen-reader-text">"', '"</span>', false)
            ));

            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'the-clean-blog'),
                'after' => '</div>',
            ));
        } else {
            ?>
            <h3 class="post-subtitle"><?php echo esc_html(the_excerpt()); ?></h3>
            <?php
            get_template_part('components/post/content', 'meta');
        }

        ?>
    </div>
    <?php
    if (is_single()) {
        get_template_part('components/post/content', 'footer'); ?>
        <hr>
        <?php

    } else {
        ?>
        <hr>
        <?php

    }

    ?>
</article><!-- #post-## -->