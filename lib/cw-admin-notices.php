<?php
function cw_google_analytics_alert() {
	$ga_code = cw_options_get_option('_cwo_ga');
	if(empty($ga_code)) {
		echo '<div class="notice notice-error is-dismissible" style="padding: 15px;">';
			echo '<h4 style="display: inline-block; margin: 0 0 0 0;">No Google Analytics Code</h4>&nbsp;|&nbsp;<a style="display: inline-block;" href="/wp-admin/admin.php?page=cw_options_options">Click here to add the code</a>';
		echo '</div>';
	}
}
add_action( 'admin_notices', 'cw_google_analytics_alert' );

// default gform notifications
function cw_list_default_gform_notifs() {
	if(!is_admin() || !class_exists( 'GFCommon' )) {
		return;
	}

	$change_these = array();

	$forms = RGFormsModel::get_forms( null, 'title' );
	if(!empty($forms)) {
		foreach( $forms as $form ) {

			if($form->is_active) {

				$form_obj = GFAPI::get_form( $form->id );
				$notifications = $form_obj['notifications'];

				if(!empty($notifications)) {
					foreach ($notifications as $key => $data) {

						$notif = '';

						$notif .= '<div class="notice notice-error is-dismissible" style="padding: 15px;">';
							$notif .= '<h3 style="margin: 0 0 10px 0;">Gravity Forms Notification</h3><h4 style="margin: 0 0 10px 0;">Default "Send to Email" Detected</h4> Form title: <b>"'.$form->title.'"</b>, Notification title: <b>"'.$data['name'].'"</b> &nbsp;|&nbsp;<a style="display: inline-block;" href="/wp-admin/admin.php?page=gf_edit_forms&view=settings&subview=notification&id='.$form->id.'&nid='.$key.'">Click here to edit this notification</a>';
						$notif .= '</div>';

						if($data['to'] == '{admin_email}') {
							if(array_key_exists('isActive', $data)) {
								if($data['isActive'] == 1) {
									echo $notif;
								}
							} else {
								echo $notif;
							}
						}
					}
				}
			}
		}
	}
}
add_action( 'admin_notices', 'cw_list_default_gform_notifs' );