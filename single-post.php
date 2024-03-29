<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s
*/

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php echo do_shortcode('[addtoany]'); ?>
        <?php while (have_posts()) {
            the_post();
            get_template_part('template-parts/content', 'postbuilder');
        } ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();