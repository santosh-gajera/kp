<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
*/

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php if (have_posts()) { ?>
            <div class="container tag-wrapper">
                <div class="row">
                    <?php while (have_posts()) {
                        the_post();
                        get_template_part('template-parts/content', get_post_type());
                    }
                    the_posts_navigation(); ?>
                    <div class="col-12 text-center">
                        <a class="button button--blue" href="/blog">
                            <img src="/wp-content/uploads/2019/10/Arrow_White.svg" alt="left arrow icon" height="16" width="23">
                            <span>Back to blog</span>
                        </a>
                    </div>
                    
                </div>
            </div>
        <?php } else {
            get_template_part('template-parts/content', 'none');
        } ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
