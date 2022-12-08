<?php
	$address1 = get_post_meta($post->ID, '_cwmb_loc_address1', true);
	$address2 = get_post_meta($post->ID, '_cwmb_loc_address2', true);
	$city = get_post_meta($post->ID, '_cwmb_loc_city', true);
	$state = get_post_meta($post->ID, '_cwmb_loc_state', true);
	$zip = get_post_meta($post->ID, '_cwmb_loc_zip', true);
	$phone = get_post_meta($post->ID, '_cwmb_loc_phone', true);
	$phone2 = get_post_meta($post->ID, '_cwmb_loc_phone2', true);
	$fax = get_post_meta($post->ID, '_cwmb_loc_fax', true);
	$email = get_post_meta($post->ID, '_cwmb_loc_email', true);
	$image_id = get_post_meta($post->ID, '_cwmb_loc_photo_id', true);
	$hours = get_post_meta($post->ID, '_cwmb_loc_hours', true);

	$lat = get_post_meta($post->ID, '_cwmb_loc_lat', true);
	$lon = get_post_meta($post->ID, '_cwmb_loc_lon', true);

	echo '<h3>'.get_the_title().'</h3>';
	cw_img($image_id);

	if(!empty($hours)) {
		echo '<p class="hours"><span class="inner"><b>Hours:</b><br>'.nl2br($hours).'</span></p>';
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