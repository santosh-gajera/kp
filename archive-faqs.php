<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

get_header();

$faqs = get_field('faqs_introduction', 'options'); ?> 

    <div id="primary" class="content-area back-o-white pad-b-6">
        <main id="main" class="site-main">
            <div class="container faq col-md-8 offset-md-2">
                <div class="faq__introduction mb-5 text-center">
                    <p><?php echo ($faqs);?></p>
                </div>
                <?php
                $taxonomy = 'faq_categories';

                $top_level_terms = get_terms([
                    'taxonomy'      => $taxonomy,
                    'parent'        => '0',
                    'hide_empty'    => false,
                ]);

                foreach ($top_level_terms as $top_level_term) {
                    // the id of the top-level-term, we need this further down
                    $top_term_id = $top_level_term->term_id;
                    // the name of the top-level-term
                    $top_term_name = $top_level_term->name;
                    // the current used taxonomy
                    $top_term_tax = $top_level_term->taxonomy; ?>

                    <button class="faq__trigger-button" id="faq-category faq-trigger">
                        <?php echo $top_term_name;?>
                    </button>

                    <?php
                    // WP_Query arguments
                    $args_faqs = array (
                        'post_type'              => array( 'faqs' ),
                        'post_status'            => array( 'publish' ),
                        'nopaging'               => true,
                        'order'                  => 'ASC',
                        'orderby'                => 'menu_order',
                        'tax_query' => array (
                            array(
                            'taxonomy' => 'faq_categories',
                            'field' => 'term_id',
                            'terms' => $top_level_term->term_id,
                            )
                        )
                    );

                    // The Query
                    $faqs = new WP_Query($args_faqs);

                    if ($faqs->have_posts()) { ?>
                        <div class="faq__content-wrapper">
                            <?php while ($faqs->have_posts()) {
                                $faqs->the_post(); ?>
                                <div class="faq__trigger-main-wrapper faq-trigger my-5">
                                    <div class="faq__trigger-container faq-content">
                                        <div class="faq__title-trigger">
                                            <?php if (get_the_title()) { ?>
                                                <div class="faq__question dcyan">
                                                    <h4><?php the_title(); ?></h4>
                                                </div>
                                            <?php } ?>
                                            <div class="faq__icon-container">
                                            </div>
                                            <?php if (get_the_content()) { ?>
                                                <div class="faq__answer"><?php the_content(); ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php }
                }
                wp_reset_postdata(); ?>
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php get_footer();?>
