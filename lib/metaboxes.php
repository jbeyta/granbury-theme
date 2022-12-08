<?php
// ------------------------------------
//
// Custom Meta Boxes
//
// ------------------------------------
// custom meta boxes
function cw_list_services($list = '') {
	$sargs = array(
		'post_type' => 'services',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_status' => 'publish'
	);


	$cw_top_services_list = array('' => 'Select a Service');
	$cw_services_list = array('' => 'Select a Service');
	$cw_services_ids = array();

	$servs = new WP_Query($sargs);
	if($servs->have_posts()) {
		while($servs->have_posts()) {
			$servs->the_post();
			global $post;
			$cw_services_list[$post->ID] = get_the_title();
			array_push($cw_services_ids, $post->ID);

			if(!$post->post_parent) {
				$cw_top_services_list[$post->ID] = get_the_title();
			}
		}
	}
	wp_reset_query();

	if($list == 'top') {
		return $cw_top_services_list;
	} elseif($list == 'ids') {
		return $cw_services_ids;
	} else {
		return $cw_services_list;
	}
}

function cw_page_list() {
	$cw_page_list = array();

	$pages_args = array(
		'post_type' => 'page',
		'order' => 'ASC',
		'orderby' => 'title',
		'posts_per_page' => -1
	);
	$pages = new WP_Query($pages_args);

	if($pages->have_posts()) {
		global $post;
		while($pages->have_posts()) {
			$pages->the_post();
		
			$title = '';

			$ancestors = get_post_ancestors($post);
			$ancestors = array_reverse($ancestors);
			
			if(!empty($ancestors)) {
				foreach ($ancestors as $ancest) {
					$title .= get_the_title($ancest).' &gt; ';
				}
				$title .= get_the_title();
			} else {
				$title = get_the_title();
			}

			$cw_page_list[$post->ID] = $title;
		}
	}
	wp_reset_query();

	asort($cw_page_list);
	$cw_page_list =  array('' => 'Select a page') + $cw_page_list;

	return $cw_page_list;
}

function cw_media_list() {
	$margs = array(
		'post_type' => 'attachment',
		'post_mime_type' =>'application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
		'post_status' => 'inherit',
		'posts_per_page' => -1
	);

	$media = new WP_Query( $margs );

	$cw_media_list = array();
	foreach($media->posts as $file) {
		$cw_media_list[$file->ID] = $file->post_title;
	}

	asort($cw_media_list);
	$cw_media_list =  array('' => 'Select a file') + $cw_media_list;

	return $cw_media_list;
}

function cw_metaboxes( array $meta_boxes ) {
	// use for select, checkbox, radio of list of states
	global $cw_states;

	$prefix = '_cwmb_'; // Prefix for all fields

	$slides = new_cmb2_box( array(
		'id'            => $prefix.'slides',
		'title'         => 'Slide Info',
		'object_types'  => array( 'slides', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );

	$slides->add_field( array(
		'name' => 'Title',
		'id' => $prefix.'slide_title',
		'type' => 'text',
	) );

	$slides->add_field( array(
		'name' => 'Image',
		'id' => $prefix.'slide_image',
		'type' => 'file',
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		)
	) );

	$slides->add_field( array(
		'name' => 'Caption',
		'desc' => '100 Characters',
		'id' => $prefix.'slide_caption',
		'type' => 'textarea',
		'attributes'  => array(
			'maxlength' => 100,
			'onkeyup' => "textCounter('_cwmb_slide_caption', 100);"
		),
		'after_row' => '
		<script>
			function textCounter(field2, maxlimit) {
				var $textarea = jQuery("#"+field2);

				if(!$textarea.next(".cmb2-metabox-description").find(".remain").length) {
					$textarea.next(".cmb2-metabox-description").append("<br><span class=\'remain\'></span>");
				}

				jQuery(".remain").html(maxlimit - $textarea[0].value.length+" out of "+maxlimit+" remain.");
			}

			jQuery(window).load(function(){
				textCounter("_cwmb_slide_caption", 100);
			});
		</script>'
	) );

	$slides->add_field( array(
		'name' => 'Link',
		'id' => $prefix.'slide_link',
		'type' => 'text_url'
	) );

	// locations
	$location = new_cmb2_box( array(
		'id'            => $prefix.'locations',
		'title' => 'Location Info',
		'object_types'  => array( 'locations', ), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );

	$location->add_field( array(
		'name' => 'Address 1',
		'id' => $prefix.'loc_address1',
		'type' => 'text'
	) );

	$location->add_field( array(
		'name' => 'Address 2',
		'id' => $prefix.'loc_address2',
		'type' => 'text'
	) );

	$location->add_field( array(
		'name' => 'City',
		'id' => $prefix.'loc_city',
		'type' => 'text'
	) );

	$location->add_field( array(
		'name' => 'State',
		'id' => $prefix.'loc_state',
		'type' => 'select',
		'options' => $cw_states
	) );

	$location->add_field( array(
		'name' => 'Zip',
		'id' => $prefix.'loc_zip',
		'type' => 'text'
	) );

	$location->add_field( array(
		'name' => 'Phone',
		'id' => $prefix.'loc_phone',
		'type' => 'text'
	) );
	$location->add_field( array(
		'name' => 'Extension',
		'id' => $prefix.'loc_phone_ext',
		'type' => 'text'
	) );

	$location->add_field( array(
		'name' => 'Phone 2',
		'id' => $prefix.'loc_phone2',
		'type' => 'text'
	) );
	$location->add_field( array(
		'name' => 'Extension 2',
		'id' => $prefix.'loc_phone2_ext',
		'type' => 'text'
	) );

	$location->add_field( array(
		'name' => 'Fax',
		'id' => $prefix.'loc_fax',
		'type' => 'text'
	) );

	$location->add_field( array(
		'name' => 'Email',
		'id' => $prefix.'loc_email',
		'type' => 'text'
	) );

	$location->add_field( array(
		'name' => 'Photo',
		'id' => $prefix.'loc_photo',
		'type' => 'file',
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		)
	) );

	$location->add_field( array(
		'name' => 'Hours',
		'id' => $prefix.'loc_hours',
		'type' => 'textarea'
	) );


	// promos
	$promos = new_cmb2_box( array(
		'id'            => $prefix.'promo',
		'title'         => 'Promo Info',
		'object_types'  => array( 'promos', ), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );

	$promos->add_field( array(
		'name' => 'Promo Image',
		'id' => $prefix.'promo_image',
		'type' => 'file',
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		)
	) );

	$promos->add_field( array(
		'name' => 'Link',
		'id' => $prefix.'promo_link',
		'type' => 'text_url'
	) );

	// services
	$services = new_cmb2_box( array(
		'id'            => $prefix.'service_excerpt',
		'title' => 'Options',
		'object_types'  => array( 'services', ), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );
	$services->add_field( array(
		'name' => 'Feature this Service on the Home Page',
		'desc' => 'Featured',
		'id' => $prefix.'featured',
		'type' => 'checkbox'
	) );
	$services->add_field( array(
		'name' => 'Service Image',
		'id' => $prefix.'service_image',
		'type' => 'file',
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		)
	) );

	// testimonials
	$testimonials = new_cmb2_box( array(
		'id'            => $prefix.'testimonials',
		'title' => 'Testimonial',
		'object_types'  => array( 'testimonials', ), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );

	$testimonials->add_field( array(
		'id' => $prefix.'testimonial',
		'type' => 'textarea'
	) );
	$testimonials->add_field( array(
		'name' => 'Vocation',
		'id' => $prefix.'vocation',
		'type' => 'text'
	) );
	$testimonials->add_field( array(
		'name' => 'Location',
		'id' => $prefix.'location',
		'type' => 'text'
	) );

	// staff
	$staff = new_cmb2_box( array(
		'id'            => $prefix.'staff',
		'title' => 'info',
		'object_types'  => array( 'staff', ), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );

	$staff->add_field( array(
		'name' => 'Title',
		'id' => $prefix.'staff_title',
		'type' => 'text'
	) );
	$staff->add_field( array(
		'name' => 'Phone',
		'id' => $prefix.'staff_phone',
		'type' => 'text'
	) );
	$staff->add_field( array(
		'name' => 'Email',
		'id' => $prefix.'staff_email',
		'type' => 'text'
	) );
	$staff->add_field( array(
		'name' => 'Image',
		'id' => $prefix.'staff_image',
		'type' => 'file',
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		)
	) );

	// galleries
	$galleries = new_cmb2_box( array(
		'id'            => $prefix.'galleries',
		'title' => 'Gallery Info',
		'object_types'  => array( 'galleries', ), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );

	$galleries->add_field( array(
		'name' => 'Images',
		'id' => $prefix.'gallery_images',
		'type' => 'file_list',
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		)
	) );

	$galleries->add_field( array(
		'name' => 'Description',
		'id' => $prefix.'gallery_desc',
		'type' => 'textarea'
	) );

	// affiliates
	$affiliates = new_cmb2_box( array(
		'id' => $prefix.'affiliates',
		'title' => 'Info',
		'object_types' => array( 'affiliates' ), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names' => true, // Show field names on the left
	) );

	require(get_stylesheet_directory().'/lib/cw-aff-meta.php');

	foreach ($aff_meta_keys as $mkey) {
		$mtitle = '';

		$mwords = explode('_', $mkey);
		foreach ($mwords as $key => $word) {
			if($key == 0) {
				$mtitle .= ucfirst($word);
			} else {
				$mtitle .= ' '.ucfirst($word);
			}
		}

		$type = 'text';
		
		if($mkey == 'logo_url') {
			$type = 'file';
		}

		$affiliates->add_field( array(
			'name' => $mtitle,
			'id' => $prefix.$mkey,
			'type' => $type
		) );
	}

	$affiliate_people = $affiliates->add_field( array(
		'id'          => $prefix.'affiliate_people',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'cmb2' ),
		'options'     => array(
			'group_title'       => __( 'Entry {#}', 'cmb2' ),
			'add_button'        => __( 'Add Another Entry', 'cmb2' ),
			'remove_button'     => __( 'Remove Entry', 'cmb2' ),
			'sortable'          => true,
		),
	) );
	
	// Id's for group's fields only need to be unique for the group. Prefix is not needed.
	$affiliates->add_group_field( $affiliate_people, array(
		'name' => 'Name',
		'id'   => 'name',
		'type' => 'text',
	) );
	$affiliates->add_group_field( $affiliate_people, array(
		'name' => 'Title',
		'id'   => 'title',
		'type' => 'text',
	) );
	$affiliates->add_group_field( $affiliate_people, array(
		'name' => 'Phone',
		'id'   => 'phone',
		'type' => 'text',
	) );
	$affiliates->add_group_field( $affiliate_people, array(
		'name' => 'Email',
		'id'   => 'email',
		'type' => 'text_email',
	) );

	// cwrealtorinfos
	$cwrealtorinfos = new_cmb2_box( array(
		'id' => $prefix.'cwrealtorinfos',
		'title' => 'Info',
		'object_types'  => array( 'cwrealtorinfos' ), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );
	$cwrealtorinfos->add_field( array(
		'name' => 'realtor',
		'id' => $prefix.'cwrealtor',
		'type' => 'hidden'
	) );
	$cwrealtorinfos->add_field( array(
		'name' => 'Title',
		'id' => $prefix.'title',
		'type' => 'text'
	) );
	$cwrealtorinfos->add_field( array(
		'name' => 'Language(s)',
		'id' => $prefix.'lang',
		'type' => 'text',
		'repeatable' => true
	) );
	$cwrealtorinfos->add_field( array(
		'name' => 'Photo',
		'id' => $prefix.'photo',
		'type' => 'file',
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		)
	) );
	$cwrealtorinfos->add_field( array(
		'name' => 'Website',
		'id' => $prefix.'website',
		'type' => 'text_url'
	) );
	$cwrealtorinfos->add_field( array(
		'name' => 'Facebook',
		'id' => $prefix.'facebook',
		'type' => 'text_url'
	) );
	$cwrealtorinfos->add_field( array(
		'name' => 'Instagram',
		'id' => $prefix.'instagram',
		'type' => 'text_url'
	) );
	$cwrealtorinfos->add_field( array(
		'name' => 'Linked In',
		'id' => $prefix.'linkedin',
		'type' => 'text_url'
	) );
	$cwrealtorinfos->add_field( array(
		'name' => 'Twitter',
		'id' => $prefix.'twitter',
		'type' => 'text_url'
	) );
	$cwrealtorinfos->add_field( array(
		'name' => 'Bio',
		'id' => $prefix.'bio',
		'type' => 'wysiwyg'
	) );

	// cwofficeinfos
	$cwofficeinfos = new_cmb2_box( array(
		'id' => $prefix.'cwofficeinfos',
		'title' => 'Info',
		'object_types'  => array( 'cwofficeinfos'), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );
	$cwofficeinfos->add_field( array(
		'name' => 'office',
		'id' => $prefix.'cwoffice',
		'type' => 'hidden'
	) );
	$cwofficeinfos->add_field( array(
		'name' => 'Logo',
		'id' => $prefix.'photo',
		'type' => 'file',
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		)
	) );
	$cwofficeinfos->add_field( array(
		'name' => 'Facebook',
		'id' => $prefix.'facebook',
		'type' => 'text_url'
	) );
	$cwofficeinfos->add_field( array(
		'name' => 'Instagram',
		'id' => $prefix.'instagram',
		'type' => 'text_url'
	) );
	$cwofficeinfos->add_field( array(
		'name' => 'Linked In',
		'id' => $prefix.'linkedin',
		'type' => 'text_url'
	) );
	$cwofficeinfos->add_field( array(
		'name' => 'Twitter',
		'id' => $prefix.'twitter',
		'type' => 'text_url'
	) );
	
	// cwextrarealtors
	$cwextrarealtors = new_cmb2_box( array(
		'id' => $prefix.'cwextrarealtors',
		'title' => 'Info',
		'object_types'  => array( 'cwextrarealtors'), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'office',
		'id' => $prefix.'cwoffice',
		'type' => 'hidden'
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'First Name*',
		'id' => $prefix.'first_name',
		'type' => 'text',
		'attributes' => array(
            'required' => 'required',
        ),
		'before_row' => '<div style="padding: 10px; background-color: #f4f4f4;"><div style="padding: 15px; background-color: #ccc; color: red; text-align: center; font-size: 1.25em; margin-bottom: 30px;">NOTE: You <strong>MUST</strong> include <u>First Name </u> and <u>Last Name</u> here so the listings can be sorted and displayed properly.</div>'
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'Last Name*',
		'id' => $prefix.'last_name',
		'type' => 'text',
		'attributes' => array(
            'required' => 'required',
        ),
		'after_row' => '</div>'
	) );
	// $cwextrarealtors->add_field( array(
	// 	'name' => 'Full Name',
	// 	'id' => $prefix.'full_name',
	// 	'type' => 'text'
	// ) );
	$cwextrarealtors->add_field( array(
		'name' => 'Title',
		'id' => $prefix.'title',
		'type' => 'text'
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'Photo',
		'id' => $prefix.'photo',
		'type' => 'file',
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		)
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'Email',
		'id' => $prefix.'email',
		'type' => 'text'
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'Website',
		'id' => $prefix.'website',
		'type' => 'text_url'
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'Facebook',
		'id' => $prefix.'facebook',
		'type' => 'text_url'
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'Instagram',
		'id' => $prefix.'instagram',
		'type' => 'text_url'
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'Linked In',
		'id' => $prefix.'linkedin',
		'type' => 'text_url'
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'Twitter',
		'id' => $prefix.'twitter',
		'type' => 'text_url'
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'Cell Phone',
		'id' => $prefix.'cellphone',
		'type' => 'text'
	) );
	$cwextrarealtors->add_field( array(
		'name' => 'Bio',
		'id' => $prefix.'bio',
		'type' => 'wysiwyg'
	) );

	// cwextraoffices
	$cwextraoffices = new_cmb2_box( array(
		'id' => $prefix.'cwextraoffices',
		'title' => 'Info',
		'object_types'  => array( 'cwextraoffices'), // Post type
		'context' => 'normal',
		'priority' => 'default',
		'show_names'    => true, // Show field names on the left
	) );

	$cwextraoffices->add_field( array(
		'name' => 'MLS/Office ID',
		'id' => $prefix.'officemlsid',
		'type' => 'text'
	) );

	$cwextraoffices->add_field( array(
		'name' => 'Address 1',
		'id' => $prefix.'address1',
		'type' => 'text'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Address 2',
		'id' => $prefix.'address2',
		'type' => 'text'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'City',
		'id' => $prefix.'city',
		'type' => 'text'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'State',
		'id' => $prefix.'state',
		'type' => 'select',
		'options' => $cw_states
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Zip',
		'id' => $prefix.'zip',
		'type' => 'text'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Phone',
		'id' => $prefix.'phone',
		'type' => 'text'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Phone 2',
		'id' => $prefix.'phone2',
		'type' => 'text'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Fax',
		'id' => $prefix.'fax',
		'type' => 'text'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Email',
		'id' => $prefix.'email',
		'type' => 'text'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Website',
		'id' => $prefix.'website',
		'type' => 'text_url'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Facebook',
		'id' => $prefix.'facebook',
		'type' => 'text_url'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Instagram',
		'id' => $prefix.'instagram',
		'type' => 'text_url'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Linked In',
		'id' => $prefix.'linkedin',
		'type' => 'text_url'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Twitter',
		'id' => $prefix.'twitter',
		'type' => 'text_url'
	) );
	$cwextraoffices->add_field( array(
		'name' => 'Logo/Image',
		'id' => $prefix.'photo',
		'type' => 'file',
		'query_args' => array(
			'type' => array(
				'image/gif',
				'image/jpeg',
				'image/png',
			),
		)		
	) );

	return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', 'cw_metaboxes' );

// end custom meta boxes

function cmb_show_on_meta_value( $display, $meta_box ) {
	if ( ! isset( $meta_box['show_on']['key'] ) || $meta_box['show_on']['key'] != 'preview' ) {
		return $display;
	}

	$allow = cw_options_get_option('_cwo_allow_dev_notes');

	if(empty($allow)) {
		return false;
	}

	return true;
}
add_filter( 'cmb2_show_on', 'cmb_show_on_meta_value', 10, 2 );

/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function cw_register_taxonomy_metabox() {
	$prefix = '_cwmb_';
	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => $prefix . 'promo_term_meta',
		'title'            => 'Dimensions', // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'promos_categories' ), // Tells CMB2 which taxonomies should have these fields
		'new_term_section' => true, // Will display in the "Add New Category" section
	) );
	$cmb_term->add_field( array(
		'name'     => 'Width',
		'id'       => $prefix . 'width',
		'type'     => 'text',
	) );
	$cmb_term->add_field( array(
		'name'     => 'Height',
		'id'       => $prefix . 'height',
		'type'     => 'text',
	) );
}
add_action( 'cmb2_admin_init', 'cw_register_taxonomy_metabox' );

// realtor search meta box

/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function cw_realtorsearch_metabox() {
	add_meta_box(
		'cw_realtor_search_metabox',
		'Select a Realtor',
		'cw_realtor_search_metabox_interface',
		'cwrealtorinfos',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'cw_realtorsearch_metabox' );

function cw_realtor_search_metabox_interface( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'cwmb_save_realtor_nonce' );
	$cwmbcwrealtor = get_post_meta($_GET['post'], '_cwmb_cwrealtor', true);
	echo '<div id="cw-realtor-search-mother" data-cwmbcwrealtor="'.$cwmbcwrealtor.'"></div>';
}

function cw_reatlor_search_save_meta( $post_id ) {
	if ( !isset( $_POST['cwmb_save_realtor_nonce'] ) || !wp_verify_nonce( $_POST['cwmb_save_realtor_nonce'], basename( __FILE__ ) ) ) {
    	return $post_id;
	}

	if ( array_key_exists( '_realtor', $_POST ) ) {
		update_post_meta(
			$post_id,
			'_cwmb_cwrealtor',
			$_POST['_realtor']
		);
	}
}
add_action( 'save_post', 'cw_reatlor_search_save_meta', 11, 2 );


function cw_officesearch_metabox() {
	add_meta_box(
		'cw_office_search_metabox',
		'Select an Office',
		'cw_office_search_metabox_interface',
		array('cwofficeinfos', 'cwextrarealtors'),
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'cw_officesearch_metabox' );
function cw_office_search_metabox_interface( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'cwmb_save_office_nonce' );
	$cwmbcwoffice = get_post_meta($_GET['post'], '_cwmb_cwoffice', true);
	echo '<div id="cw-office-search-mother" data-cwmbcwoffice="'.$cwmbcwoffice.'"></div>';
}

function cw_office_search_save_meta( $post_id ) {
	if ( !isset( $_POST['cwmb_save_office_nonce'] ) || !wp_verify_nonce( $_POST['cwmb_save_office_nonce'], basename( __FILE__ ) ) ) {
    	return $post_id;
	}

	if ( array_key_exists( '_office', $_POST ) ) {
		update_post_meta(
			$post_id,
			'_cwmb_cwoffice',
			$_POST['_office']
		);
	}
}
add_action( 'save_post', 'cw_office_search_save_meta', 11, 2 );
