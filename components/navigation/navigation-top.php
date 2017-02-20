<div class="container-fluid">

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header page-scroll">

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">                
            <i class="fa fa-bars" aria-hidden="true"></i>
        </button>
        <button class="search-trigger"><i class="icon-search"></i></button>

        <?php get_template_part('components/header/site', 'branding'); ?>

    </div><!-- /.navbar-header.page-scroll -->

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> 

        <ul class="nav navbar-nav navbar-right">
            <?php wp_nav_menu(array('theme_location' => 'menu-1', 'container' => false, 'items_wrap' => '%3$s')); ?>
            <li class="search-trigger"><i class="icon-search"></i></li>
        </ul>
    </div><!-- /.navbar-collapse -->

    <div class="search-dropdown">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <label>
                <span class="screen-reader-text"><?php echo esc_html_x('Search for:', 'label', 'the-clean-blog') ?></span>
                <input type="search" class="search-field"
                       placeholder="<?php echo esc_html_x('Search ...', 'placeholder', 'the-clean-blog') ?>"
                       value="<?php echo get_search_query() ?>" name="s" id="s" required
                       title="<?php echo esc_attr_x('Search for:', 'label', 'the-clean-blog') ?>" />
            </label>
            <button type="submit" class="search-submit"
                    value="<?php echo esc_attr_x('Search', 'submit button', 'the-clean-blog') ?>">
                <i class="icon-search"></i>
            </button>
        </form>
    </div>

</div><!-- /.container-fluid -->