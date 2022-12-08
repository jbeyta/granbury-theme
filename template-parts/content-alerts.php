<?php
	$aargs = array(
		'post_type' => 'alerts',
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order' => 'DESC'
	);

	$alerts = new WP_Query($aargs);
	if($alerts->have_posts()) {
		while($alerts->have_posts()) {
			$alerts->the_post();

			$alert_text = get_post_meta($post->ID, '_cwmb_alert_text', true);
			$alert_expire = get_post_meta($post->ID, '_cwmb_alert_expire', true);
			$current_date = current_time('timestamp');

			$show = true;

			if(!empty($alert_expire) && $current_date >= $alert_expire) {
				$show = false;
			}

			if(empty($alert_expire)) {
				$show = true;
			}

			if($show) {
				$classes = '';

				if(is_front_page()) {
					$classes = 'showing';
				} else {
					$classes = '';
				}

				if(wp_is_mobile()) {
					$classes = '';
				}

				echo '<div class="alert-cont '.$classes.'"><div class="row"><div class="s12"><div class="alert">';
					echo '<h3 class="alert-title">'.get_the_title().'</h3>';

					if(!empty($alert_text)) {
						echo '<p class="alert-text">'.$alert_text.'</p>';
					}
				echo '<span class="alert-close"><i class="fas fa-times" style="color: #fff;"></i></span>';
				echo '</div></div></div></div>';
				echo '<span class="alert-open"><i class="fas fa-exclamation" style="color: #fff;"></i></span>';
			}
		}
	}
	wp_reset_query();