<?php
// add custom columns in admin

////////////////////////////////////////////////// services /////////////////////////////////////////////////////////////
// add this column to any post type to enable list view toggling
function add_services_columns($columns) {
    return array_merge($columns, 
		array(
			'featured' => 'Featured',
		)
	);
}
add_filter('manage_services_posts_columns' , 'add_services_columns');

function custom_services_column( $column, $post_id ) {
	switch ( $column ) {
		case 'featured':
		echo '<div class="featured-icon" v-bind:class="{featured: featured}" data-postid="'.$post_id.'" v-on:click="changeMeta"><span class="loading" v-if="loading" v-cloak>{{message}}</span></div>';
		break;
	}
}
add_action( 'manage_services_posts_custom_column' , 'custom_services_column', 10, 2  );

////////////////////////////////////////////////// promos /////////////////////////////////////////////////////////////
function add_promos_columns($columns) {
    return array_merge($columns, 
		array(
			'dates' => 'Dates',
		)
	);
}
add_filter('manage_promos_posts_columns' , 'add_promos_columns');

function custom_promos_column( $column, $post_id ) {
    $start = get_post_meta($post_id, '_cwmb_promo_start', true);
    $end = get_post_meta($post_id, '_cwmb_promo_end', true);
 

	switch ( $column ) {
		case 'dates':
		echo '<p class="dates">'.date('F j, Y', $start).' - '.date('F j, Y', $end).'</p>';
		break;
	}
}
add_action( 'manage_promos_posts_custom_column' , 'custom_promos_column', 10, 2  );

////////////////////////////////////////////////// post_types /////////////////////////////////////////////////////////////
function add_cw_post_type_columns($columns) {
    return array_merge($columns, 
		array(
			'metakeys' => 'Meta Keys'
		)
	);
}
add_filter('manage_cw_post_type_posts_columns' , 'add_cw_post_type_columns');

function custom_cw_post_type_column( $column, $post_id ) {

	$meta_keys_data = get_post_meta($post_id, '_cwcpt_cpt_fields', true);
	$metakeys = '';
	if(!empty($meta_keys_data)) {
		foreach ($meta_keys_data as $key => $value) {
			$metakeys .= '_cwmb_'.$value['field_id'].'<br>';
		}
	}

	switch ( $column ) {
		case 'metakeys':
		echo $metakeys;
		break;
	}
}
add_action( 'manage_cw_post_type_posts_custom_column' , 'custom_cw_post_type_column', 10, 2  );

////////////////////////////////////////////////// slides /////////////////////////////////////////////////////////////
function add_slides_columns($columns) {
    return array_merge($columns, 
		array(
			'thumbnail' => 'Thumbnail',
			// 'page' => 'Page'
		)
	);
}
add_filter('manage_slides_posts_columns' , 'add_slides_columns');

function custom_slides_column( $column, $post_id ) {
	global $post;
	$post_id = $post->ID;
	$image = get_post_meta( $post_id , '_cwmb_slide_image' , true );
	$thumbnail = aq_resize($image, 300, 300, false);

	// $title = '<b style="text-transform: uppercase; color: #d10000;">Warning: Slide not shown anywhere on site!</b><br>Click edit and select a page in the right-hand column.';
	// $page = get_post_meta( $post_id , '_cwmb_slide_page' , true );
	// if(!empty($page)) {
	// 	$title = get_the_title($page);
	// }
	
	switch ( $column ) {
		case 'thumbnail':
		echo '<img style="width: 100%; max-width: 300px;" src="'.$thumbnail.'" alt="" />';
		break;

		// case 'page':
		// echo $title;
		// break;	
	}
}
add_action( 'manage_slides_posts_custom_column' , 'custom_slides_column', 10, 2  );

////////////////////////////////////////////////// staff categories /////////////////////////////////////////////////////////////

function add_staff_columns($columns) {
    return array_merge($columns, 
		array(
			'category' => 'Category',
		)
	);
}
add_filter('manage_staff_posts_columns' , 'add_staff_columns');

function custom_staff_column( $column, $post_id ) {
	global $post;
	$terms = wp_get_post_terms($post->ID, 'staff_categories');
	$terms = array_values($terms);

	$output = '';
	if(!empty($terms)) {
		foreach($terms as $key => $term) {
			if($key == 0) {
				$output .= $term->name;
			} else {
				$output .= ', '.$term->name;
			}
		}
	}
	
	switch ( $column ) {
		case 'category':
		echo $output;
		break;
	}
}
add_action( 'manage_staff_posts_custom_column' , 'custom_staff_column', 10, 2  );