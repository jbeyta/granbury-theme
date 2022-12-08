<?php
/**
 * CW  functions
 *
 * @package WordPress
 * @subpackage CW
 * @since CW 1.1
 */

define('CW_MAPS_API_KEY', 'AIzaSyANH4bwKFcWNPw7YlptlbMstx6kWKjZJYI');

get_template_part('lib/cw-dev-utilities');

get_template_part('lib/cw-theme-utilities'); // theme set up, custom admin stuff, widget areas, theme excerpt stuff, etc.

get_template_part('lib/cmb2-slider-input/cmb2_field_slider');
get_template_part('lib/option-pages/cw-options-page');
// get_template_part('lib/option-pages/cw-slideshow-options-page');
get_template_part('lib/option-pages/cw-import-realtors');

// if( cw_slideshow_options_get_option('_cwso_cropper') == 'on') {
// 	get_template_part('lib/cw-cropper');
// }

get_template_part('lib/option-pages/cw-contact-page');

get_template_part('lib/content', 'states');
get_template_part('lib/metaboxes');
get_template_part('lib/custom-columns');
get_template_part('lib/widgets/cw-widgets');
get_template_part('lib/shortcodes/cw-shortcodes');
get_template_part('lib/cw-ajax-search');
get_template_part('lib/endpoints/cw-endpoints');
get_template_part('lib/cw-responsive-images');
get_template_part('lib/cw-admin-notices');
get_template_part('lib/cw-users');
get_template_part('lib/cw-promos');
get_template_part('lib/cw-import');
get_template_part('lib/cw-enqueue');
get_template_part('lib/cw-pagination');
get_template_part('lib/cw-geolocation');
get_template_part('lib/cw-icons');
get_template_part('lib/cw-discussion');
get_template_part('lib/cw-register-image-block');

require get_template_directory() . '/lib/realtor-dir-cache/cw-realtor-dir-cron.php';

function unslug($slug, $delimiter = '_'){
    $words = '';

    $mwords = explode($delimiter, $slug);

	foreach ($mwords as $key => $word) {
		if($key == 0) {
			$words .= ucfirst($word);
		} else {
			$words .= ' '.ucfirst($word);
		}
    }
    
    return $words;
}

// apply_filters( 'admin_email_check_interval', 9999999 * MONTH_IN_SECONDS );

// uncommment to use cw_mime_type_format() to check mime types
// get_template_part('lib/cw-allowed-file-types');

// uncomment to use fancy_date($date) to format date like: 4 minutes ago, today, yesterday, and then date
// get_template_part('lib/cw-fancy-date');

/* Flush rewrite rules for custom post types. */
// flush_rewrite_rules(true);
// global $wp_rewrite; $wp_rewrite->flush_rules();


// function showstuff(){
// 	echo_pre(get_post_meta($_GET['post']));
// }
// add_action('init', 'showstuff');