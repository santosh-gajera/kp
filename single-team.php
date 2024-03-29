<?php

/**
 * The template for displaying single specialist post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s
*/

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php get_template_part('template-parts/content', 'single-team'); ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
