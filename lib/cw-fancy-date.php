<?php
function fancy_date($date) {
	// $date = $post->post_date;

	$today = current_time('mdY');
	$this_hour = current_time('G');

	$today_timestamp = current_time('timestamp');

	$post_timestamp = strtotime($date);
	$post_date_compare = date('mdY', $post_timestamp);
	$post_hour_compare = date('G', $post_timestamp);

	$hours_diff = round(abs($post_timestamp - $today_timestamp) / 3600, 0);

	$date_output = '';

	if($post_date_compare == $today) {
		if($hours_diff < 1) {
			$date_output = round(abs($post_timestamp - $today_timestamp) / 60, 0);

			if($date_output == 1) {
				$date_output .= " minute ago";
			} else {
				$date_output .= " minutes ago";
			}

		} else {
			$date_output = $hours_diff;

			if($date_output == 1) {
				$date_output .= " hour ago";
			} else {
				$date_output .= " hours ago";
			}
		}
	} else {
		$date_output = date('n/j/y', $post_timestamp);
	}

	return $date_output;
}