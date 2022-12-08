<?php
// image
function cw_ajax_get_is_featured() {
	register_rest_route('cw/v2', '/featured-get/', array(
		'methods' => 'GET',
		'callback' => 'cw_get_is_featured'
	));

}
add_action( 'rest_api_init', 'cw_ajax_get_is_featured' );

function cw_get_is_featured(WP_REST_Request $request) {
    $is_featured = '';
    
	if(isset($_GET['postid']) && !empty($_GET['postid'])) {
        $is_featured = get_post_meta($_GET['postid'], '_cwmb_featured', true);
    }
    
	return $is_featured;
	exit;
}

function cw_ajax_update_is_featured() {
	register_rest_route('cw/v2', '/featured-save/', array(
		'methods' => 'POST',
		'callback' => 'cw_update_is_featured'
	));

}
add_action( 'rest_api_init', 'cw_ajax_update_is_featured' );

function cw_update_is_featured(WP_REST_Request $request) {
	if(
        isset($_POST['postid'])
        && !empty($_POST['postid'])
    ) {
        $diditsave = update_post_meta( $_POST['postid'], '_cwmb_featured', $_POST['isfeatured'] );
    }
    
	return $diditsave;
	exit;
}