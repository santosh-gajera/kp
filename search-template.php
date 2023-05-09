<?php

/**
 * The template for displaying account page
 *
 * Template Name: Search Page Template
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kapow
*/

get_header(); ?>

<div id="primary" class="content-area back-o-white">
    <main id="main" class="site-main search-page blog">

        <?php get_template_part('template-parts/content', 'search-page'); ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
