<?php
// search app endpoint
function cw_search_app_route() {
    register_rest_route('cw-search/v2', '/search/', array(
        'methods' => 'POST',
        'callback' => 'cw_search_app'
    ));
}
add_action( 'rest_api_init', 'cw_search_app_route' );

function cw_search_app() {
	$results = array();
	if(isset($_POST['s']) && !empty($_POST['s'])) {
		$args = array(
			'post_type' => 'any',
			'posts_per_page' => 10,
			'orderby' => 'title',
			'order' => 'ASC',
			's' => $_POST['s']
		);
		
		$posts = new WP_Query($args);
		if($posts->have_posts()) {
			global $post;
			while($posts->have_posts()) {
				$posts->the_post();

				$data = array();
				$data = array(
					'url' => get_the_permalink(),
					'title' => get_the_title(),
					// 'date' => get_the_date(),
					// 'type' => get_post_type($post->ID)
				);

				array_push($results, $data);
			}
		}
	}

	return $results;
	
	wp_reset_query();
	exit;
}