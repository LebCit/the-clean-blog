<?php
/**
 * Template part for displaying contact form content in page-contact.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package The_Clean_Blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php echo '<p class="contcat-form-message">' . esc_html__('Fill the form to send me an email. I will reply ASAP !', 'the-clean-blog') . '</p>' ?>
    </header>
    <div class="entry-content">
        
        <?php cleanblog_contact_form_class(); ?>

    </div>
    <footer class="entry-footer">
        <?php
        edit_post_link(
            sprintf(
                /* translators: %s: Name of current post */
                esc_html__('Edit %s', 'the-clean-blog'), the_title('<span class="screen-reader-text">"', '"</span>', false)
            ), '<span class="edit-link">', '</span>'
        );

        ?>
    </footer>
</article><!-- #post-## -->