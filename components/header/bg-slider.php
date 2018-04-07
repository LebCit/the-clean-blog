<?php
/**
 * This file generates the slider, if activated, on the homepage.
 * 
 * The background image, for the first <li>, is added by using inline style.
 * @see the-clean-blog-functions.php | thecleanblog_header_style()
 */
?>
<div class="tcb-slider">
    <ul class="tcb-slides">
        <li>                   
            <header id="masthead" class="site-header intro-header" role="banner">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                            <div class="site-heading">
                                <header class="entry-header">

                                    <h1 id="responsive_headline" class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>

                                    <div class="strike bounce">
                                        <span>
                                            <a href="#content"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                                        </span>
                                    </div>

                                    <h2 class="subheading">
                                        <?php
                                            $description = get_bloginfo('description', 'display');
                                            if ($description || is_customize_preview()) :
                                        ?>
                                            <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                                        <?php endif; ?>
                                    </h2>
                                </header>                                             
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </li>
    <?php
    $rslides_cat = get_theme_mod('slider_category','');
    $rslides_num = get_theme_mod('slider_number_of_posts','');
    $rslides = new WP_Query(array(
        'cat' => $rslides_cat,
        'posts_per_page' => $rslides_num
    ));
    if($rslides->have_posts()) :
        while($rslides->have_posts()) :
            $rslides->the_post(); 
    ?>
        <li>
            <header id="masthead" class="site-header intro-header"
                <?php
                if (has_post_thumbnail()) {
                    $heroImgSlider = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), ''); ?>
                    style="background-image: url('<?php echo esc_url( $heroImgSlider[0] ); ?>')"
                <?php
                } else {
                    $heroImgSlider = get_template_directory_uri() . '/components/header/images/default-hero.jpg'; ?>
                    style="background-image: url('<?php echo esc_url( $heroImgSlider ); ?>')"
                <?php } ?>
            role="banner">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                            <div class="site-heading">
                                <header class="entry-header">
                                    
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title('<h1 class="entry-title">', '</h1>'); ?></a>


                                    <div class="strike bounce">
                                        <span>
                                            <a href="#content"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                                        </span>
                                    </div>

                                    <h2 class="subheading">
                                        <?php thecleanblog_posted_on(); ?>
                                    </h2>
                                </header>                                             
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </li>
    <?php   
        endwhile;
    endif;
    wp_reset_postdata();
    ?>
    </ul>
</div>