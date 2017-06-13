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
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <label>
                <span class="screen-reader-text"><?php echo esc_html_x('Search for:', 'label', 'the-clean-blog') ?></span>
                <input type="search" class="search-field"
                        placeholder="<?php
                            $placeholder = get_theme_mod('dropdown_search_placeholder_text');
                            if(empty($placeholder)){
                                $placeholder = esc_html_x('Search &hellip;', 'placeholder', 'the-clean-blog');
                                echo esc_attr($placeholder);
                            } else {
                                echo esc_attr($placeholder);
                            }
                        ?>"
                        value="<?php echo get_search_query() ?>" name="s" id="s" required
                        title="<?php echo esc_attr_x('Search for:', 'label', 'the-clean-blog') ?>" />
            </label>
            <button type="submit" class="search-submit"
                    value="<?php echo esc_attr_x('Search', 'submit button', 'the-clean-blog') ?>">
                <i class="icon-search"></i>
            </button>
        </form>
    </div>
<a href="#0" class="cb-nav-trigger"><?php esc_html__('Menu', 'the-clean-blog')?><span></span></a>