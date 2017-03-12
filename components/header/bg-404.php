<?php
/**
 * This file generates the background header image for 404.php
 */

?>
<!-- Set background image for this header . -->
<header id="masthead" class="site-header intro-header" role="banner">
    <style>
        .intro-header {
            height: 100vh;
            background-image: url('<?php
            echo esc_url(get_template_directory_uri());
            echo '/components/header/images/404-hero.jpg';

            ?>');
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <header class="entry-header">
                        <h1 class="entry-title">Wrong Archives Row !</h1>
                        <div class="strike">
                            <span>
                                <a href="#content"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                            </span>
                        </div>
                        <h2 class="subheading">Try to search below</h2>
                    </header>
                </div>
            </div>
        </div>
    </div>
</header>