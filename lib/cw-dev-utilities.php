<?php

// Used for cropping images on the fly.
// Read docs here => https://github.com/syamilmj/Aqua-Resizer/
get_template_part( '/lib/aq_resizer' );

/* Include walker for wp_nav_menu */
// get_template_part('lib/foundation_walker');

// for debugging
function echo_pre($input) {
	echo '<pre>';
	print_r($input);
	echo '</pre>';
}

// check if we're in a dev build
function cw_is_dev() {
	$extension = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);
	if($extension == 'dev' || $extension == 'cwdev' || strpos($_SERVER['SERVER_NAME'], 'crane-west.net') || strpos($_SERVER['SERVER_NAME'], 'cwpreview.com')) {
		return true;
	} else {
		return false;
	}
}

// list submenu pages
function list_submenu_admin_pages($parent){
	if(!isset($_GET['dev'])) {
		return;
	}

    global $submenu;

    if ( is_array( $submenu ) && isset( $submenu[$parent] ) ) {
        foreach ( (array) $submenu[$parent] as $item) {
            if ( $parent == $item[2] || $parent == $item[2] )
                continue;
            // 0 = name, 1 = capability, 2 = file
            if ( current_user_can($item[1]) ) {
                $menu_file = $item[2];
                if ( false !== ( $pos = strpos( $menu_file, '?' ) ) )
                    $menu_file = substr( $menu_file, 0, $pos );
                if ( file_exists( ABSPATH . "wp-admin/$menu_file" ) ) {
                    $options[] = "<a href='{$item[2]}'$class>{$item[0]}
                                  </a>";
                } else {
                    $options[] = "<a href='admin.php?page={$item[2]}'>
                                  {$item[0]}</a>";
                }
            }
        }
        return $options;
    }
     echo_pre($submenu);
}
// add_action('admin_menu', 'list_submenu_admin_pages');

/**
 * Remove "Personal Options" from user profile
 *
 * @link http://wpsnipp.com/index.php/functions-php/remove-personal-options-from-user-profiles/
 */
function hide_personal_options(){
echo "\n" . '<script type="text/javascript">jQuery(document).ready(function($) { $(\'form#your-profile > h3:first\').hide(); $(\'form#your-profile > table:first\').hide(); $(\'form#your-profile\').show(); });</script>' . "\n";
}
// add_action('admin_head','hide_personal_options');

// uncomment to allow search enging visibility to be turned off
function cw_default_search_engine_visiblity() {
	$isdev = cw_is_dev();
	if($isdev) {
		update_option('blog_public', 0);
	} else {
		update_option('blog_public', 1);
	}
}
add_action('init', 'cw_default_search_engine_visiblity');

// save a title from post meta
function cw_generate_title( $post_id ){
	global $current_screen;

	$posttype = $current_screen->post_type;

	if($posttype == 'staff'){
		$cw_post_title = $_POST['_first_name'].' '.$_POST['_last_name'];

		$post_args = array(
			'ID' => $post_id,
			'post_title' => $cw_post_title
		);

		if(!wp_is_post_revision($post_id)){
			// unhook this function so it doesn't loop infinitely
			remove_action('save_post', 'cw_generate_title');
			// update the post, which calls save_post again
			wp_update_post( $post_args );
			// re-hook this function
			add_action('save_post', 'cw_generate_title');
		}
	}
}
// add_action('save_post', 'cw_generate_title');

// attempt to add responsive wrapper for embeds
add_filter( 'embed_oembed_html', 'cw_responsify_embed', 99, 4 );
add_filter( 'video_embed_html', 'cw_responsify_embed' ); // Jetpack
function cw_responsify_embed( $html ) {
	return '<div class="video-container">'.$html.'</div>';
}

// turn on ability to hide labels for gravity forms
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );