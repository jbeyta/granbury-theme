<?php
function cw_realtors_endpoint() {
	register_rest_route('cw/v2', '/realtors/', array(
		'methods' => 'GET',
		'callback' => 'cw_get_realtors'
	));
}
add_action('rest_api_init', 'cw_realtors_endpoint');

function cw_get_realtors(WP_REST_Request $request) {
    $data = get_option('_realtor_directory_cache');

    return $data;
    exit;
}
