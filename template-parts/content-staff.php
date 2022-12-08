<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
	// echo_pre(get_post_meta($post->ID));
	echo '<div class="staff-content row">';
		$title = get_post_meta($post->ID, '_cwmb_staff_title', true);
		$image_id = get_post_meta($post->ID, '_cwmb_staff_image_id', true);
		$email = get_post_meta($post->ID, '_cwmb_staff_email', true);
		$phone = get_post_meta($post->ID, '_cwmb_staff_phone', true);
		$bio = get_the_content();

		if(!empty($image_id)) {
			echo '<div class="m4 l3 img-cont">';
				cw_img($image_id);
			echo '</div>';

			echo '<div class="m8 l9">';
		} else {
			echo '<div class="m12">';
		}

			echo '<h3 class="staff-name">'.get_the_title().'</h3>';

			if(!empty($title)) {
				echo '<h5 class="staff-title">'.$title.'</h5>';
			}

			if(!empty($email)) {
				echo '<p class="email"><a href="mailto:'.$email.'">'.$email.'</a></p>';
			}

			if(!empty($phone)) {
				echo '<p class="phone"><a href="tel:'.$phone.'">'.$phone.'</a></p>';
			}

			if(!empty($bio)) {
				echo apply_filters('the_content', $bio);
			}
		echo '</div>';
	echo '</div>';
