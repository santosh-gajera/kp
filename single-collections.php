<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package kapow
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php while (have_posts()) {
            the_post();
            get_template_part('template-parts/content', 'single-collections');
        } ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();
