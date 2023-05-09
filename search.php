<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package kapow
*/

get_header();

//* Used in filter
$subjects_search_array = [];
$subject_search_args = [
    'taxonomy' => 'subject_specialists',
    'orderby' => 'term_id',
    'order' => 'ASC'
];
$subjects_search = get_terms($subject_search_args);

foreach ($subjects_search as $subject_search) {
    $slug = $subject_search->slug;
    $value = $subject_search->name;
    $subjects_search_array[$slug] = $value;
}

if ($_GET["s"]) {
    $search_text = $_GET["s"];
}

$featTermsArgs = [
    'taxonomy' => 'featured_document_type',
    'orderby' => 'term_id',
    'order' => 'ASC'
];

$featTerms = get_terms($featTermsArgs);


$featTermsKeysToValues = [];

foreach ($featTerms as $key => $val) {
    $featTermsKeysToValues[$val->term_id] = $val->name;
}


//* Used in filter
$content_type_array = [
    // 'post' => 'Blog Posts',
    // 'specialists' => 'Specialists',
    //'faqs' => 'FAQs',
    'lessons' => 'Lessons',
    'video' => 'Videos',
    'subject_toolkit' => 'Subject Leader Toolkits',
    'resource_bank' => 'Resource Bank',
    'featured_documents' => $featTermsKeysToValues,
];

//* Used in filter
$key_stage_array = [
    'key-stage-1' => 'Key Stage 1',
    'lower-key-stage-2' => 'Lower Key Stage 2',
    'upper-key-stage-2' => 'Upper Key Stage 2',
    'teacher-skills' => 'Teacher Skills',
];

//* Used in filter
$year_array = [
    'year-1' => 'Year 1',
    'year-2' => 'Year 2',
    'year-3' => 'Year 3',
    'year-4' => 'Year 4',
    'year-5' => 'Year 5',
    'year-6' => 'Year 6',
];

//* Filter
$filter_array = [
    'Resource_Type' => $content_type_array,
    'Subject' => $subjects_search_array,
    'Key_Stage' => $key_stage_array,
    'Year' => $year_array,
    'Theme' => 'search',
    'Skill' => 'search',
];

?>

<section id="primary" class="content-area">
    <main id="main" class="site-main search-page blog">
        <div class="container">
            <div class="row align-items-start">
                <?php if ($search_text == 'lesson' || $search_text == 'lessons') { ?>
                    <div class="search-posts-wrapper text-center">
                        <span class="enter-text"> Please search for a specific lesson.</span>
                    </div>
                <?php } elseif (get_search_query()) { ?>
                    <?php if (have_posts()) { ?>
                        <div class="search-filters-container col-lg-3">
                            <div class="section-title left-aligned mar-b-3 d-none d-lg-block">
                                <h2 class="topic__title">Filter by:</h2>
                            </div>
                            <div class="search-filter__mobile--button mobile-filter d-flex d-lg-none justify-content-center">
                                <a class="button button--orange text-white "><img src="/wp-content/uploads/2021/07/icon_filters.svg" alt="filters icon">Show filters</a>
                            </div>
                            <input type="hidden" name="search string" id="searchstring" value="<?php echo $search_text; ?>" />
                            <div class="search-filter__option-wrapper ">
                                <div class="search-filter__mobile--close d-lg-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18.451" height="18.451" viewBox="0 0 18.451 18.451">
                                        <path class="a" d="M10.916,9.361,18.1,2.177A1.2,1.2,0,1,0,16.41.486L9.225,7.671,2.041.486a1.2,1.2,0,0,0-1.69,1.69L7.535,9.361.351,16.546a1.2,1.2,0,1,0,1.69,1.69l7.184-7.185,7.185,7.185a1.2,1.2,0,0,0,1.69-1.69Zm0,0" transform="translate(0 -0.136)"></path>
                                    </svg>
                                </div>
                                <div class="search-filter__mobile--title section-title left-aligned mar-b-3 d-lg-none">
                                    <h2 class="topic__title">Filter by:</h2>
                                </div>
                                <?php foreach ($filter_array as $key => $data) {
                                    $label_name = str_replace('_', ' ', $key);
                                    $label = str_replace(' ', '_', $label_name);
                                    $style = 'block';
                                    $class = 'post-types';
                                    if ($key != 'Resource_Type' && $key != 'Year' && $key != 'Subject') {
                                        $style = 'none';
                                        $class = 'lesson-related';
                                    } elseif ($key == 'Year' || $key == 'Subject') {
                                        $class = "lesson-related $key-class";
                                    } ?>
                                    <div class="search-filter__single-option-wrapper <?= $class; ?>" data-search-type="<?= $key; ?>">
                                        <div class="search-filter-option__label"><?= $label_name; ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12.789" height="7.29" viewBox="0 0 12.789 7.29">
                                                <defs>
                                                    <style>
                                                        .a {
                                                            fill: #3a3a3a;
                                                        }
                                                    </style>
                                                </defs>
                                                <g transform="translate(12.789) rotate(90)">
                                                    <path class="a" d="M7.028,7.027l-5.5,5.5A.9.9,0,0,1,.262,11.26L5.128,6.394.262,1.529A.9.9,0,1,1,1.529.262l5.5,5.5a.9.9,0,0,1,0,1.266Z"></path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="content-type search-filter__checkbox-wrapper">
                                            <?php if (is_array($data)) {
                                                foreach ($data as $key => $value) {
                                                    if (is_array($value)) {
                                                        foreach ($value as $singleKey => $singleVal) { ?>
                                                            <div class="search-filter__option-single d-flex <?= isset($_GET[$label]) && str_contains($_GET[$label], $singleKey) ? 'checked' : ''; ?>">
                                                                <input id="<?= $singleKey; ?>" type="checkbox" name="<?= $singleKey; ?>" value="<?= $singleKey; ?>" <?= isset($_GET[$label]) && str_contains($_GET[$label], $singleKey) ? 'checked' : ''; ?>>
                                                                <label for="<?= $singleKey; ?>"><?= $singleVal; ?></label>
                                                                <div class="check-sign">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="21.006" height="16.835" viewBox="0 0 21.006 16.835">
                                                                        <defs>
                                                                            <style>
                                                                                .a {
                                                                                    fill: #f86624;
                                                                                }
                                                                            </style>
                                                                        </defs>
                                                                        <g transform="translate(0 -51.678)">
                                                                            <path class="a" d="M20.626,54l-1.843-1.927a1.269,1.269,0,0,0-1.843,0l-8.89,9.31L4.066,57.2a1.227,1.227,0,0,0-.921-.4,1.228,1.228,0,0,0-.922.4L.379,59.132a1.414,1.414,0,0,0,0,1.927l4.906,5.13,1.843,1.927a1.269,1.269,0,0,0,1.843,0l1.843-1.927,9.812-10.259a1.413,1.413,0,0,0,0-1.927Z" transform="translate(0)"></path>
                                                                        </g>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <div class="search-filter__option-single d-flex <?= isset($_GET[$label]) && str_contains($_GET[$label], $key) ? 'checked' : ''; ?>">
                                                            <input id="<?= $key; ?>" type="checkbox" name="<?= $key; ?>" value="<?= $key; ?>" <?= isset($_GET[$label]) && str_contains($_GET[$label], $key) ? 'checked' : ''; ?>>
                                                            <label for="<?= $key; ?>"><?= $value; ?></label>
                                                            <div class="check-sign">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="21.006" height="16.835" viewBox="0 0 21.006 16.835">
                                                                    <defs>
                                                                        <style>
                                                                            .a {
                                                                                fill: #f86624;
                                                                            }
                                                                        </style>
                                                                    </defs>
                                                                    <g transform="translate(0 -51.678)">
                                                                        <path class="a" d="M20.626,54l-1.843-1.927a1.269,1.269,0,0,0-1.843,0l-8.89,9.31L4.066,57.2a1.227,1.227,0,0,0-.921-.4,1.228,1.228,0,0,0-.922.4L.379,59.132a1.414,1.414,0,0,0,0,1.927l4.906,5.13,1.843,1.927a1.269,1.269,0,0,0,1.843,0l1.843-1.927,9.812-10.259a1.413,1.413,0,0,0,0-1.927Z" transform="translate(0)"></path>
                                                                    </g>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    <?php }
                                                } ?>
                                            <?php } else { ?>
                                                <div class="search-filter__option-input">
                                                    <input type="text" name="<?= $key; ?>" placeholder="Search for <?= $label_name; ?>" value="">
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="search-filter__search-by-topic">
                                    <div class="search-filter__single-option-wrapper lesson-related" data-search-type="Topic">
                                        <p class="orange bold">Or search by Topic</p>
                                        <div class="content-type search-filter__checkbox-wrapper d-block">
                                            <div class="search-filter__option-input">
                                                <input type="text" name="Topic" placeholder="Search for Topic" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="search-posts-wrapper col-lg-9">
                            <div class="search-posts-container">
                                <?php while (have_posts()) {
                                    the_post();
                                    get_template_part('template-parts/content', 'search');
                                } ?>
                    <?php } else { ?>
                        <div class="search-posts-wrapper text-center">
                            <span class="enter-text"> No results for your search.</span>
                        </div>
                    <?php } ?>
                    </div>
                    <?php if ($paged == (intval($wp_query->max_num_pages))) { ?>
                        <div class="no-button-div"></div>
                    <?php } elseif (!have_posts()) {
                        //* Do nothing
                    } else { ?>
                        <div class="search-page__load-more" data-page="1">
                            <button class="button back-blue position-relative">
                                <span class="load-more-link">Load more</span>
                            </button>
                        </div>
                    <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="search-posts-wrapper text-center">
                        <span class="enter-text"> Your search can't be empty.</span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main><!-- #main -->
</section><!-- #primary -->

<?php
get_footer();
