<?php
/**
 * Enqueue front end scripts for CW theme.
 */
add_action("wp_enqueue_scripts", "cw_enqueue_frontend", 11);
function cw_enqueue_frontend() {
	wp_enqueue_script('modernizr', get_template_directory_uri().'/src/js/vendor/modernizr.js', array('jquery'), '2.6.2', false);

	// Enqueue the threaded comments reply scipt when necessary.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	$cssDeps = array();
	$jsDeps = array('wp-element', 'jquery');
	if (is_front_page()) {
		wp_register_style( 'slick-style', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css', array(), '1.9.0', 'all');
		wp_enqueue_style( 'slick-style' );

		wp_register_style( 'slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css', array(), '1.9.0', 'all');
		wp_enqueue_style( 'slick-theme' );

		$cssDeps = array('slick-style', 'slick-theme');
		
		wp_enqueue_script('slickjs', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js', array('jquery'), '1.9.0', true);
		
		$jsDeps = array('wp-element', 'slickjs', 'jquery');
	}

	// theme styles
	$js_file = '/build/index.js';
	$css_file = '/build/index.css';

	$js_mtime = filemtime(get_stylesheet_directory().$js_file);
	wp_enqueue_script('cw_js', get_template_directory_uri().$js_file, $jsDeps, $js_mtime, true);

	$mtime = filemtime(get_stylesheet_directory().$css_file);
	wp_register_style( 'cw-stylesheet', get_template_directory_uri().$css_file, $cssDeps, $mtime, 'all');

	// enqueue the stylesheet
	wp_enqueue_style( 'cw-stylesheet' );

	// add search route to global js
	wp_localize_script('cw_js', 'search_route', array('rest_search_posts' => get_bloginfo('url').'/wp-json/wp/v2/search/?search=%s'));

	// localize endpoints
	$endpoints = array(
		'slides' => get_bloginfo('url').'/wp-json/cw/v2/slides',
		'images' => get_bloginfo('url').'/wp-json/cw/v2/img',
		'contentbyid' => get_bloginfo('url').'/wp-json/wp/v2/posts/',
		'realtors' => get_bloginfo('url').'/wp-json/cw/v2/realtors/',
		'justrealtors' => get_bloginfo('url').'/wp-json/cw/v2/justrealtors',
		'csvagents' => get_bloginfo('url').'/wp-json/cw/v2/csvagents',
		'addrealtorinfo' => get_bloginfo('url').'/wp-json/cw/v2/addrealtorinfo',
		'existingcwrealtorinfos' => get_bloginfo('url').'/wp-json/cw/v2/existingcwrealtorinfos',
	);

	wp_localize_script('cw_js', 'endpoints', $endpoints);
	wp_localize_script('cw_js', 'siteurl', get_bloginfo('url'));
}

function cw_enqueue_admin() {
	$css_file = '/admin/build/index.css';

	wp_register_style( 'cw_admin_css', get_template_directory_uri() . $css_file, false, '1.0.0' );
	wp_enqueue_style( 'cw_admin_css' );

	// enqueue admin js, including blocks
	wp_enqueue_script('cw_admin_js', get_template_directory_uri().'/admin/build/index.js', array('wp-element', 'wp-blocks', 'wp-element', 'wp-i18n'), '1.0.1', true);

	$cw_cpts = array(
		array(
			'id' => '',
			'name' => 'Select a Type'
		),
		array(
			'id' => 'faqs',
			'name' => 'FAQs'
		),
		array(
			'id' => 'testimonials',
			'name' => 'Testimonials'
		),
		array(
			'id' => 'staff',
			'name' => 'Staff'
		),
	);

	wp_localize_script('cw_admin_js', 'cw_cpts', $cw_cpts);
	wp_localize_script('cw_admin_js', 'siteurl', get_bloginfo('url'));

	if($_GET['post']) {
		wp_localize_script('cw_admin_js', 'currentposttype', get_post_type($_GET['post']));
	} else {
		wp_localize_script('cw_admin_js', 'currentposttype', '');
	}

	$endpoints = array(
		'featuredget' => get_bloginfo('url').'/wp-json/cw/v2/featured-get',
		'featuredsave' => get_bloginfo('url').'/wp-json/cw/v2/featured-save',
		'justrealtors' => get_bloginfo('url').'/wp-json/cw/v2/justrealtors',
		'justoffices' => get_bloginfo('url').'/wp-json/cw/v2/justoffices',
		'manualimport' => get_bloginfo('url').'/wp-json/cw/v2/manual-import',
	);

	wp_localize_script('cw_admin_js', 'endpoints', $endpoints);
}
add_action( 'admin_enqueue_scripts', 'cw_enqueue_admin' );