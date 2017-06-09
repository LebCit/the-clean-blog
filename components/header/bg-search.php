<?php
/**
 * This file generates the background header image for search.php
 */

$heroImgSearch = get_theme_mod( 'search_header_background_image');
if (empty($heroImgSearch)) {
    $heroImgSearch = get_template_directory_uri() . '/components/header/images/search-hero.jpg';
}

?>
<!-- Set background image for this header . -->
<header id="masthead" class="site-header intro-header" style="background-image: url('<?php echo esc_url( $heroImgSearch ); ?>')" role="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <header class="entry-header">
                        <h1 class="entry-title"><?php esc_html_e('Searching gives all answers', 'the-clean-blog') ?></h1>
                        <div class="strike">
                            <span>
                                <a href="#content"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                            </span>
                        </div>
                        <h2 class="subheading"><?php esc_html_e('KEEP SEARCHING !', 'the-clean-blog') ?></h2>
                    </header>
                </div>
            </div>
        </div>
    </div>
</header>