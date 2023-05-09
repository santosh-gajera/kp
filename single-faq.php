<?php

/**
 * The template for displaying single specialist post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package kapow
*/

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="single-faq single-faq__site-main">

        <?php get_template_part('template-parts/content', 'single-faq'); ?>
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
