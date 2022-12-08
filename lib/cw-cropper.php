<?php
/**
 * Plugin Name: C|W Image Cropper
 * Plugin URI: http://crane-west.com
 * Description: Custom image cropper
 * Version: 1
 * Author: Crane West
 * Author URI: http://crane-west.com
 * License: GPLv2 or later
 */

//-------------------------- CW Image Cropper --------------------------
// 
//

// load up jquery ui for the crop window
function cw_slides_dereg() {
	global $current_screen;
	// global $wp_scripts;

	if($post_type == 'slides') {

		wp_deregister_script('jquery-ui-core');
		wp_deregister_script('jquery-ui-draggable');

		// foreach( $wp_scripts->queue as $handle ) :
		// 	wp_deregister_script($handle);
		// 	// echo $handle . ' | ';
		// endforeach;
	}
}
// add_action( 'wp_print_scripts', 'cw_slides_dereg', 100);

function cw_slides_jqui() {
	global $current_screen;

	$post_type = $current_screen->post_type;
	if($post_type == 'slides') {

		wp_enqueue_script('jquery_ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js', 'jquery', '1.11.1', true);
		wp_enqueue_style('jquery_ui_css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css');

	}
}
add_action( 'admin_enqueue_scripts', 'cw_slides_jqui', 100);


// render the meta box
function cw_slide_crop_metabox() {
	add_meta_box('testimonials_meta', 'Crop Image', 'cw_slidecrop_meta', 'slides', 'normal', 'high');
}
add_action( 'add_meta_boxes', 'cw_slide_crop_metabox' );


function cw_slidecrop_meta() {
	global $post;

	$cw_width = cw_slideshow_options_get_option('_cwso_slide_width');
	$cw_height = cw_slideshow_options_get_option('_cwso_slide_height');

	if(empty($cw_width)) {
		$cw_width = 1000;
	}

	if(empty($cw_height)) {
		$cw_height = 400;
	}

	$cw_ratio = $cw_width.' / '.$cw_height;


	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="cw_slide_crop_noncename" id="cw_slide_crop_noncename" value="' . wp_create_nonce( ) . '" />';

	// get slide url, id
	$img_src = get_post_meta($post->ID, '_cwmb_slide_image', true);
	$img_id = get_post_meta($post->ID, '_cwmb_slide_image_id', true);

	// get the position and size for cropped image
	$src_x = intval(get_post_meta($post->ID, 'src_x', true));
	$src_y = intval(get_post_meta($post->ID, 'src_y', true));
	$src_w = intval(get_post_meta($post->ID, 'src_w', true));
	$src_h = intval(get_post_meta($post->ID, 'src_h', true));
	$original_w = intval(get_post_meta($post->ID, 'original_w', true));
	$original_h = intval(get_post_meta($post->ID, 'original_h', true));
					
	// if there is no post meta, use these to tell javascript to put nothing in the inputs instead of 0 or NaN
	$src_x_empty = false;
	$src_y_empty = false;
	$src_w_empty = false;
	$src_h_empty = false;
	$original_w_empty = false;
	$original_h_empty = false;

	if(empty($src_x)){
		$src_x_empty = true;
		$src_x = intval(0);
	}

	if(empty($src_y)){
		$src_y_empty = true;
		$src_y = intval(0);
	}

	if(empty($src_w)){
		$src_w_empty = true;
		$src_w = intval(100);
	}

	if(empty($src_h)){
		$src_h_empty = true;
		$src_h = intval(30);
	}

	if(empty($original_w)){
		$original_w_empty = true;
		$original_w = intval(0);
	}

	if(empty($original_h)){
		$original_h_empty = true;
		$original_h = intval(0);
	}

	// echo out the inputs to pass some info along to the save function
	echo '<input type="hidden" id="src_x" name="src_x" value="'.$src_x.'" />';
	echo '<input type="hidden" id="src_y" name="src_y" value="'.$src_y.'" />';
	echo '<input type="hidden" id="src_w" name="src_w" value="'.$src_w.'" />';
	echo '<input type="hidden" id="src_h" name="src_h" value="'.$src_h.'" />';

	echo '<input type="hidden" id="original_w" name="original_w" value="'.$original_w.'" />';
	echo '<input type="hidden" id="original_h" name="original_h" value="'.$original_h.'" />';
?>
	<?php //render out the image and cropper window ?>
	<div class="cw-cropper" style="position: relative; overflow: hidden; width: 100%;">
		<?php
			echo '<div class="cw-crop init-size" style="-webkit-box-shadow: 0 0 0 10000px rgba(0,0,0,.5); box-shadow: 0 0 0 10000px rgba(0,0,0,.5); position: absolute; border: 1px dashed #fff; width: '.$src_w.'%; height: '.$src_h.'%; top: '.$src_y.'%; left: '.$src_x.'%; z-index: 1000;"></div>';
			// echo '<div class="cw-crop" style="resize: both; overflow: auto; -webkit-box-shadow: 0 0 0 10000px rgba(0,0,0,.5); box-shadow: 0 0 0 10000px rgba(0,0,0,.5); position: absolute; border: 1px dashed #fff; width: '.$src_w.'%; height: '.$src_h.'%; top: '.$src_y.'%; left: '.$src_x.'%; z-index: 1000;"></div>';
		?>
		<figure style="margin: 0;">
			<img class="cw-slide" style="width: 100%; height: auto;" src="<?php echo $img_src; ?>" alt="" />
		</figure>
	</div>

	<?php echo_pre($cw_ratio); ?>

	<script>
		window.onload = function(){
			// initial proportional size of cropper window
			function init_size(){
				var init_w = jQuery('.init-size').width();
				var init_h = init_w / 2.5;
				jQuery('.init-size').css({
					'height': init_h+'px'
				});
			}

			// check for any new element being inserted here,

			// or a particular node being modified
			var img_src = jQuery('.img_status img').attr('src');

			// jQuery('.img_status > img').on('remove', function(){
			// 	remove_img();
			// });

			jQuery('.img_status').click(function(){
				setTimeout(function(){
					if(!jQuery(this).find('img')){
						remove_img();
					}
				}, 100);
			});

			// jQuery('.img_status').live('DOMNodeInserted', function() {
			// 	add_img();
			// });

			jQuery(document).bind('DOMNodeInserted', function(e) {
				add_img();
			});

			function remove_img() {
				jQuery('.cw-cropper').slideUp();
				jQuery('.cw-slide').attr('src', '');
			}

			function add_img() {
				img_src = jQuery('.img_status img').attr('src');
				init_size();
				jQuery('.cw-slide').attr('src', img_src);
				jQuery('.cw-cropper').slideDown();
			}

			function metaCoords() {
				<?php if($src_x_empty == true) { ?>
					jQuery('#src_x').attr('value', 0);
				<?php } ?>

				<?php if($src_y_empty == true) { ?>
					jQuery('#src_y').attr('value', 0);
				<?php } ?>

				<?php if($src_w_empty == true) { ?>
					jQuery('#src_w').attr('value', 0);
				<?php } ?>

				<?php if($src_h_empty == true) { ?>
					jQuery('#src_h').attr('value', 0);
				<?php } ?>

				<?php if($original_w_empty == true) { ?>
					jQuery('#original_w').attr('value', 0);
				<?php } ?>

				<?php if($original_h_empty == true) { ?>
					jQuery('#original_h').attr('value', 0);
				<?php } ?>
			}

			function cropCoords() {

				var img = jQuery('.cw-slide');

				// make new instance of image to get original dimensions
				var tempImg = new Image();
				tempImg .src = img.attr('src');
				var original_w = tempImg.width;
				var original_h = tempImg.height;

				// get position and size of crop window
				var position = jQuery('.cw-crop').position();
				var crop_x = Math.round(position.left);
				var crop_y = Math.round(position.top);
				var crop_w = Math.round(jQuery('.cw-crop').width());
				var crop_h = Math.round(jQuery('.cw-crop').height());

				// size of image
				var currentW = img.width();
				var currentH = img.height();

				// generate percentages
				var src_x = Math.round(crop_x / currentW * 100);
				var src_y = Math.round(crop_y / currentH * 100);
				var src_w = Math.round(crop_w / currentW * 100);
				var src_h = Math.round(crop_h / currentH * 100);

				// push percentages to hidden input fields
				jQuery('#src_x').attr('value', src_x);
				jQuery('#src_y').attr('value', src_y);
				jQuery('#src_w').attr('value', src_w);
				jQuery('#src_h').attr('value', src_h);

				// save original images dimensions for later
				jQuery('#original_w').attr('value', original_w);
				jQuery('#original_h').attr('value', original_h);

				// update css widths and heights of crop window
				jQuery('.cw-crop').css({
					'width': src_w+'%',
					'height': src_h+'%',
					'top': src_y+'%',
					'left': src_x+'%'
				});
			}

			// jquery ui stuff
			jQuery('.cw-crop').draggable({
				containment: 'parent'
			});

			jQuery('.cw-cropper').droppable({
				accept: '.cw-crop',
				drop: function(event, ui){
					cropCoords();
				}
			});

			// jQuery('.cw-crop').mousedown(function() {
			// 	var width = $(this).width();

			// 	$(this).css({
			// 		'height': width / 5 + 'px'
			// 	});
			// });

			jQuery('.cw-crop').resizable({
				aspectRatio: <?php echo $cw_ratio; ?>,
				containment: 'parent',
				minWidth: 300,
				resize: function(event, ui){
					cropCoords();
				}
			});

			metaCoords();

			jQuery(window).load(function(){
				cropCoords();
			});
		}
	</script>

<?php 
}
function cw_slidecropper_save_meta($post_id, $post) {
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( $_POST['cw_slide_crop_noncename'] )) {
		return $post->ID;
	}

	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;

	// get the $_POST variables
	$src_x = $_POST['src_x'];
	$src_y = $_POST['src_y'];
	$src_w = $_POST['src_w'];
	$src_h = $_POST['src_h'];
	$original_w = $_POST['original_w'];
	$original_h = $_POST['original_h'];
	$img_id = $_POST['_cwmb_slide_image_id'];

	// echo '<pre>';
	// print_r($_POST);
	// die;

	// size of the final image output, someday I'll make a control panel to control this
	$cw_width = cw_slideshow_options_get_option('_cwso_slide_width');
	$cw_height = cw_slideshow_options_get_option('_cwso_slide_height');

	if(empty($cw_width)) {
		$cw_width = 1000;
	}

	if(empty($cw_height)) {
		$cw_height = 400;
	}

	// get the actual pixel values for the cropper
	$cw_x = ($src_x/100) * $original_w;
	$cw_y = ($src_y/100) * $original_h;
	$cw_w = ($src_w/100) * $original_w;
	$cw_h = ($src_h/100) * $original_h;

	// create a directory for the cropped slides
	wp_mkdir_p(ABSPATH.'wp-content/uploads/cw-cropped-slides/');

	// generate an ABSPATH for the wp_image_editor
	$img_path_info = get_post_meta($img_id, '_wp_attached_file', true);
	$cw_img_path = ABSPATH.'wp-content/uploads/'.$img_path_info;

	// this is where the magic happens
	$edited_image = wp_get_image_editor($cw_img_path);

	// echo '<pre>';
	// print_r($edited_image);
	// echo '</pre>';
	// echo '<hr>'; 
	// die;

	if(!is_wp_error($edited_image)) {
		// echo '<pre>';
		// print_r($edited_image);
		// die;

		// crop the image
		$edited_image->crop( $cw_x, $cw_y, $cw_w, $cw_h, $cw_width, $cw_height, false );
		//generate a file name
		$filename = $edited_image->generate_filename( 'cropped', ABSPATH.'wp-content/uploads/cw-cropped-slides/', NULL );
		// save the file
		$edited_image->save($filename);
	} else {
		// echo '<pre>';
		// print_r($edited_image);
		// die;
	}

	// generate a usable url for the post meta
	$the_image_title = explode('/', $filename);
	$image_title = end($the_image_title);

	// echo '<pre>';
	// print_r($image_title);
	// die;

	// get the current blog path
	$blog_path = get_bloginfo('url');

	if($_POST['original_w'] == 0 && $_POST['original_h'] == 0 ) {
		$cropped_file_path = '';
	} else {
		// final usable file path
		$cropped_file_path = $blog_path.'/wp-content/uploads/cw-cropped-slides/'.$image_title;
	}

	// echo '<pre>';
	// print_r($cropped_file_path);
	// die;

	// save the post meta
	update_post_meta($post->ID, 'cw_cropped_image', $cropped_file_path);

	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.
	$meta['src_x'] = $_POST['src_x'];
	$meta['src_y'] = $_POST['src_y'];
	$meta['src_w'] = $_POST['src_w'];
	$meta['src_h'] = $_POST['src_h'];
	$meta['original_w'] = $_POST['original_w'];
	$meta['original_h'] = $_POST['original_h'];

	// Add values of $meta as custom fields
	foreach ($meta as $key => $value) { // Cycle through the $meta array!
		if( $post->post_type == 'revision' ) return; // Don't store custom data twice
		
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}

		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
	}
}
add_action('save_post', 'cw_slidecropper_save_meta', 1, 2); // save the custom fields
