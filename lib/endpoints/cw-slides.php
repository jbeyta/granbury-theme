<?php
// get slides
function cw_ajax_get_slides() {
	register_rest_route('cw/v2', '/slides/', array(
		'methods' => 'GET',
		'callback' => 'cw_get_slides'
	));

}
add_action( 'rest_api_init', 'cw_ajax_get_slides' );

function cw_get_slides(WP_REST_Request $request) {
	$slides = array();

	$slides_args = array(
		'post_type' => 'slides',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);

	$the_slides = new WP_Query($slides_args);

	if($the_slides->have_posts()){
		global $post;
		while($the_slides->have_posts()) {
			$the_slides->the_post();

			$slide_title = get_post_meta($post->ID, '_cwmb_slide_title', true);
			$slide_image_id = get_post_meta($post->ID, '_cwmb_slide_image_id', true);
			$slide_caption = get_post_meta($post->ID, '_cwmb_slide_caption', true);
			$slide_link = get_post_meta($post->ID, '_cwmb_slide_link', true);

			$custom = array(
				'slide_large' => array(
					'w' => 1600,
					'h' => 700,
					'crop' => true,
				),
				'slide_small' => array(
					'w' => 1024,
					'h' => 448,
					'crop' => true,
				)
			);

			$slide_image = get_cw_img($slide_image_id, '', $custom);
			// $slide_bg_image = get_post_meta($post->ID, '_cwmb_slide_image', true);

			$data = array();
			$data = array(
				'slide_title' => $slide_title,
				'slide_caption' => $slide_caption,
				'slide_link' => $slide_link,
				'slide_image' => $slide_image,
				// 'slide_bg_image' => $slide_bg_image,
			);

			array_push($slides, $data);
		}
	}
	wp_reset_query();

	return $slides;
	exit;
}