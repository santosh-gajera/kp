<?php

/*
 * Kapow Login Template
 * Template Name: Login Template
 *
 * @package kapow
*/

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        //* Check if user is logged in, if so redirect
        \Kapow\Login::check();

        //* Check if trying to reset password
        if (isset($_GET['rp']) && $_GET['rp'] == true) {
            \Kapow\Util::Render('login', 'reset-password');
        } else {
            //* Render Login Form
            \Kapow\Util::Render('login', 'login');
        } ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
