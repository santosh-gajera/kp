<?php

/**
 * Kapow Upgrade Template
 * Template Name: Upgrade Subscription
 *
 * @package kapow
*/

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php if (isset($_GET['productId']) && $_GET['productId'] !== '') {
            //* Render Single Upgrade
            \Kapow\Util::Render('account/upgrade/single-upgrade', 'single-upgrade', [
                'productId' => $_GET['productId']
            ]);
        } else {
            //* Render Upgrade Options
            \Kapow\Util::Render('account/upgrade', 'upgrade');
        } ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
