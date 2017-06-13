<?php
/**
 * This file generates the background header image for 404.php
 */

$heroImgError404 = get_theme_mod('error404_header_background_image');
if (empty($heroImgError404)) {
    $heroImgError404 = get_template_directory_uri() . '/components/header/images/404-hero.jpg';
}

?>
<!-- Set background image for this header . -->
<header id="masthead" class="site-header intro-header" style="background-image: url('<?php echo esc_url( $heroImgError404 ); ?>')" role="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <header class="entry-header">
                        <h1 class="entry-title">
                            <?php
                            $error404Title = get_theme_mod('error404_page_title_text');
                            if(empty($error404Title)){
                                $error404Title = esc_html_e('Wrong Archives Row !', 'the-clean-blog');
                            } else {
                                echo esc_html($error404Title);
                            }
                            ?>
                        </h1>
                        <div class="strike">
                            <span>
                                <a href="#content"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                            </span>
                        </div>
                        <h2 class="subheading">
                            <?php
                            $error404Subtitle = get_theme_mod('error404_page_subtitle_text');
                            if(empty($error404Subtitle)){
                                $error404Subtitle = esc_html_e('Try to search below', 'the-clean-blog');
                            } else {
                                echo esc_html($error404Subtitle);
                            }
                            ?>
                        </h2>
                    </header>
                </div>
            </div>
        </div>
    </div>
</header>