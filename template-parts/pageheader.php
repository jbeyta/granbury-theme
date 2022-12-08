<?php
    //if is the events plugn post type, stop
	global $wp_query;
	if($wp_query->query_vars['post_type'] == 'tribe_events') {
		return;
	}

	// otherwise, lets build some fancy headers

	if(is_home()) {
		// if it's the home page (posts page) we need to manually get the page-id becuase the loop will have already started and $post->ID will return the id of the first post
		$page_id = get_option('page_for_posts');
	} else {
		// otherwise, $post->ID should work just fine
		$page_id = $post->ID;
	}
	
	// check for post thumbnail, don't ouput any unnecessary html if there isn't an image
	$thumb_url = wp_get_attachment_url( get_post_thumbnail_id($page_id) );
	if(!empty($thumb_url)) {
		echo '<div class="page-header has-bg" style="background-image: url('.$thumb_url.');"></div>';
	}