<?php
// user permissions and admin clean up

/**
 * Remove Admin Menu Items
 * http://codex.wordpress.org/Function_Reference/remove_menu_page
 * @since CW 1.0
 */
function cw_remove_admin_menu_items() {
	// remove_menu_page( 'index.php' );                  //Dashboard
	// remove_menu_page( 'edit.php' );                   //Posts
	// remove_menu_page( 'upload.php' );                 //Media
	// remove_menu_page( 'edit.php?post_type=page' );    //Pages
	// remove_menu_page( 'edit-comments.php' );          //Comments
	// remove_menu_page( 'themes.php' );                 //Appearance
	// remove_menu_page( 'plugins.php' );                //Plugins
	// remove_menu_page( 'users.php' );                  //Users
	// remove_menu_page( 'tools.php' );                  //Tools
	// remove_menu_page( 'options-general.php' );        //Settings

	$current_user = wp_get_current_user();

	if(in_array('site_admin', $current_user->roles)) {
		remove_menu_page( 'tools.php' );
	}

	if(in_array('site_admin_plus', $current_user->roles)) {
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'options-general.php' );
		remove_menu_page( 'plugins.php' );
		remove_menu_page( 'themes.php?page=editcss' );
		remove_submenu_page( 'themes.php', 'widgets.php' );
		remove_submenu_page( 'themes.php', 'themes.php' );
		remove_submenu_page( 'themes.php', 'customize.php?return=%2Fwp-admin%2Fnav-menus.php' );
		remove_submenu_page( 'themes.php', 'themes.php?page=editcss' );
	}
}
add_action('admin_menu', 'cw_remove_admin_menu_items');

// tinymce stuff, add color or other options
// add styles to my_mce3_options() and enable myplugin_tinymce_buttons() to turn on the UI
function my_mce3_options( $settings ) {
	// echo_pre($settings['formats']);
	// Define the style_formats array
	$style_formats = array(
		// Each array child is a format with it's own settings
		array(
			'title' => 'Orange',
			'block' => 'span',
			'styles' => array(
				'color' => '#E36F18'
			)
		),
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;
}
// add_filter('tiny_mce_before_init', 'my_mce3_options');

function myplugin_tinymce_buttons($buttons) {
	foreach($buttons as $key => $button) {
		// if($button == 'forecolor'){
		// 	unset($buttons[$key]);
		// }
		if($button == 'formatselect') {
			unset($buttons[$key]);
		}
	}
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
// add_filter('mce_buttons_2','myplugin_tinymce_buttons');

// block site admin users from creating administrator users
// take from here http://wordpress.stackexchange.com/questions/4479/editor-can-create-any-new-user-except-administrator
class JPB_User_Caps {

  // Add our filters
  function __construct(){
    add_filter( 'editable_roles', array($this, 'editable_roles'));
    add_filter( 'map_meta_cap', array($this, 'map_meta_cap'), 10, 4);
  }

  // Remove 'Administrator' from the list of roles if the current user is not an admin
  function editable_roles( $roles ){
    if( isset( $roles['administrator'] ) && !current_user_can('administrator') ){
      unset( $roles['administrator']);
    }
    return $roles;
  }

  // If someone is trying to edit or delete and admin and that user isn't an admin, don't allow it
  function map_meta_cap( $caps, $cap, $user_id, $args ){

    switch( $cap ){
        case 'edit_user':
        case 'remove_user':
        case 'promote_user':
            if( isset($args[0]) && $args[0] == $user_id )
                break;
            elseif( !isset($args[0]) )
                $caps[] = 'do_not_allow';
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        case 'delete_user':
        case 'delete_users':
            if( !isset($args[0]) )
                break;
            $other = new WP_User( absint($args[0]) );
            if( $other->has_cap( 'administrator' ) ){
                if(!current_user_can('administrator')){
                    $caps[] = 'do_not_allow';
                }
            }
            break;
        default:
            break;
    }
    return $caps;
  }

}

$jpb_user_caps = new JPB_User_Caps();