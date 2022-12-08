<?php
	$form_id = cw_events_submit_options_get_option('_cweso_form_id');

	$gform_after_submission = 'gform_after_submission_'.$form_id;
	add_action( $gform_after_submission, 'cw_event_submit', 10, 2 );

	function cw_event_submit( $entry, $form ) {
		$post_status = cw_events_submit_options_get_option('_cweso_event_status');
		$event_title_field = cw_events_submit_options_get_option('_cweso_event_title_field');
		$event_start_date_field = cw_events_submit_options_get_option('_cweso_event_start_date_field');
		$event_start_time_field = cw_events_submit_options_get_option('_cweso_event_start_time_field');
		$event_end_date_field = cw_events_submit_options_get_option('_cweso_event_end_date_field');
		$event_end_time_field = cw_events_submit_options_get_option('_cweso_event_end_time_field');
		$event_content_field = cw_events_submit_options_get_option('_cweso_event_content_field');
		$event_image_field = cw_events_submit_options_get_option('_cweso_event_image_field');

		$title = $entry[$event_title_field]; // should be required by form
		$start_date = $entry[$event_start_date_field]; // should be required by form
		$start_time = $entry[$event_start_time_field]; // should be required by form
		$end_date = $entry[$event_end_date_field]; // should be required by form
		$end_time = $entry[$event_end_time_field]; // should be required by form
		$content = $entry[$event_content_field];
		$image_url = $entry[$event_image_field];

		if($image_url) {
			$name = basename($image_url);
			$bits = file_get_contents($image_url);

			$upload = wp_upload_bits($name, null, $bits);

			// $filename should be the path to a file in the upload directory.
			$filename = $upload['file'];

			// Check the type of file. We'll use this as the 'post_mime_type'.
			$filetype = wp_check_filetype( basename( $filename ), null );

			// Get the path to the upload directory.
			$wp_upload_dir = wp_upload_dir();

			// Prepare an array of post data for the attachment.
			$attachment = array(
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit'
			);
		}

		$event_start = $start_date.' '.$start_time;
		$event_end = $end_date.' '.$end_time;

		$es_args = array(
			'post_type' => 'tribe_events',
			'post_title' => $title,
			'post_status' => $post_status,
			'post_content' => $content
		);

		$event_id = wp_insert_post($es_args);

		if($event_id) {
			if($image_url) {
				// Insert the attachment.
				$upload_id = wp_insert_attachment( $attachment, $filename, $event_id );

				// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
				require_once( ABSPATH . 'wp-admin/includes/image.php' );

				// Generate the metadata for the attachment, and update the database record.
				$attach_data = wp_generate_attachment_metadata( $upload_id, $filename );
				wp_update_attachment_metadata( $upload_id, $attach_data );

				set_post_thumbnail($event_id, $upload_id);
			}

			update_post_meta($event_id, '_EventStartDate', $event_start); //start
			update_post_meta($event_id, '_EventEndDate', $event_end); //end
		}
	};