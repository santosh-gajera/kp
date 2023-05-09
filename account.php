<?php

/*
 * Template Name: Account
*/

get_header();

\Kapow\Util::CheckLogin(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php \Kapow\Util::Render('account', 'account'); ?>

        </main>
    </div>

<?php get_footer(); ?>