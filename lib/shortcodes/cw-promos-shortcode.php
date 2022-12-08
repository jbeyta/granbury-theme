<?php
// promos
function cw_get_promos_sc( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'number' => -1,
		'orderby' => '',
		'order' => ''
	), $atts));

	ob_start();

		$args = array(
			'post_type' => 'promos',
			'posts_per_page' =>  $number,
			'orderby' => 'meta_value_num',
			'meta_key' => '_cwmb_promo_start',
			'order' => 'ASC',
			'meta_query' => array(
				'relation' => 'and',
				array(
					'key' => '_cwmb_promo_start',
					'value' => current_time('timestamp'),
					'compare' => '<='
				),
				array(
					'key' => '_cwmb_promo_end',
					'value' => current_time('timestamp'),
					'compare' => '>='
				)
			)
		);
		$posts = new WP_Query($args);
		if($posts->have_posts()) {
			global $post;
			while($posts->have_posts()) {
				$posts->the_post();
				get_template_part('template-parts/content', 'promos');
			}
		} else {
			echo '<h6>No promotions at this time.</h6>';
		}
		wp_reset_query();

	$temp = ob_get_contents();
	ob_end_clean();

	return $temp;
}
add_shortcode( 'promos', 'cw_get_promos_sc' );