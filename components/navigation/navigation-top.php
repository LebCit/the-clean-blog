<div class="cb-logo">
    <?php thecleanblog_the_custom_logo(); ?>
</div>

<?php
wp_nav_menu(array(
    'theme_location' => 'menu-1',
    'container' => 'nav',
    'container_class' => 'cb-main-nav-wrapper',
    'menu_class' => 'cb-main-nav',
    'fallback_cb' => 'thecleanblog_fallback_menu',
    'depth' => 2
));

?>
<div class="search-dropdown">
    <?php
    add_filter('get_search_form', 'thecleanblog_header_search_form');
    get_search_form();
    remove_filter('get_search_form', 'thecleanblog_header_search_form');

    ?>
</div>
<a href="#0" class="cb-nav-trigger"><?php esc_html__('Menu', 'the-clean-blog') ?><span></span></a>