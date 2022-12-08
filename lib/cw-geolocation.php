<?php

function cw_geolocate_loc_address( $post_id ) {
	$allowed_types = array(
		'locations'
	);

	// If this is just a revision, don't send the email.
	if ( wp_is_post_revision( $post_id ) || !in_array(get_post_type($post_id), $allowed_types) ) {
		return;
	}

	$cwl_address1 = get_post_meta($post_id, '_cwmb_loc_address', true);
	$cwl_city = get_post_meta($post_id, '_cwmb_loc_city', true);
	$cwl_state = get_post_meta($post_id, '_cwmb_loc_state', true);
	$cwl_zip = get_post_meta($post_id, '_cwmb_loc_zip', true);

	$address = $cwl_address1.' '.$cwl_city.', '.$cwl_state.' '.$cwl_zip;
	$address_url = urlencode($address);

	// google map geocode api url
	$url = "https://maps.googleapis.com/maps/api/geocode/json?address={$address_url}&key=".CW_MAPS_API_KEY;

	// get the json response
	$resp_json = file_get_contents($url);

	// decode the json
	$resp = json_decode($resp_json, true);
	$prev_resp = get_post_meta($post_id, '_cwmb_loc_google_resp', true);
	if(empty($prev_resp) || $prev_resp['status'] != 'OK') {
		update_post_meta( $post_id, '_cwmb_loc_google_resp', $resp );
	}
}
add_action( 'save_post', 'cw_geolocate_loc_address' );