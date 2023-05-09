<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package kapow
 */

get_header();

$cat_args = [
    'hide_empty' => 1,
    'orderby'    => 'name',
    'order'      => 'ASC'
];

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args_blog = [
    "post_type" => "post",
    "post_status" => "publish",
    "posts_per_page" => 9,
    "orderby" => "publish_date",
    "paged" => $paged,
    "order" => 'DESC'
];
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <section class="blog">
            <div class="container">
                <div class="blog__select text-center">
                    <select class="blog__categories" name="categories" id="categories">
                        <option data-url='/blog/' value='all'>All posts</option>
                        <?php $categories = get_categories($cat_args);
                        foreach ($categories as $category) { ?>
                            <option data-url='/blog/category/<?= $category->slug; ?>' value="<?php echo $category->slug; ?>"><?php echo $category->name; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <?php $custom_query_blog = new WP_Query($args_blog);

                if ($custom_query_blog -> have_posts()) { ?>
                    <div class="row blog__posts">
                        <?php while ($custom_query_blog -> have_posts()) {
                            $custom_query_blog -> the_post();

                            $blogArgs = [
                                'date' => true
                            ];

                            get_template_part('template-parts/content', 'post', $blogArgs);
                        } ?>
                    </div>
                <?php } else {
                    get_template_part('template-parts/content', 'none');
                } ?>
            
                <div class="blog__pagination">
                    <?= paginate_links(
                        [
                            'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                            'total'        => $custom_query_blog->max_num_pages,
                            'current'      => max(1, get_query_var('paged')),
                            'format'       => '?paged=%#%',
                            'show_all'     => false,
                            'type'         => 'plain',
                            'end_size'     => 2,
                            'mid_size'     => 3,
                            'prev_next'    => true,
                            'prev_text'    => sprintf('<i></i> %1$s', __('<', 'text-domain')),
                            'next_text'    => sprintf('%1$s <i></i>', __('>', 'text-domain')),
                            'add_args'     => false,
                            'add_fragment' => '',
                        ]
                    ); ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer();
