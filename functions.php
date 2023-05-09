<?php //@codingStandardsIgnoreLine

/**
 * Theme Functions
 *
 * @package kapow
 * @since 1.0.0
*/

/**
 * ------- Functions Setup -------
*/

//* Make definitions
define('SOBOLD_THEME_PATH', __DIR__);
define('SOBOLD_THEME_URI', get_template_directory_uri());

//* Require Composer
require(SOBOLD_THEME_PATH . '/vendor/autoload.php');

//* Load Env
$dotenv = Dotenv\Dotenv::createImmutable(SOBOLD_THEME_PATH);
$dotenv->safeLoad();


/**
 * ------- Class Based Inits -------
*/

//* Define the KapowUser
global $kapowUser;
$kapowUser = new \Kapow\KapowUser();

//* Login
$login = new \Kapow\Login();
//* SSO
$SSO = new \Kapow\SSO();
//* Dashboard
$dashboard = \Kapow\Dashboard::init();
//* Account
$account = \Kapow\Account::init();
//* SCSS compiler
\Kapow\Compiler::init();
//* MegaMenu Cache
\Kapow\MegaMenuCache::init();
//* S3
\Kapow\S3::init();
//* Document Generator
$documentGenerator = new \Kapow\DocumentGenerator();
$documentGenerator->init();
//* Active Campaign
$ActiveCampaign = new \Kapow\ActiveCampaign();

/**
 * ------- Theme Setup -------
*/

//* Add Theme Support
include(SOBOLD_THEME_PATH . '/inc/theme-setup/theme-support.php');
//* Register Menus
include(SOBOLD_THEME_PATH . '/inc/theme-setup/register-menus.php');
//* Enqueue Scripts
include(SOBOLD_THEME_PATH . '/inc/theme-setup/scripts.php');
//* Enqueue Admin Scripts
include(SOBOLD_THEME_PATH . '/inc/theme-setup/admin-scripts.php');
//* Add ACF Option pages
include(SOBOLD_THEME_PATH . '/inc/theme-setup/acf-option-pages.php');
//* Custom Login Page
include(SOBOLD_THEME_PATH . '/inc/theme-setup/custom-login-page.php');
//* Password Reset
include(SOBOLD_THEME_PATH . '/inc/theme-setup/password-reset.php');
//* Misc
include(SOBOLD_THEME_PATH . '/inc/theme-setup/misc.php');
//* Timeline
include(SOBOLD_THEME_PATH . '/inc/theme-setup/timeline.php');


/**
 * ------- Theme Functions -------
*/

//* Load Template Part
include(SOBOLD_THEME_PATH . '/inc/functions/load-template-part.php');
//* Siblings
include(SOBOLD_THEME_PATH . '/inc/functions/siblings.php');
//* Array Keys Exist
include(SOBOLD_THEME_PATH . '/inc/functions/array-keys-exist.php');
//* Return Free Trials
include(SOBOLD_THEME_PATH . '/inc/functions/return-free-trials.php');
//* Locked Subjects
include(SOBOLD_THEME_PATH . '/inc/functions/return-free-trials-permission.php');
//* Locked Subjects
include(SOBOLD_THEME_PATH . '/inc/functions/locked-subjects.php');
//* Get Subscriptions
include(SOBOLD_THEME_PATH . '/inc/functions/get-subscriptions.php');
//* Check Sub Account Subjects
include(SOBOLD_THEME_PATH . '/inc/functions/check-sub-account-subjects.php');
//* Get Video Thumbnail URI
include(SOBOLD_THEME_PATH . '/inc/functions/get-video-thumbnail-uri.php');
//* Parse video URI
include(SOBOLD_THEME_PATH . '/inc/functions/parse-video-uri.php');
//* Get vimeo thumbnail uri
include(SOBOLD_THEME_PATH . '/inc/functions/get-vimeo-thumbnail-uri.php');
//* Get wistia thumbnail uri
include(SOBOLD_THEME_PATH . '/inc/functions/get-wistia-thumbnail-uri.php');
//* SVG
include(SOBOLD_THEME_PATH . '/inc/functions/svg.php');
//* Memberpress Functions
include(SOBOLD_THEME_PATH . '/inc/functions/memberpress-functions.php');
//* Utilities
include(SOBOLD_THEME_PATH . '/inc/functions/utilities.php');
//* Break text
include(SOBOLD_THEME_PATH . '/inc/functions/break-text.php');
//* Kapow Send Password Reset
include(SOBOLD_THEME_PATH . '/inc/functions/kapow-send-password-reset.php');
//* _s Functions
include(SOBOLD_THEME_PATH . '/inc/functions/s-functions.php');


/**
 * ------- Theme Shortcodes -------
*/

//* Lookup link
include(SOBOLD_THEME_PATH . '/inc/shortcodes/kapowlink.php');


/**
 * ------- Ajax Functions -------
*/

//* Download Counter
include(SOBOLD_THEME_PATH . '/inc/ajax/download-counter.php');
//* School Auto Complete
include(SOBOLD_THEME_PATH . '/inc/ajax/school-auto-complete.php');
//* Presentation Mode
include(SOBOLD_THEME_PATH . '/inc/ajax/presentation.php');
//* Featured Documents Archive
include(SOBOLD_THEME_PATH . '/inc/ajax/featured-documents-ajax.php');
//* Search AJAX 
include(SOBOLD_THEME_PATH . '/inc/ajax/search.php');

/**
 * ------- Report Functions -------
*/
//* Lookup
include(SOBOLD_THEME_PATH . '/inc/reports/lookup.php');
//* Reports
include(SOBOLD_THEME_PATH . '/inc/reports/reports.php');

/**
 * ------- Legacy Functions -------
*/
//* Lesson Functions
// include(SOBOLD_THEME_PATH . '/inc/lesson-functions.php');
