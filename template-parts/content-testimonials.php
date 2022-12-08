<?php
	$testimonial = get_post_meta($post->ID, '_cwmb_testimonial', true);
	$vocation = get_post_meta($post->ID, '_cwmb_vocation', true);
	$location = get_post_meta($post->ID, '_cwmb_location', true);
	// $video = esc_url(get_post_meta($post->ID, '_cwmb_testim_video', true));

	// if(!empty($video)) {
	// 	echo '<div class="video-container">';
	// 	echo wp_oembed_get( $video );
	// 	echo '</div>';
	// }
	
	echo '<blockquote class="testimonial">';
		if(!empty($testimonial)) {
			echo nl2br($testimonial);
		}

		echo '<p class="info"><b>'.get_the_title().'</b>';

			if(!empty($vocation) || !empty($location)) {
				echo '<br>';
			}

			if(!empty($vocation)) {
				echo $vocation;
			}

			if(!empty($vocation) && !empty($location)) {
				echo '<br>';
			}

			if(!empty($location)) {
				echo $location;
			}
		echo '</p>';
	echo '</blockquote>';