<div class="site-branding navbar-brand">
    <?php if (is_front_page() && is_home()) : ?>
        <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
    <?php else : ?>
        <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
    <?php
    endif;

    $description = get_bloginfo('description', 'display');
    if ($description || is_customize_preview()) :

        ?>
        <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
    <?php endif;

    ?>
</div><!-- .site-branding -->