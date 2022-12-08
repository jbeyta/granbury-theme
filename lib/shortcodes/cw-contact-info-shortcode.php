<?php
// contact info sc
function cw_phone_umber( $atts, $content = null ) {
	global $post;

	ob_start();

		$cwc_phone = cw_contact_get_option('_cwc_phone');
		echo '<a href="tel:'.$cwc_phone.'">'.$cwc_phone.'</a>';

	$temp = ob_get_contents();
	ob_end_clean();

	return $temp;
}
add_shortcode( 'phone_number', 'cw_phone_umber' );

function cw_get_address( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'address' => '',
		'style' => '',
		'phone' => '',
		'phone2' => '',
		'fax' => '',
		'email' => '',
		'hours' => '',
		'social' => '',
		'map' => '',
		'map_width' => '100%',
		'map_height' => '300px',
		'icon' => false,
		'show_all' => false,
		'mobile_icons' => false,
		'map_id' => 'map_canvas_0'
	), $atts));

	ob_start();
		$cwc_address1 = cw_contact_get_option( '_cwc_address1' );
		$cwc_address2 = cw_contact_get_option( '_cwc_address2' );
		$cwc_city = cw_contact_get_option( '_cwc_city' );
		$cwc_state = cw_contact_get_option( '_cwc_state' );
		$cwc_zip = cw_contact_get_option( '_cwc_zip' );
		$cwc_lat = cw_contact_get_option( '_cwc_lat' );
		$cwc_lon = cw_contact_get_option( '_cwc_lon' );
		$map_embed = cw_contact_get_option( '_cwc_map_embed' );

		$address_string = $cwc_address1.' '.$cwc_city.', '.$cwc_state.' '.$cwc_zip;
		$address_url = urlencode($address_string);

		// if($map == 'show' || $show_all == true) {
		// 	echo '<div id="'.$map_id.'" class="cw-map-canvas" style="height: '.$map_height.'; width: '.$map_width.';" data-address="'.$address_string.'" data-lat="'.$cwc_lat.'" data-lon="'.$cwc_lon.'"></div>';
		// }

		if($address == 'show' || $show_all == true) {


			if($style == 'inline') {
				echo '<p class="address">';
					echo '<a class="dir-link" href="http://maps.google.com/maps?saddr=&daddr='.$address_url.'" title="Get Directions" target="_blank" rel="noopener">';
						if($mobile_icons) {
							echo cw_get_icon_svg('mappin');
							echo '<span class="s-hide m-hide">';
						}
						if(!empty($title)) { echo $title.'&nbsp;'; }
						if(!empty($cwc_address1)) { echo $cwc_address1; }
						if(!empty($cwc_address2)) { echo ' '.$cwc_address2; }
						if(!empty($cwc_city)) { echo ', '.$cwc_city; }
						if(!empty($cwc_state) && !empty($cwc_city)) { echo ',';}
						if(!empty($cwc_state)) { echo ' '.$cwc_state; }
						if(!empty($cwc_zip)) { echo ' '.$cwc_zip; }
						if($mobile_icons) {
							echo '</span>';
						}
					echo '</a>';
				echo '</p>';
			} else {
				echo '<p class="address">';
					echo '<a class="dir-link" href="http://maps.google.com/maps?saddr=&daddr='.$address_url.'" title="Get Directions" target="_blank" rel=noopener>';
						if($mobile_icons) {
							echo '<span class="l-hide">';
							echo cw_get_icon_svg('mappin');
							echo '</span>';
							echo '<span class="s-hide m-hide">';
						}
						if(!empty($title)) { echo $title.'<br>'; }
						if(!empty($cwc_address1)) { echo $cwc_address1; }
						if(!empty($cwc_address2)) { echo '<br>'.$cwc_address2; }
						if(!empty($cwc_city)) { echo '<br>'.$cwc_city; }
						if(!empty($cwc_state) && !empty($cwc_city)) { echo ',';}
						if(!empty($cwc_state)) { echo ' '.$cwc_state; }
						if(!empty($cwc_zip)) { echo ' '.$cwc_zip; }
						if($mobile_icons) {
							echo '</span>';
						}
						echo '<br><small>Click for Directions</small>';
					echo '</a>';
				echo '</p>';
			}
		}

		// phone
		if($phone == 'show' || $show_all == true) {
			$cwc_phone = cw_contact_get_option( '_cwc_phone' );
			$clean_phone = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $cwc_phone));

			if(!empty($cwc_phone)) {
				if($icon == true) {
					echo '<p class="phone">';
						if($mobile_icons) {
							echo '<a class="l-hide" href="tel:'.$cwc_phone.'">';
								echo cw_get_icon_svg('phone');
							echo '</a>';
							echo '<span class="s-hide m-hide">';
						}
						echo cw_get_icon_svg('phone');
						echo '  <a href="tel:'.$clean_phone.'">'.$cwc_phone.'</a>';
						if($mobile_icons) {
							echo '</span>';
						}
					echo '</p>';
				} else {
					echo '<p class="phone"><a href="tel:'.$clean_phone.'">';
						if($mobile_icons) {
							echo '<span class="l-hide">';
							echo cw_get_icon_svg('phone');
							echo '</span>';
							echo '<span class="s-hide m-hide">';
						}
						echo $cwc_phone;
						if($mobile_icons) {
							echo '</span>';
						}
					echo '</a></p>';
				}
			}
		}

		if($phone2 == 'show' || $show_all == true) {
			$cwc_phone2 = cw_contact_get_option( '_cwc_phone2' );
			$clean_phone2 = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $cwc_phone2));

			if(!empty($cwc_phone2)) {
				if($icon == true) {
					echo '<p class="phone">';
						if($mobile_icons) {
							echo '<a class="l-hide" href="tel:'.$cwc_phone.'">';
								echo cw_get_icon_svg('phone');
							echo '</a>';
							echo '<span class="s-hide m-hide">';
						}
						echo cw_get_icon_svg('phone');
						echo '  <a href="tel:'.$clean_phone.'">'.$cwc_phone.'</a>';
						if($mobile_icons) {
							echo '</span>';
						}
					echo '</p>';
				} else {
					echo '<p class="phone"><a href="tel:'.$clean_phone2.'">';
						if($mobile_icons) {
							echo '<span class="l-hide">';
							echo cw_get_icon_svg('phone');
							echo '</span>';
							echo '<span class="s-hide m-hide">';
						}
						echo $cwc_phone2;
						if($mobile_icons) {
							echo '</span>';
						}
					echo '</a></p>';
				}
			}
		}

		// fax
		if($fax == 'show' || $show_all == true) {
			$cwc_fax = cw_contact_get_option( '_cwc_fax' );

			if(!empty($cwc_fax)) {
				if($icon == true) {
					echo '<p class="fax">';
						if($mobile_icons) {
							echo '<span class="l-hide">';
							echo cw_get_icon_svg('fax');
							echo '</span>';
							echo '<span class="s-hide m-hide">';
						}
						echo cw_get_icon_svg('fax');
						echo '  <span>'.$cwc_fax.'</span>';
						if($mobile_icons) {
							echo '</span>';
						}
					echo '</p>';
				} else {
					echo '<p class="fax">';
						if($mobile_icons) {
							echo '<span class="l-hide">';
							echo cw_get_icon_svg('fax');
							echo '</span>';
							echo '<span class="s-hide m-hide">';
						}
						echo '<span>'.$cwc_fax.'</span>';
						if($mobile_icons) {
							echo '</span>';
						}
					echo '</p>';
				}
			}
		}

		// email
		if($email == 'show' || $show_all == true) {
			$cwc_email = cw_contact_get_option( '_cwc_email' );

			if(!empty($cwc_email)) {
				if($icon == true) {
					echo '<p class="email">';
						if($mobile_icons) {
							echo '<a href="mailto:'.$cwc_email.'">';
							echo cw_get_icon_svg('envelope');
							echo '</a>';
							echo '<span class="s-hide m-hide">';
						}
						echo cw_get_icon_svg('envelope');
						echo '  <a href="mailto:'.$cwc_email.'">'.$cwc_email.'</a>';
						if($mobile_icons) {
							echo '</span>';
						}
					echo '</p>';
				} else {
					echo '<p class="email"><a href="mailto:'.$cwc_email.'">';
						if($mobile_icons) {
							echo '<span class="l-hide">';
							echo cw_get_icon_svg('envelope');
							echo '</span>';
							echo '<span class="s-hide m-hide">';
						}
						echo $cwc_email;
						if($mobile_icons) {
							echo '</span>';
						}
					echo '</a></p>';
				}
			}
		}

		// hours
		if($hours == 'show' || $show_all == true) {
			$cwc_hours = cw_contact_get_option('_cwc_hours');

			if(!empty($cwc_hours)) {
				if($icon == true) {
					echo '<p class="sc-hours">';
						echo cw_get_icon_svg('clock');
						echo '<br>'.nl2br($cwc_hours).'';
					echo '</p>';
				} else {
					echo '<p class="hours">';
						echo nl2br($cwc_hours);
					echo '</p>';
				}
			}
		}

		// social
		if($social == 'show_all') {
			$show_all = true;
		}

		if($social == 'facebook' || $show_all == true){
			$cwc_facebook = cw_contact_get_option( '_cwc_facebook' );
			if(!empty($cwc_facebook)) {
				echo '<a class="social-icon" href="'.$cwc_facebook.'" target="_blank" rel=noopener>';
					echo cw_get_social_link_svg($cwc_facebook);
				echo '</a>';
			}
		}

		if($social == 'twitter' || $show_all == true){
			$cwc_twitter = cw_contact_get_option( '_cwc_twitter' );

			if(!empty($cwc_twitter)) {
				echo '<a class="social-icon" href="'.$cwc_twitter.'" target="_blank" rel=noopener>';
					echo cw_get_social_link_svg($cwc_twitter);
				echo '</a>';
			}
		}

		if($social == 'youtube' || $show_all == true){
			$cwc_youtube = cw_contact_get_option( '_cwc_youtube' );

			if(!empty($cwc_youtube)) {
				echo '<a class="social-icon" href="'.$cwc_youtube.'" target="_blank" rel=noopener>';
					echo cw_get_social_link_svg($cwc_youtube);
				echo '</a>';
			}
		}

		if($social == 'linkedin' || $show_all == true){
			$cwc_linked = cw_contact_get_option( '_cwc_linked' );

			if(!empty($cwc_linked)) {
				echo '<a class="social-icon" href="'.$cwc_linked.'" target="_blank" rel=noopener>';
					echo cw_get_social_link_svg($cwc_linked);
				echo '</a>';
			}
		}

		if($social == 'pinterest' || $show_all == true){
			$cwc_pinterest = cw_contact_get_option( '_cwc_pinterest' );

			if(!empty($cwc_pinterest)) {
				echo '<a class="social-icon" href="'.$cwc_pinterest.'" target="_blank" rel=noopener>';
					echo cw_get_social_link_svg($cwc_pinterest);
				echo '</a>';
			}
		}

		if($social == 'instagram' || $show_all == true){
			$cwc_instagram = cw_contact_get_option( '_cwc_instagram' );

			if(!empty($cwc_instagram)) {
				echo '<a class="social-icon" href="'.$cwc_instagram.'" target="_blank" rel=noopener>';
					echo cw_get_social_link_svg($cwc_instagram);
				echo '</a>';
			}
		}
	$temp = ob_get_contents();
	ob_end_clean();

	return $temp;
}
add_shortcode( 'contact_info', 'cw_get_address' );