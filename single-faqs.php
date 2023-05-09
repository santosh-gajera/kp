<?php

/**
 * The template for displaying single specialist post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s
*/

get_header(); ?>

<div id="primary" class="content-area back-o-white">
    <main id="main" class="site-main back-o-white">

        <?php get_template_part('template-parts/content', 'single-faqs'); ?>
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
