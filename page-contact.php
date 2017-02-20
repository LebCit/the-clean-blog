<?php
/**
 * Template Name: Contact Form
 * The template for displaying the contact form.
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-templates/
 * 
 * Require Clean_Blog_Contact_Form_Handler class.
 *
 * @package The_Clean_Blog
 */

get_header();

?>

<div id="primary" class="content-area col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
    <main id="main" class="site-main" role="main">

        <?php
        while (have_posts()) : the_post();

            get_template_part('components/page/content', 'contact');

        endwhile; // End of the loop.

        ?>

    </main>
</div>
<?php
get_footer();
