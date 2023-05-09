<?php

/*
 * Template Name: Lesson Layout
 * Template Post Type: lessons
*/

ob_start();
get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php while (have_posts()) {
            the_post();
            include SOBOLD_THEME_PATH . '/template-parts/content-lesson-template.php';
        } ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
