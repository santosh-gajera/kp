<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
*/

?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="site-info">

        <?php get_template_part('components/footer/footer-strip'); ?>
        <?php get_template_part('components/footer/footer-content'); ?>
        <?php get_template_part('components/footer/footer-sub'); ?>

        </div><!-- .site-info -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php
/**
 * This is temporary and needs to be moved, but it needs to be fixed quick
 * hench putting it here
*/
?>
<style>
    [for="mepr_agree_to_privacy_policy1"] {
        position: relative !important;
    }
</style>

<?php wp_footer(); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
<?php if (is_front_page()) { ?>
    <!-- Minified version has bugs for row layouts, the unminified version must be included for long-term-plans-block in home page -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js"></script>
<?php } else { ?>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<?php } ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/featherlight/1.7.13/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/wp-content/themes/SoBold/js/featherlight.gallery.js" type="text/javascript" charset="utf-8"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>
<script src="/wp-content/themes/SoBold/js/jquery.matchHeight.js" type="text/javascript"></script>

<script>
    jQuery(document).ready(function($) {
        const bannedEmails = <?= file_get_contents(SOBOLD_THEME_PATH . '/inc/json/banned-emails.json'); ?>;
        $('body').on('change', '[type="email"]', function(ev){
            $(ev.currentTarget).removeClass('invalid');
            const email = $(ev.currentTarget).val().toLowerCase();
            var invalidEmail = false;
            console.log($.inArray(email, bannedEmails));
            $.each(bannedEmails, function(k,v){
                if (email.indexOf(v) > 1) {
                    invalidEmail = true;
                    return false;
                }
            });

            if (invalidEmail) {
                invalidEmail = false;
                $(ev.currentTarget).val('').addClass('invalid');
                $(ev.currentTarget).parent().find('.cc-error').html('*Please enter a valid school email address');
            }
        })
    });
</script>
</body>
</html>
