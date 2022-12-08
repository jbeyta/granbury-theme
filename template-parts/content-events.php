<?php
	$start_date = get_post_meta($post->ID, '_EventStartDate', true);
	$month = date('M', strtotime($start_date));
	$day = date('j', strtotime($start_date));

	echo '<div class="event-list-event">';
		echo '<div class="event-date"><span class="month">'.$month.'</span><span class="day">'.$day.'</span></div>';
		echo '<h5 class="event-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>';
	echo '</div>';
