<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package The_Clean_Blog
 */
get_header();

?>

<section id="primary" class="content-area col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
    <main id="main" class="site-main" role="main">

        <?php if (have_posts()) : ?>

            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    $searchResults = get_theme_mod('search_results_page_text');
                    if(empty($searchResults)){
                        $searchResults = printf(esc_html__('Search Results for: %s', 'the-clean-blog'), '<span>' . get_search_query() . '</span>');
                    } else {
                        printf(esc_html($searchResults .' %s'), '<span>' . get_search_query() . '</span>');
                    }
                    ?>
                </h1>
            </header>
            <?php
            /* Start the Loop */
            while (have_posts()) : the_post();

                /**
                 * Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called content-search.php and that will be used instead.
                 */
                get_template_part('components/post/content', 'search');

            endwhile;

            thecleanblog_posts_navigation();

        else :

            get_template_part('components/post/content', 'none');

        endif;

        ?>

    </main>
</section>
<?php
get_footer();
