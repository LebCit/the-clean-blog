<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package The_Clean_Blog
 */
get_header();

?>

<div id="primary" class="content-area col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
    <main id="main" class="site-main" role="main">

        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    $search404Tilte = get_theme_mod('search_404_page_title_text');
                    if(empty($search404Tilte)){
                        $search404Tilte = esc_html_e('Oops! That page can&rsquo;t be found.', 'the-clean-blog');
                    } else {
                        echo esc_html($search404Tilte);
                    }
                    ?>
                </h1>
            </header>
            <div class="page-content">
                <p>
                    <?php
                    $search404Paragraph = get_theme_mod('search_404_page_paragraph_text');
                    if(empty($search404Paragraph)){
                        $search404Paragraph = esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'the-clean-blog');
                    } else {
                        echo esc_html($search404Paragraph);
                    }
                    ?>
                </p>

                <?php
                get_search_form();

                the_widget('WP_Widget_Recent_Posts');

                // Only show the widget if site has multiple categories.
                if (thecleanblog_categorized_blog()) :

                    ?>

                    <div class="widget widget_categories">
                        <h2 class="widget-title"><?php esc_html_e('Most Used Categories', 'the-clean-blog'); ?></h2>
                        <ul>
                            <?php
                            wp_list_categories(array(
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'show_count' => 1,
                                'title_li' => '',
                                'number' => 10,
                            ));

                            ?>
                        </ul>
                    </div>
                    <?php
                endif;

                /* translators: %1$s: smiley */
                $archive_content = '<p>' . sprintf(esc_html__('Try looking in the monthly archives. %1$s', 'the-clean-blog'), convert_smilies(':)')) . '</p>';
                the_widget('WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content");

                the_widget('WP_Widget_Tag_Cloud');

                ?>

            </div>
        </section>
    </main>
</div>
<?php
get_footer();
