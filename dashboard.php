<?php

/*
 * Template Name: Dashboard
*/

get_header();

\Kapow\Util::CheckLogin(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php \Kapow\Util::Render('dashboard', 'dashboard'); ?>

        </main>
    </div>

<?php get_footer();
