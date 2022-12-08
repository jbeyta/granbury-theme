<?php
// image
function cw_ajax_get_img() {
	register_rest_route('cw/v2', '/img/', array(
		'methods' => 'GET',
		'callback' => 'cw_get_img'
	));
}
add_action('rest_api_init', 'cw_ajax_get_img');

function cw_get_img(WP_REST_Request $request) {
	$img_html = '';
	


	if (isset($_GET['img_id']) && !empty($_GET['img_id'])) {
		$cutsom = array();

        $slide_image_meta = get_post_meta($_GET['img_id'], '_wp_attachment_metadata', true);

		$crop = false;

		if (isset($_GET['crop'])) {
			$crop = $_GET['crop'];
		}

		if (!empty($_GET['imgW']) || !empty($_GET['imgH'])) {
			$imgW = $_GET['imgW'];
			$imgH = $_GET['imgH'];

			$width = 0;
			$height = 0;

            if($slide_image_meta['width'] < $imgW) {
				if(!empty($imgH)) {
					$ratio = ($imgW / $imgH);
					$height = round($slide_image_meta['width'] / $ratio);	
				}

				$width = $slide_image_meta['width'];
			} else {
				$width = $imgW;
			}

            if(!empty($imgH)) {
				if($slide_image_meta['height'] < $imgH) {
					$ratio = ($imgH / $imgW);
					$width = round($slide_image_meta['height'] / $ratio);
					$height = $slide_image_meta['height'];
				} else {
					$height = $imgH;
				}

				if($slide_image_meta['width'] < $imgW && $slide_image_meta['height'] < $imgH) {
					$ratio = ($imgW / $imgH);
					$height = round($slide_image_meta['width'] / $ratio);
					// $width = $slide_image_meta['width'];

					$ratio = ($imgH / $imgW);
					$width = round($slide_image_meta['height'] / $ratio);
					// $height = $slide_image_meta['height'];
				}
			}

			if (!$imgW) { $imgW = NULL; }
			if (!$imgH) { $imgH = NULL; }

			if($width == $slide_image_meta['width'] ) {
				$width = $width - 10;
			}

			if($height == $slide_image_meta['height'] ) {
				$height = $height - 10;
			}

			$custom['cwimg_large'] = array(
				'w' => $width,
				'h' => $height,
				'crop' => $crop,
			);
		}

		if (!empty($_GET['imgWMed']) || !empty($_GET['imgHMed'])) {
			$imgWMed = $_GET['imgWMed'];
			$imgHMed = $_GET['imgHMed'];

			$width = 0;
			$height = 0;

            if($slide_image_meta['width'] < $imgWMed) {
				if(!empty($imgHMed)) {
					$ratio = ($imgWMed / $imgHMed);
					$height = round($slide_image_meta['width'] / $ratio);
				}
                $width = $slide_image_meta['width'];
            } else {
				$width = $imgWMed;
			}
			
			if(!empty($imgHMed)) {
				if($slide_image_meta['height'] < $imgHMed) {
					$ratio = ($imgHMed / $imgWMed);
					$width = round($slide_image_meta['height'] / $ratio);
					$height = $slide_image_meta['height'];
				} else {
					$height = $imgHMed;
				}


				if($slide_image_meta['width'] < $imgWMed && $slide_image_meta['height'] < $imgHMed) {
					$ratio = ($imgWMed / $imgHMed);
					$height = round($slide_image_meta['width'] / $ratio);
					// $width = $slide_image_meta['width'];

					$ratio = ($imgHMed / $imgWMed);
					$width = round($slide_image_meta['height'] / $ratio);
					// $height = $slide_image_meta['height'];
				}
			}
			
			if (!$imgWMed) {
				$imgWMed = NULL;
			}
			if (!$imgHMed) {
				$imgHMed = NULL;
			}

			if($width == $slide_image_meta['width'] ) {
				$width = $width - 10;
			}

			if($height == $slide_image_meta['height'] ) {
				$height = $height - 10;
			}

			$custom['cwimg_med'] = array(
				'w' => $width,
				'h' => $height,
				'crop' => $crop,
			);
		}

		if (!empty($_GET['imgWSmall']) || !empty($_GET['imgHSmall'])) {
			$imgWSmall = $_GET['imgWSmall'];
			$imgHSmall = $_GET['imgHSmall'];

			$width = 0;
			$height = 0;

            if($slide_image_meta['width'] < $imgWSmall) {
				if(!empty($imgHSmall)) {
					$ratio = ($imgWSmall / $imgHSmall);
					$height = round($slide_image_meta['width'] / $ratio);
				}

                $width = $slide_image_meta['width'];
            } else {
				$width = $imgWSmall;
			}
			
			if(!empty($imgHSmall)) {
				if($slide_image_meta['height'] < $imgHSmall) {
					$ratio = ($imgHSmall / $imgWSmall);
					$width = round($slide_image_meta['height'] / $ratio);
					$height = $slide_image_meta['height'];
				} else {
					$height = $imgHSmall;
				}

				if($slide_image_meta['width'] < $imgWSmall && $slide_image_meta['height'] < $imgHSmall) {
					$ratio = ($imgWSmall / $imgHSmall);
					$height = round($slide_image_meta['width'] / $ratio);
					// $width = $slide_image_meta['width'];

					$ratio = ($imgHSmall / $imgWSmall);
					$width = round($slide_image_meta['height'] / $ratio);
					// $height = $slide_image_meta['height'];
				}
			}

			if (!$imgWSmall) {
				$imgWSmall = NULL;
			}
			if (!$imgHSmall) {
				$imgHSmall = NULL;
			}

			if($width == $slide_image_meta['width'] ) {
				$width = $width - 10;
			}

			if($height == $slide_image_meta['height'] ) {
				$height = $height - 10;
			}

			$custom['cwimg_small'] = array(
				'w' => $width,
				'h' => $height,
				'crop' => $crop,
			);
		}		

		$img_html = get_cw_img($_GET['img_id'], 'cwimg', $custom, '', true, true);
	}
	return $img_html;
	exit;
}
