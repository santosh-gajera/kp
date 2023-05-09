<?php

/**
 * Kapow Renew Template
 * Template Name: Renew Subscription
 *
 * @package kapow
*/

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <?php \Kapow\Util::Render('account/renew', 'renew'); ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
