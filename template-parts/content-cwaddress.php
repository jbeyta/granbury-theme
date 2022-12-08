<?php
	$address1 = get_post_meta($post->ID, '_cwmb_cw_address1', true);
	$address2 = get_post_meta($post->ID, '_cwmb_cw_address2', true);
	$city = get_post_meta($post->ID, '_cwmb_cw_city', true);
	$state = get_post_meta($post->ID, '_cwmb_cw_state', true);
	$zip = get_post_meta($post->ID, '_cwmb_cw_zip', true);
	$phone = get_post_meta($post->ID, '_cwmb_cw_phone', true);
	$phone2 = get_post_meta($post->ID, '_cwmb_cw_phone2', true);
	$fax = get_post_meta($post->ID, '_cwmb_cw_fax', true);
	$email = get_post_meta($post->ID, '_cwmb_cw_email', true);
	$hours = get_post_meta($post->ID, '_cwmb_cw_hours', true);

	// $lat = get_post_meta($post->ID, '_cwmb_cw_lat', true);
	// $lon = get_post_meta($post->ID, '_cwmb_cw_lon', true);

	if(!empty($hours)) {
		echo '<p class="hours"><span class="inner"><b>Hours:</b><br>'.nl2br($hours).'</span></p>';
	}

	if(!empty($address1) && !empty($city) && !empty($state) && !empty($zip)) {
		echo '<div id="map_canvas" style="height: 300px; margin-bottom: 15px;"></div>';
		$address_string = $address1.' '.$city.', '.$state.' '.$zip;
		$address_url = array(array('address' => $address_string, 'title' => get_the_title($post->ID), 'id' => $post->ID));
		wp_localize_script( 'cw_js', 'addresses', $address_url );
	}

	echo '<p class="address">';
		if( !empty($address1) ) { echo $address1; }
		if( !empty($address2) ) { echo '<br>'.$address2; }
		if( !empty($city) ) { echo '<br>'.$city; }
		if( !empty($state)  && !empty($city)) { echo ',';}
		if( !empty($state) ) { echo ' '.$state; }
		if( !empty($zip) ) { echo ' '.$zip; }
	echo '</p>';

	echo '<p>';
		if( !empty($phone) ) { echo '<a href="tel:'.$phone.'"><i class="icon-phone"></i> '.$phone.'</a><br>'; }
		if( !empty($phone2) ) { echo '<a href="tel:'.$phone.'"><i class="icon-phone"></i> '.$phone2.'</a><br>'; }
		if( !empty($fax) ) { echo '<i class="icon-fax"></i> '.$fax.'<br>'; }
		if( !empty($email) ) { echo '<a href="mailto:'.$email.'"><i class="icon-envelope"></i> '.$email.'</a>'; }
	echo '</p>';
?>

