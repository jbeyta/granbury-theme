<?php
////////////////////////////////////
//
// user taxonomy for categories
//
// most of this came from: http://justintadlock.com/archives/2011/10/20/custom-user-taxonomies-in-wordpress
//
////////////////////////////////////

// set up taxonomy
add_action( 'init', 'cw_user_categories', 0 );
function cw_user_categories() {
	 register_taxonomy(
		'category',
		'user',
		array(
			'public' => true,
			'labels' => array(
				'name' => __( 'Categories' ),
				'singular_name' => __( 'Category' ),
				'menu_name' => __( 'Categories' ),
				'search_items' => __( 'Search Categories' ),
				'popular_items' => __( 'Popular Categories' ),
				'all_items' => __( 'All Categories' ),
				'edit_item' => __( 'Edit Category' ),
				'update_item' => __( 'Update Category' ),
				'add_new_item' => __( 'Add New Category' ),
				'new_item_name' => __( 'New Category Name' ),
				'separate_items_with_commas' => __( 'Separate categories with commas' ),
				'add_or_remove_items' => __( 'Add or remove categories' ),
				'choose_from_most_used' => __( 'Choose from the most popular categories' ),
			),
			'rewrite' => array(
				'with_front' => true,
				'slug' => 'category' // Use 'author' (default WP user slug).
			),
			'capabilities' => array(
				'manage_terms' => 'edit_users', // Using 'edit_users' cap to keep this simple.
				'edit_terms'   => 'edit_users',
				'delete_terms' => 'edit_users',
				'assign_terms' => 'read',
			),
			'update_count_callback' => 'cw_update_category_count' // Use a custom function to update the count.
		)
	);
}

// update the count
function cw_update_category_count( $terms, $taxonomy ) {
	global $wpdb;

	foreach ( (array) $terms as $term ) {
		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", $term ) );
		do_action( 'edit_term_taxonomy', $term, $taxonomy );
		$wpdb->update( $wpdb->term_taxonomy, compact( 'count' ), array( 'term_taxonomy_id' => $term ) );
		do_action( 'edited_term_taxonomy', $term, $taxonomy );
	}
}

////////////////////////////////////////////////
//
// Adds the taxonomy page in the admin.

add_action( 'admin_menu', 'cw_categories_page' );
function cw_categories_page() {
	$tax = get_taxonomy( 'category' );
	add_users_page(
		esc_attr( $tax->labels->menu_name ),
		esc_attr( $tax->labels->menu_name ),
		$tax->cap->manage_terms,
		'edit-tags.php?taxonomy=' . $tax->name
	);
}

add_filter( 'parent_file', 'fix_user_tax_page' );
function fix_user_tax_page( $parent_file = '' ) {
	global $pagenow;
	if ( ! empty( $_GET[ 'taxonomy' ] ) && $_GET[ 'taxonomy' ] == 'category' && $pagenow == 'edit-tags.php' ) {
		$parent_file = 'users.php';
	}
	return $parent_file;
}

/* Create custom columns  */
add_filter( 'manage_edit-category_columns', 'cw_manage_category_user_column' );
function cw_manage_category_user_column( $columns ) {

	unset( $columns['posts'] );

	$columns['users'] = __( 'Users' );

	return $columns;
}

/* Customize the output of the custom column */
add_action( 'manage_category_custom_column', 'cw_manage_category_column', 10, 3 );
function cw_manage_category_column( $display, $column, $term_id ) {

	if ( 'users' === $column ) {
		$term = get_term( $term_id, 'category' );
		echo $term->count;
	}
}

/* Add section to the edit user page in the admin to select category. */
add_action( 'show_user_profile', 'cw_edit_user_category_section' );
add_action( 'edit_user_profile', 'cw_edit_user_category_section' );

function cw_edit_user_category_section( $user ) {
	global $current_user;
	$show_for_admin = false;
	if(is_user_logged_in() && !in_array('contributor', $current_user->roles)) {
		$show_for_admin = true;
	}

	$tax = get_taxonomy( 'category' );

	/* Make sure the user can assign terms of the category taxonomy before proceeding. */
	if ( !current_user_can( $tax->cap->assign_terms ) )
		return;

	/* Get the terms of the 'category' taxonomy. */
	$terms = get_terms( 'category', array( 'hide_empty' => false ) ); ?>

	<h3><?php _e( 'Category' ); ?></h3>

	<table class="form-table">

		<tr>
			<th>
				<?php if($show_for_admin == true) { ?>
					<label for="category"><?php _e( 'Select Category' ); ?></label>
				<?php } else { ?>
					<label for="category"><?php _e( 'Your Category(s)' ); ?></label>
				<?php } ?>
			</th>

			<td><?php

			/* If there are any category terms, loop through them and display checkboxes. */
			if ( !empty( $terms ) ) {
				if($show_for_admin == true) {
					foreach ( $terms as $term ) { ?>
						<label for="category-<?php echo esc_attr( $term->slug ); ?>">
							<input type="checkbox" name="category[]" id="category-<?php echo esc_attr( $term->slug ); ?>" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( true, is_object_in_term( $user->ID, 'category', $term ) ); ?> />
							<?php echo $term->name; ?>
						</label><br />
					<?php }
				} else {
					echo '<ul>';
					foreach ( $terms as $term ) {
						if(is_object_in_term( $user->ID, 'category', $term )) {
							echo '<li><h4>'.$term->name.'</h4></li>';
						}
					}
					echo '</ul>';
				}
			}

			/* If there are no category terms, display a message. */
			else {
				_e( 'There are no categories available.' );
			}

			?></td>
		</tr>

	</table>
<?php }

/* Update the category terms when the edit user page is updated. */
add_action( 'personal_options_update', 'cw_save_user_category_terms' );
add_action( 'edit_user_profile_update', 'cw_save_user_category_terms' );

function cw_save_user_category_terms( $user_id ) {
	$tax = get_taxonomy( 'category' );

	/* Make sure the current user can edit the user and assign terms before proceeding. */
	if ( !current_user_can( 'edit_user', $user_id ) && current_user_can( $tax->cap->assign_terms ) )
		return false;

	$terms = array_map('esc_attr', $_POST['category']);

	/* Sets the terms (we're just using a single term) for the user. */
	wp_set_object_terms( $user_id, $terms, 'category', false);

	clean_object_term_cache( $user_id, 'category' );
}
