<?php

/**
 * The template for displaying Archive Specialists Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

        <?php get_template_part('template-parts/content', 'archive-specialists'); ?>

        </main><!-- #main -->
    </div><!-- #primary -->


<?php

get_footer();