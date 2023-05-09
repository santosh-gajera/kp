<?php

/**
 * The header for our theme [presentation]
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
*/

global $kapowUser;
use Kapow\KapowResource;

//* Get the parent lesson, the one we're coming from
$parentLesson = get_post_parent(get_the_ID());
//* Get the resource object from the parent lesson
$resource = new KapowResource($parentLesson->ID);
//* Get the auth object related to the user
$auth = $kapowUser->hasAccessTo($resource)->authorized;

if (!$auth) {
    wp_redirect('/login?redirect_to=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

$page_viewed_check = basename($_SERVER['REQUEST_URI']);

if ($page_viewed_check == 'login' || $page_viewed_check == '?login=failed') {
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
}

// Get relevant fields from ancestors
$ancestors = get_ancestors($post->ID, 'page');

if ($ancestors) {
    $ancestorsReversed = array_reverse($ancestors);
    $topLevelReversed = $ancestorsReversed[0];

    $subjectsParent = get_field('choose_subject', $topLevelReversed);

    $subjectColour = get_field('colour', $subjectsParent);
    $presentationBackgroundPattern = get_field('presentation_background_pattern', $subjectsParent);
    $presentationBackgroundColour = get_field('presentation_background_colour', $subjectsParent);
}

// Subject colours filters to change :after colours
switch ($subjectColour) {
    case 'orange':
        $subjectColourFilter = 'invert(49%) sepia(36%) saturate(3251%) hue-rotate(343deg) brightness(101%) contrast(105%)';
        break;
    case 'blue':
        $subjectColourFilter = 'invert(38%) sepia(80%) saturate(1475%) hue-rotate(193deg) brightness(98%) contrast(102%)';
        break;
    case 'teal':
        $subjectColourFilter = 'invert(5%) sepia(112%) saturate(771%) hue-rotate(148deg) brightness(85%) contrast(130%)';
        break;
    case 'pink':
        $subjectColourFilter = 'invert(16%) sepia(55%) saturate(6986%) hue-rotate(331deg) brightness(86%) contrast(95%)';
        break;
    default:
        $subjectColourFilter = '';
        break;
}

?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msvalidate.01" content="D5A35D4C5B69659ACFD2B7B0D89F4695" />
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@700&family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link href="https://use.typekit.net/spx2qqu.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/featherlight/1.7.13/featherlight.min.css" type="text/css" rel="stylesheet" />

    <script data-cookieconsent="ignore">
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("consent", "default", {
            ad_storage: "denied",
            analytics_storage: "denied",
            wait_for_update: 500,
        });
        gtag("set", "ads_data_redaction", true);
    </script>

    <script>
    var rs_rum_id = "2cfdf4c0-a96f-460f-a32a-a10d2237077e", rs_acc_id = "c917ed15-1b6d-4b59-b2e3-8803bba9bd3d";
    (function(d, t) {
        let s = d.getElementsByTagName(t)[0], r = d.createElement(t);
        r.async = "async"; r.src = "//cdn-assets.rapidspike.com/static/js/timingpcg.min.js";
        s.parentNode.insertBefore(r, s);
    })(document, "script");
    </script>

    <?php if (is_user_logged_in()) {
        if (is_array(Kapow\User::getMeta('subject_interests', get_current_user_id()))) {
            $subjects = Kapow\Util::cleanSubjects(Kapow\User::getMeta('subject_interests', get_current_user_id()));
        }

        $dataLayer = [[
            'memberships'       => Kapow\User::getMemberships(get_current_user_id(), 'active', 'name'),
            'subjectsIntrested' => $subjects,
            'schoolID'          => Kapow\User::getMeta('school_id', get_current_user_id()),
        ]];
        $dataLayer = json_encode($dataLayer);
        ?>
        <script>
            dataLayer = <?= $dataLayer; ?>
        </script>
    <?php } ?>

    <!-- Google Tag Manager -->
    <script data-cookieconsent="ignore">
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NZ6G9LK');
    </script>
    <!-- End Google Tag Manager -->
    <meta name="p:domain_verify" content="a24af7b56365bcdd92dbb5a9692aec51" />


    <meta name="google-site-verification" content="8SzNXH8QD21YRQkZA6UJXTuI8KZ7C85wDPDYa1dVWv8" />

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> style="--presentation-background-colour: <?= $presentationBackgroundColour; ?>;">

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NZ6G9LK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="page" class="site presentation-page"
        style="
            --presentation-background-pattern: url('<?= $presentationBackgroundPattern['url']; ?>');
            --presentation-background-colour: <?= $presentationBackgroundColour; ?>;
            --subject-colour: var(--kapow-<?= $subjectColour; ?>);
            --subject-colour-filter: <?= $subjectColourFilter ?>;
        "
    >
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', '_s'); ?></a>
        <?php
        $the_popup_script = get_field('popup_script');
        if ($the_popup_script) { ?>
            <div style="display:none;">
                <?php
                echo $the_popup_script;
                ?>
            </div>
        <?php } ?>
        <header id="masthead" class="site-header">
            <div class="presentation-header">
                <a href="/" class="presentation-header__logo">
                    <img src="/wp-content/uploads/2020/05/logo-blue.png" alt="Logo">
                </a>
                <?php $parentLesson = getParentLesson(); ?>
                <div class="presentation-header__title"><?= get_the_title($parentLesson); ?></div>
                <div class="presentation-header__buttons">
                    <div data-presentation-id="<?= get_the_ID(); ?>" data-start-presentation class="presentation-header__button presentation-header__button--primary">Start teaching</div>
                    <a data-exit-presentation href="#" class="presentation-header__button presentation-header__button--secondary">Exit presentation</a>
                </div>
            </div>
        </header>
        <div id="content" class="presentation">
