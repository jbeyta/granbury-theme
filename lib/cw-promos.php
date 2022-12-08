<?php
// echo out promo from a position, menu_order by default
function cw_get_promo($position, $orderby = 'menu_order', $order = 'ASC') {
	if(empty($position)) {
		return;
	}

	global $post;

	$pos_w = get_term_meta($position, '_cwmb_width', true);
	$pos_h = get_term_meta($position, '_cwmb_height', true);

	if(!$pos_w) {
		$pos_w = 600;
	}

	if(!$pos_h) {
		$pos_h = 600;
	}

	$pargs = array(
		'post_type' => 'promos',
		'posts_per_page' => 1,
		'orderby' => $orderby,
		'order' => $order,
		'tax_query' => array(
			array (
				'taxonomy' => 'promos_categories',
				'field' => 'slug',
				'terms' => $position
			)
		)
	);

	$promos = new WP_Query($pargs);
	if($promos->have_posts()){
		while($promos->have_posts()) {
			$promos->the_post();

			$image_id = get_post_meta($post->ID, '_cwmb_promo_image_id', true);
			$url = get_post_meta($post->ID, '_cwmb_promo_link', true);

			if(!empty($image_id))	{
				$custom = array(
					'pr_large' => array(
						'w' => ($pos_w * 2),
						'h' => ($pos_h * 2),
						'crop' => true,
						'single' => true,
						'upscale' => true,
					),
					'pr_small' => array(
						'w' => $pos_w,
						'h' => $pos_h,
						'crop' => true,
						'single' => true,
						'upscale' => true,
					)
				);

				echo '<div class="promo">';
					if(!empty($url)) { echo '<a href="'.$url.'">'; }
						cw_img($image_id, 'pr_large', $custom);
					if(!empty($url)) { echo '</a>'; }
				echo '</div>';
			}
		}
	}

	wp_reset_query();
}