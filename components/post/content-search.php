<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package The_Clean_Blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
    </header>
    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
    <?php if ('post' === get_post_type()) : ?>
        <?php get_template_part('components/post/content', 'meta'); ?>
    <?php endif; ?>

</article>
