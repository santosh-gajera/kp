<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _s
 */

get_header();
?>

<?php

$title = get_field('page_title', 'options');
$subtitle = get_field('subtitle', 'options');
$error_code = get_field('error_code', 'options');
$useful_links_title = get_field('useful_links_title', 'options');
$image = get_field('image', 'options');

?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <section class="page-not-found">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-5 col-md-6">
                            <div class="section-title mar-b-6">
                                <h1 class='page-not-found__title'><?= $title; ?></h1>
                            </div>
                            <h2 class="page-not-found__subtitle"><?= $subtitle; ?></h2>
                            <div class="page-not-found__error"><?= $error_code; ?></div>
                            <div class="page-not-found__links"><?= $useful_links_title; ?></div>
                            <?php if (have_rows('useful_links', 'options')) { ?>
                                <div class="page-not-found__links-container">
                                <?php while (have_rows('useful_links', 'options')) {
                                    the_row();
                                    $link = get_sub_field('link'); ?>
                                    <div class="page-not-found__link">
                                        <a href="<?= $link['url']; ?>"><?= $link['title']; ?></a>
                                    </div>
                                <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-lg-5 col-md-6">
                            <img class='page-not-found__image' src="<?= $image; ?>" alt="404 image">
                        </div>
                    </div>
                </div>
            </section>
       </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
