<?php

global $kapowUser;
use Kapow\KapowResource;

get_header();

parse_str($query_string, $params);

if (isset($_GET['order'])) {
    if ($_GET['order'] == 'a-z' || $_GET['order'] == 'latest') {
        $order = 'ASC';
    } elseif ($_GET['order'] == 'oldest' || $_GET['order'] == 'z-a') {
        $order = 'DESC';
    }

    if ($_GET['order'] == 'oldest' || $_GET['order'] == 'latest') {
        $orderBy = 'date';
    } elseif ($_GET['order'] == 'a-z' || $_GET['order'] == 'z-a') {
        $orderBy = 'title';
    }
} else {
    $order = 'ASC';
    $orderBy = 'rand';
}

$showcase_args = [
    'post_type'      => ['featured_documents', 'videos', 'subject_toolkit'],
    'post_status'    => 'publish',
    'order'           => $order,
    'orderby'         => $orderBy,
    'paged'          => $paged,
    'posts_per_page' => 12,
    // 'offset' => $offset,
    'ignore_custom_sort' => 'TRUE'
];

if (
    (isset($_GET['search']) && isset($_GET['opt_year'])) ||
    (isset($_GET['opt_year']) && isset($_GET['key-stage'])) ||
    (isset($_GET['subjects']) && isset($_GET['key-stage'])) ||
    (isset($_GET['resources']) && isset($_GET['key-stage'])) ||
    (isset($_GET['opt_year']) && isset($_GET['subjects'])) ||
    (isset($_GET['opt_year']) && isset($_GET['resources'])) ||
    (isset($_GET['subjects']) && isset($_GET['resources'])) ||
    (isset($_GET['opt_year']) && isset($_GET['resources']) && isset($_GET['subjects'])) ||
    (isset($_GET['opt_year']) && isset($_GET['resources']) && isset($_GET['key-stage'])) ||
    (isset($_GET['opt_year']) && isset($_GET['subjects']) && isset($_GET['key-stage'])) ||
    (isset($_GET['resources']) && isset($_GET['subjects']) && isset($_GET['key-stage']))
) {
    $all_tax_args = [
        'tax_query' => [
            'relation' => 'AND',
            [
                'taxonomy'   => 'yeartax',
                'field'      => 'term_id',
                'terms'      => $_GET['opt_year'],
                'operator' => 'AND',
                'hide_empty' => true
            ],
            [
                'taxonomy' => 'featured_document_type',
                'field'    => 'term_id',
                'terms'    => $_GET['resources'],
                'operator' => 'AND',
                'hide_empty' => true
            ],
            [
                'taxonomy' => 'subject_specialists',
                'field'    => 'slug',
                'terms'    => $_GET['subjects'],
                'hide_empty' => true,
            ],
        ]
    ];

    $showcase_args = array_merge($all_tax_args, $showcase_args);
} elseif ((isset($_GET['opt_year']) || isset($_GET['subjects'])) || isset($_GET['resources']) || isset($_GET['key-stage'])) {
    $all_tax_args = [
        'tax_query' => [
            'relation' => 'OR',
            [
                'taxonomy'   => 'yeartax',
                'field'      => 'term_id',
                'terms'      => isset($_GET['key-stage']) ? $_GET['key-stage'] : $_GET['opt_year'],
                'hide_empty' => true
            ],
            [
                'taxonomy' => 'featured_document_type',
                'field'    => 'term_id',
                'terms'    => $_GET['resources'],
                'hide_empty' => true
            ],
            [
                'taxonomy' => 'subject_specialists',
                'field'    => 'slug',
                'terms'    => $_GET['subjects'],
                'hide_empty' => true,
            ],
        ]
    ];

    $showcase_args = array_merge($all_tax_args, $showcase_args);
}

if (isset($_GET['search'])) {
    $s = $_GET['search'];
    $s_arg = [
        's' => $s
    ];
    $showcase_args = array_merge($s_arg, $showcase_args);
}

$resources_query = new WP_Query($showcase_args);
$max_pages = $resources_query->max_num_pages;

$hidePreset = (
    isset($_GET['key-stage']) ||
    isset($_GET['opt_year']) ||
    isset($_GET['subjects']) ||
    isset($_GET['resources']) ||
    isset($_GET['search'])
) ? true : false;

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main back-o-white">
        <?php if (isset($_GET['search']) && !empty($_GET['search'])) { ?>
            <div class="subject-materials__search-result-for container">
                <p>Search results '<span><?= $_GET['search']; ?></span>' (<?= $resources_query->post_count; ?>)</p>
            </div>
        <?php } ?>
        <section class="subject-materials <?= isset($_GET['search']) && !empty($_GET['search']) ? 'no-padding-top' : 'padding-top'; ?>">
            <div class="row">
                <div class="subject-materials__sidebar col-lg-3 p-0 news-archive__filters"> 
                    <div class="subject-materials__filters-container container mx-auto">
                        <div class="subject-materials__filters-toggle back-white d-lg-none d-flex align-items-center" data-filters-modal-trigger><p>Filter</p><span class="toggle-btn"></span></div>
                        <div class="filters-row d-flex">
                            <form class="form--desktop hide-by-default" id="YearTypes">
                                <div class="subject-materials__filters row m-0">
                                    <?php if (isset($_GET['search'])) { ?>
                                        <input type="hidden" name="search" value="<?= $_GET['search']; ?>">
                                    <?php } ?>

                                    <?php
                                    //* Subjects
                                    if ($subjects = Kapow\SubjectDocuments::GetTaxSubjects()) { ?>
                                        <div class="d-flex flex-column">
                                            <p class="subject-materials__filters-text-subject ns-grey-4">Filter by:</p>
                                            <p class="subject-materials__filters-text-subject">All subjects</p>
                                            <div class="subject-materials__subjects-options d-flex">
                                                <div class="subject-materials__subject-button all">
                                                    <label class="back-white" style="--button-colour: var(--kapow-pink);" for="all">
                                                        <input name="subjects" type="checkbox" id="all" value="all">
                                                        <span class="option-bg-colour"></span>
                                                        <span class="option-name">All</span>
                                                    </label>
                                                </div>
                                                <?php foreach ($subjects as $option) {
                                                    $term_id = 'subject_specialists_' . $option->term_id;
                                                    $colour = get_field('colour', $term_id); ?>
                                                    <div class="subject-materials__subject-button">
                                                        <label class="back-white" style="--button-colour: var(--kapow-<?= $colour; ?>);" for="<?= $option->slug; ?>">
                                                            <input name="opt_<?= $option->taxonomy; ?>[]" type="checkbox" id="<?= $option->slug; ?>" value="<?= $option->slug; ?>" <?= (isset($_GET['opt_' . $option->taxonomy]) && in_array($option->term_id, $_GET['opt_' . $option->taxonomy])) ? 'checked' : ''; ?>>
                                                            <span class="option-bg-colour"></span>
                                                            <span class="option-name"><?= $option->slug === 'design-technology' ? 'D&T' : $option->name; ?></span>
                                                        </label>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    <?php }

                                    //* Keystages
                                    if ($keystages = Kapow\SubjectDocuments::GetTaxKeyStages()) {
                                        get_template_part('/components/components/subject-materials/select-option-new', null, [
                                            'title'   => 'Key stage',
                                            'options' => $keystages
                                        ]);
                                    }

                                    //* Years
                                    if ($years = Kapow\SubjectDocuments::GetTaxYears()) {
                                        get_template_part('/components/components/subject-materials/select-option-new', null, [
                                            'title'   => 'Year',
                                            'options' => $years
                                        ]);
                                    }

                                    //* Resource Types
                                    if ($resource_types = Kapow\SubjectDocuments::GetTaxDocType()) {
                                        get_template_part('/components/components/subject-materials/select-option-new', null, [
                                            'title'   => 'Resource Type',
                                            'options' => $resource_types
                                        ]);
                                    } ?>
                                    <div class="subject-materials__reset-submit-wrapper d-flex flex-column col-12 p-0">
                                        <a class="subject-materials__filter-reset blue" href="/subject-planning">Reset filters</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Popular Resources -->
                    <?php if (($popular = Kapow\SubjectDocuments::GetPopularResources()) && !$hidePreset) { ?>
                        <div class="subject-materials__popular d-lg-none">
                            <p class="subject-materials__popular-title portion-title">Popular resource libraries</p>
                            <div class="subject-materials__popular-row row">
                                <?php foreach ($popular as $args) {
                                    get_template_part('/components/components/subject-materials/popular-card', null, $args);
                                } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="subject-materials__main col-lg-8 offset-lg-1" id="responseShowcase">
                    <!-- Popular Resources -->
                    <?php if (($popular = Kapow\SubjectDocuments::GetPopularResources()) && !$hidePreset) { ?>
                        <div class="subject-materials__popular d-none d-lg-block">
                            <p class="subject-materials__popular-title portion-title">Popular resource libraries</p>
                            <div class="subject-materials__popular-row row">
                                <?php foreach ($popular as $args) {
                                    get_template_part('/components/components/subject-materials/popular-card', null, $args);
                                } ?>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- Key Documents -->
                    <?php if (($key = Kapow\SubjectDocuments::GetKeyResources()) && !$hidePreset) { ?>
                        <div class="subject-materials__key">
                            <p class="subject-materials__key-title portion-title">Key documents</p>
                            <div class="subject-materials__key-row row">
                                <?php foreach ($key as $args) {
                                    get_template_part('/components/components/subject-materials/card', null, $args);
                                } ?>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- Resource Library -->
                    <div class="subject-materials__main p-0">
                        <div class="subject-materials__main-title-sort-wrapper d-flex justify-content-between">
                            <p class="subject-materials__main-title portion-title">All resources</p>
                            <?php if (!$hidePreset) { ?>
                                <form class="subject-materials__sort" onsubmit="event.preventDefault()">
                                    <label for="resources-sort">Sort:</label>
                                    <select class="subject-materials__sort-select" name="order" id="order">
                                        <option value="latest" <?= isset($_GET['order']) && $_GET['order'] === 'latest' ? 'selected' : ''; ?>>Latest</option>
                                        <option value="oldest" <?= isset($_GET['order']) && $_GET['order'] === 'oldest' ? 'selected' : ''; ?>>Oldest</option>
                                        <option value="a-z" <?= isset($_GET['order']) && $_GET['order'] === 'a-z' ? 'selected' : ''; ?>>A - Z</option>
                                        <option value="z-a" <?= isset($_GET['order']) && $_GET['order'] === 'z-a' ? 'selected' : ''; ?>>Z - A</option>
                                    </select>
                                </form>
                            <?php } ?>
                        </div>
                        <div class="subject-materials__loader spinner-border text-light" data-subject-planning-loader>
                            <span></span>
                        </div>
                        <div class="subject-materials__body" data-subject-planning-body>
                            <?php if ($resources_query->have_posts()) { ?>
                                <div class="subject-materials__main-row row">
                                    <?php while ($resources_query->have_posts()) {
                                        $resources_query->the_post();
                                        $resource = new KapowResource($post->ID);
                                        $locked = $kapowUser->hasAccessTo($resource)->authorized ? false : true;
                                        if (get_field('visible_when_logged_out', $post->ID)) {
                                            $locked = false;
                                        }

                                        $args = [
                                            'post'     => $post,
                                            'locked'   => $locked,
                                        ];

                                        get_template_part('/components/components/subject-materials/card', null, $args);
                                    } ?>
                                </div>
                            <?php } else { ?>
                                <p class="no-results body-3">
                                    No results matching your filters, please either adjust your filters or 
                                    try the search if you're looking for something specfic.
                                </p>
                            <?php }
                            wp_reset_query(); ?>
                        </div>
                    </div>
                    <!-- Pagination -->
                    <div class="subject-materials__pagination d-flex justify-content-center">
                        <div class="subject-materials__pagination-inner d-flex">
                            <?= paginate_links([
                                'base' => str_replace(999999, '%#%', esc_url(get_pagenum_link(999999))),
                                'current' => max(1, get_query_var('paged')),
                                'mid_size' => 1,
                                'total' => $max_pages,
                                'prev_text' => '',
                                'next_text' => ''
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<!-- Mobile filters modal -->
<div class="subject-materials__filters-modal responsive-view" data-filters-modal>
    <div class="subject-materials__filters-modal-inner" data-filters-curtain>
        <div class="subject-materials__filters-modal-close" data-filters-close></div>
        <form class="form--mobile hide-by-default" action="/subject-planning" method="get">
            <div class="subject-materials__filters row m-0">
                <?php if (isset($_GET['search'])) {?>
                    <input type="hidden" name="search" value="<?= $_GET['search']; ?>">
                <?php } ?>
                <?php
                //* Subjects
                if ($subjects = Kapow\SubjectDocuments::GetTaxSubjects()) { ?>
                    <div class="d-flex flex-column">
                        <p class="subject-materials__filters-text-subject ns-grey-4">Filter by:</p>
                        <p class="subject-materials__filters-text-subject">All subjects</p>
                        <div class="subject-materials__subjects-options d-flex">
                            <div class="subject-materials__subject-button all">
                                <label class="back-white" style="--button-colour: var(--kapow-pink);" for="all--mobile">
                                <input name="subjects" type="checkbox" id="all--mobile" value="all" <?= isset($_GET['subjects']) ? 'checked' : ''; ?>>
                                    <span class="option-bg-colour"></span>
                                    <span class="option-name">All</span>
                                </label>
                            </div>
                            <?php foreach ($subjects as $option) {
                                $term_id = 'subject_specialists_' . $option->term_id;
                                $colour = get_field('colour', $term_id);
                                ?>
                                <div class="subject-materials__subject-button">
                                    <label class="back-white" style="--button-colour: var(--kapow-<?= $colour; ?>);" for="<?= $option->slug; ?>--mobile">
                                        <input name="opt_<?= $option->taxonomy; ?>[]" type="checkbox" id="<?= $option->slug; ?>--mobile" value="<?= $option->term_id; ?>" <?= (isset($_GET['opt_' . $option->taxonomy]) && in_array($option->term_id, $_GET['opt_' . $option->taxonomy])) ? 'checked' : ''; ?>>
                                        <span class="option-bg-colour"></span>
                                        <span class="option-name">
                                            <?= $option->slug === 'design-technology' ? 'D&T' : $option->name; ?>
                                        </span>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php }

                //* Keystages
                if ($keystages = Kapow\SubjectDocuments::GetTaxKeyStages()) {
                    get_template_part('/components/components/subject-materials/select-option', null, [
                        'title'   => 'Key stage',
                        'options' => $keystages
                    ]);
                }

                //* Years
                if ($years = Kapow\SubjectDocuments::GetTaxYears()) {
                    get_template_part('/components/components/subject-materials/select-option', null, [
                        'title'   => 'Year',
                        'options' => $years
                    ]);
                }

                //* Resource Types
                if ($resource_types = Kapow\SubjectDocuments::GetTaxDocType()) {
                    get_template_part('/components/components/subject-materials/select-option', null, [
                        'title'   => 'Resource Type',
                        'options' => $resource_types
                    ]);
                } ?>
                <div class="subject-materials__reset-submit-wrapper d-flex flex-column col-12 p-0">
                    <a class="subject-materials__filter-reset blue" href="/subject-planning">Reset filters</a>
                    <div class="subject-materials__action">
                        <button class="button button--black" type="submit">Apply filters</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php get_footer();
