<?php
// faqs
function cw_get_faqs( $atts, $content = null ) {
	global $post;

	extract(shortcode_atts(array(
		'category' => ''
	), $atts));

	ob_start();

		$fargs = array(
			'post_type' => 'faqs',
			'posts_per_page' => -1,
			'orderby' => 'menu_order',
			'order' => 'ASC'
		);

		if($category) {
			$fargs['tax_query'] = array(
				array(
					'taxonomy' => 'faqs_categories',
					'field' => 'slug',
					'terms' => $category
				)
			);
		}
		
		$posts = new WP_Query($fargs);
		if($posts->have_posts()) {
			global $post;
			echo '<div class="cw-accordion">';
			while($posts->have_posts()) {
				$posts->the_post();
				get_template_part('template-parts/content', 'faqs');
			}
			echo '</div>';
		}
		
		wp_reset_query();

	$temp = ob_get_contents();
	ob_end_clean();

	return $temp;
}
add_shortcode( 'faqs', 'cw_get_faqs' );