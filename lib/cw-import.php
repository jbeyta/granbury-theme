<?php
// file/image handler for importing
// for importing images
/**
 * Create the image attachment and return the new media upload id.
 * @author Joshua David Nelson, josh@joshuadnelson.com
 * @since 03.29.2017 updated to a class, utilizing code from Takuro Hishikawa's gist linked below.
 * @see https://gist.github.com/hissy/7352933
 * @see http://codex.wordpress.org/Function_Reference/wp_insert_attachment#Example
 * @link https://joshuadnelson.com/programmatically-add-images-to-media-library/
 */

/*
 *
 * Example Usage
 *
 * $create_image = new JDN_Create_Media_File( $bus_img_url );
 * if(!empty($create_image->attachment_id)) {
 * 	$photo_id = $create_image->attachment_id;
 * 	$photo = wp_get_attachment_url($photo_id);
 * }
*/

class JDN_Create_Media_File {
 
	var $post_id;
	var $image_url;
	var $wp_upload_url;
	var $attachment_id;
	
	/**
	* Setup the class variables
	*/
	public function __construct( $image_url, $post_id = 0 ) {
	
		// Setup class variables
		$this->image_url = esc_url( $image_url );
		$this->post_id = absint( $post_id );
		$this->wp_upload_url = $this->get_wp_upload_url();
		$this->attachment_id = $this->attachment_id ?: false;
		
		return $this->create_image_id();
	
	}
	
	/**
	* Set the upload directory
	*/
	private function get_wp_upload_url() {
		$wp_upload_dir = wp_upload_dir();
		return isset( $wp_upload_dir['url'] ) ? $wp_upload_dir['url'] : false;
	}
	
	/**
	* Create the image and return the new media upload id.
	*
	* @see https://gist.github.com/hissy/7352933
	*
	* @see http://codex.wordpress.org/Function_Reference/wp_insert_attachment#Example
	*/
	public function create_image_id() {
	
		if( $this->attachment_id ) {
			return $this->attachment_id;
		}
		
		if( empty( $this->image_url ) || empty( $this->wp_upload_url ) ) {
			return false;
		}
		
		$filename = basename( $this->image_url );
		
		$upload_file = wp_upload_bits( $filename, null, file_get_contents( $this->image_url ) );
		
		if ( ! $upload_file['error'] ) {
			$wp_filetype = wp_check_filetype( $filename, null );
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_parent' => $this->post_id,
				'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
				'post_content' => '',
				'post_status' => 'inherit'
			);
			$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $this->post_id );
			
			if( ! is_wp_error( $attachment_id ) ) {
			
				require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
				require_once( ABSPATH . 'wp-admin/includes/media.php' );
				
				$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
				wp_update_attachment_metadata( $attachment_id, $attachment_data );
				
				$this->attachment_id = $attachment_id;
				
				return $attachment_id;
			}
		}
		
		return false;
	
	} // end function get_image_id
}

// clean up html
function cw_html_cleanup($string) {
	if(empty($string)) {
		return '';
	}

	$content_clean = str_replace(
		array(
			'<span style="font-size: medium;">',
			'<span style="color: #000000;">',
			'<span style="font-family: Calibri;">',
			'<span>',
			'</span>',
			'<p style="text-align: center;"><em></em>&nbsp;</p>',
			'<em></em>',
			'class="hilight"',
			'<div id="pf-content" class="pf-12">',
			'<div>',
			'</div>',
			'class="p1"',
			'class="p2"',
			'class="p3"',
			'class="p4"',
			'class="p5"',
			'class="p6"',
			'class="p7"',
			'class="p8"',
			'class="p9"',
			'class="p10"',
			'class="p11"',
			'class="p12"',
			'class="p13"',
			'<p>&nbsp;</p>',
			'<p >&nbsp;</p>',
			'class="s1"',
			'class="s2"',
			'class="s3"',
			'class="s4"',
			'class="s5"',
			'class="s6"',
			'class="s7"',
			'class="s8"',
			'class="s9"',
			'class="s10"',
			'class="s11"',
			'class="s12"',
			'class="s13"',
			'<p ><span  style="font-size: 1.4em;">&nbsp;</p>',
			'dir="ltr"',
			'<p class="cl">&nbsp;</p>',
			'<div id="content">',
			'<div class="heading">',
			'<div class="shell">',
			'style="color: #1da1f2;"',
			'<span style="font-family: verdana, geneva, sans-serif;">',
			'<strong>&nbsp;</strong>',
			'<br /><br />',
			'<div style="font-family: Arial;">',
			'<span style="font-size: 10pt;">',
			'<div id="lclbox" class="intrlu">',
			'<div class="col-md-12 col-sm-12 col-xs-24 left-amenities">',
			'<div class="amenity-list-div">',
			'<div class="mhl">',
			'<div class="mvm uiP fsm">',
			'<span class="fwb">',
			'<div class="webs-bin-wrap">',
			'<div class="webs-container webs-module-text ">',
			'<div class="webs-text w-font-cabin">',
			'<span class="wz-bold" data-mce-mark="1">',
			'<div id="webs-bin-56e2f734dcb0ebe52901cfc8" class="webs-bin">',
			'<div class="webs-text ">',
			'<div id="right-area">',
			'<div class="slogan">',
			'<div class="frame">',
			'<div id="header">',
			'<span class="bio">',
			'<span style="font-family: georgia,serif;">',
			'<span style="font-family: verdana, helvetica, sans-serif;">',
			'<span style="font-family: georgia, serif;">',
			'<span style="font-family: verdana,geneva,sans-serif;">',
			'<span class="st">',
			'<span class="csb">',
			'<span style="text-decoration: underline;">',
			'<span style="font-family: Calibri; font-size: medium;">',
			'<span style="font-family: Calibri; color: #000000; font-size: medium;">',
			'<span class="text_exposed_show">',
			'<span data-mce-mark="1">',
			'<span class="Subhead2">',
			'<span class="wz-bold">',
			'<span class="aBn" data-term="goog_1759338540">',
			'<span class="aQJ">',
			'<span class="aBn" data-term="goog_1759338541">',
			'<span class="aQJ">',
			'<span class="aBn" data-term="goog_1759338541">',
			'<span style="font-family: arial, helvetica, sans-serif;">',
			'class="Apple-interchange-newline"',
			'class="Hyperlink"',
			'class="p0"',
			'class="font_9"',
			'class="font_7"',
			'style="color: #3e5c9a;"',
			'style="color: #bd081c;"',
			'style="color: #722b8f;"',
			'style="color: #bc2a8d;"',
			'style="color: #94cfc9;"'
		),
		array(
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
			'',
		),
		stripslashes( (string) $string )
	);

	return $content_clean;
}

// check if url is valid
function cw_does_url_exist($url){
	$ch = curl_init($url);    
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if($code == 200){
		$status = true;
	} else {
		$status = false;
    }

	curl_close($ch);
	return $status;
}