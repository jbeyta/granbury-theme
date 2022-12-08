<?php
	$title = get_the_title();

	$address = get_post_meta($post->ID, '_cmb_aff_address', true);
	$city = get_post_meta($post->ID, '_cmb_aff_city', true);
	$state = get_post_meta($post->ID, '_cmb_aff_state', true);
	$zip = get_post_meta($post->ID, '_cmb_aff_zip', true);
	$phone = get_post_meta($post->ID, '_cmb_aff_phone', true);
	$fax = get_post_meta($post->ID, '_cmb_aff_fax', true);
	$website = get_post_meta($post->ID, '_cmb_aff_url', true);
	$logo = get_post_meta($post->ID, '_cmb_aff_logo', true);

	$cats = wp_get_post_terms($post->ID, $taxonomy);

	echo '<div class="affiliate">';
		echo '<div class="info">';
			if(!empty($title)) { echo '<h5>'.$title.'</h5>'; }

			echo '<p>';	
				if(!empty($address)) { echo $address; }
				if(!empty($city)) { echo '<br>'.$city; }
				if(!empty($state) && !empty($city)) { echo ',';}
				if(!empty($state)) { echo ' '.$state; }
				if(!empty($zip)) { echo ' '.$zip; }
			echo '</p>';

			echo '<p>';	
				if(!empty($phone)) {
					echo '<b>Phone:</b> <a href="tel:'.$phone.'">'.$phone.'</a><br>';
				}

				if(!empty($fax)) {
					echo '<b>Fax:</b> '.$fax.'<br>';
				}

				if(!empty($website)) {
					echo '<a href="'.$website.'" target="_blank">'.$website.'</a>';
				}
			echo '</p>';

			if(!empty($cats)) {
				echo '<p class="categories">';
					foreach ($cats as $cat) {
						echo '<a href="'.$current_url.'?category='.$cat->slug.'">'.$cat->name.'</a>';
					}
				echo '</p>';
			}
		echo '</div>';

		if(!empty($logo)) {
			$cropped = aq_resize($logo, 200, 200, false);
			if(empty($cropped)) {
				$cropped = $logo;
			}
			echo '<img src="'.$cropped.'" alt="'.get_the_title().' - logo" />';
		}	
	echo '</div>';