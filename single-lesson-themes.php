<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _s
*/

get_header();

include get_template_directory() . '/components/headers/header/breadcrumbs.php';

$previous = "javascript:history.go(-1)";

if (isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
} ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php while (have_posts()) {
            the_post();
            get_template_part('template-parts/content', 'pagebuilder'); ?>

            <div class="back-button__wrapper d-flex justify-content-center">
                <a class="button button--yellow" href="<?= $previous ?>">
                Previous page
                </a>
            </div>

        <?php } ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
