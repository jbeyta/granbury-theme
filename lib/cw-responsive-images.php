<?php
function cw_crop_img($file_path = '', $w = NULL, $h = NULL, $crop = true, $force_rebuild = false, $as_array = false) {
	$new_img_url = '';

	// make sure the provided file actually exists
	if (!file_exists($file_path)) {
		return NULL;
	}

	$file_path_parts = pathinfo($file_path);
	$size_part = '-' . $w . 'x' . $h;
	$existing_image_path = $file_path_parts['dirname'] . '/' . $file_path_parts['filename'] . $size_part . '.' . $file_path_parts['extension'];

	// make sure we haven'y ready built this file
	if (file_exists($existing_image_path) && !$force_rebuild) {
		$exists_path_parts = explode('/', $existing_image_path);

		$exists_path_parts_count = count($exists_path_parts);
		$exists_path_parts_start = 0;

		foreach ($exists_path_parts as $xkey => $xpart) {
			if ($xpart == 'wp-content') {
				$exists_path_parts_start = $xkey;
			}
		}

		$exists_url = '';
		while ($exists_path_parts_start <= $exists_path_parts_count) {
			if (!empty($exists_path_parts[$exists_path_parts_start])) {
				$exists_url .= '/' . $exists_path_parts[$exists_path_parts_start];
			}

			$exists_path_parts_start++;
		}

		$exists_img_url = get_bloginfo('url') . $exists_url;

		return $exists_img_url;
	}

	$editor = wp_get_image_editor($file_path, array());
	
	if (is_wp_error($editor)) {
		return NULL;
	}

	// Resize the image.
	$result = $editor->resize($w, $h, $crop);
	// echo_pre($result);
	

	// If there's no problem, save it; otherwise, print the problem.
	if (!is_wp_error($result)) {
		$new_img_info = $editor->save($editor->generate_filename());
		
		if (!is_wp_error($new_img_info)) {
			$path_parts = explode('/', $new_img_info['path']);
			$path_parts_count = count($path_parts);
			$path_parts_start = 0;

			foreach ($path_parts as $key => $part) {
				if ($part == 'wp-content') {
					$path_parts_start = $key;
				}
			}

			$new_url = '';
			while ($path_parts_start <= $path_parts_count) {
				if (!empty($path_parts[$path_parts_start])) {
					$new_url .= '/' . $path_parts[$path_parts_start];
				}
				$path_parts_start++;
			}

			$new_img_url = get_bloginfo('url') . $new_url;

			return $new_img_url;
		} else {
			return NULL;
		}
	} else {
		return NULL;
	}
}

function cw_responsive_img($img_id = '', $size = 'full', $custom = array(), $alt = '', $force_rebuild = false, $as_array = false) {
	if (empty($img_id)) {
		return;
	}

	$img_output = '';

	$source = wp_get_attachment_image_src($img_id, $size);
	$image_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);

	if (!empty($alt)) {
		$image_alt = $alt;
	}

	$path = get_attached_file($img_id);
	$resize_failed = false;

	if (!empty($custom)) {
		$srcset = '';
		$sizes = '';

		$i = 0;
		foreach ($custom as $size_name => $size_options) {
			$actual_image = get_post_meta($img_id, '_wp_attachment_metadata', true);

			if(!$size_options['w'] && !$size_options['h']) {
				continue;
			}

			$target_width = $size_options['w'];
			$target_height = $size_options['h'];

			// figure out what ratio we need to crop/scale by and what sizes to send to the cropper
			$ratio = 1;

			$ri_width = 0;
			$ri_height = 0;

			$noeditor = false;

			if($size_options['crop']) {
				// if no width/height are set, just get the dimensions of the original image
				if(empty($target_width)) {
					$target_width = $actual_image['width'];
				}

				if(empty($target_height)) {
					$target_height = $actual_image['height'];
				}

				// landscape or square
				if($target_width > $target_height || $target_width == $target_height) {
					$ratio = ($target_width / $target_height);

					$calc_w = $target_width;
					$calc_h = $target_height;

					$calc_h = round($calc_w * $ratio);

					if($target_width > $actual_image['width']) {
						$calc_w = $target_width;
						$calc_h = $target_height;

						$calc_w = $actual_image['width'];
						$calc_h = round($calc_w * $ratio);
					}

					if($target_height > $actual_image['height']) {
						$calc_w = $target_width;
						$calc_h = $target_height;

						$calc_h = $actual_image['height'];
						$calc_w = round($calc_h * $ratio);
					}

					if($target_width > $actual_image['width'] && $target_height > $actual_image['height']) {
						$calc_h = $actual_image['height'];
						$calc_w = round($calc_h / $ratio);

						if($calc_w > $actual_image['width']) {
							$calc_w = $actual_image['width'];
							$calc_h = round($calc_w * $ratio);
						}
					}

					$ri_width = $calc_w;
					$ri_height = round($calc_w / $ratio);
				}

				// portrait
				if($target_width < $target_height) {
					$ratio = ($target_height / $target_width);

					$calc_w = $target_width;
					$calc_h = $target_height;

					$calc_h = round($calc_w * $ratio);

					if($target_width > $actual_image['width']) {
						$calc_w = $actual_image['width'];
						$calc_h = round($calc_w * $ratio);
					}

					if($target_height > $actual_image['height']) {
						$calc_h = $actual_image['height'];
						$calc_w = round($calc_h / $ratio);
					}

					if($target_width > $actual_image['width'] && $target_height > $actual_image['height']) {
						$calc_h = $actual_image['height'];
						$calc_w = round($calc_h / $ratio);

						if($calc_w > $actual_image['width']) {
							$calc_w = $actual_image['width'];
							$calc_h = round($calc_w * $ratio);
						}
					}

					$ri_width = round($calc_h / $ratio);
					$ri_height = $calc_h;
				}

				if(
					$ri_width == $actual_image['width']
					&& $ri_height == $actual_image['height']
				) {
					$noeditor = true;
				}
			} else  {
				$ri_width = $target_width;
				$ri_height = $target_height;

				if(
					$target_width >= $actual_image['width']
					|| $target_height >= $actual_image['height']
				) {
					$noeditor = true;
				}
			}
			
			if(!$size_options['screensize']) {
				switch ($i) {
					case 0:
						$size_options['screensize'] = 768;
						break;
					case 1:
						$size_options['screensize'] = 1024;
						break;
					case 2:
						$size_options['screensize'] = 1200;
						break;
					default:
						$size_options['screensize'] = 768;
						break;
				}
			}

			$disp_sz = '';

			switch($size_options['screensize']){
				case 768:
					$disp_sz = 'calc(100vw - 30px)';
					break;
				case 1027:
					$disp_sz = 'calc(100vw - 30px)';
					
					break;
				case 1200:
					$disp_sz = $ri_width . 'px';
					break;
				default:
					$disp_sz = $ri_width . 'px';
			}

			if($noeditor) {
				$srcset .= $source[0] . ' ' . $ri_width . 'w, ';
				$sizes .= '(min-width: ' . $size_options['screensize'] . 'px) ' . $disp_sz . ', ';
				$src = $source[0];
			} else {
				$crop_img = $size_options['crop'] ? true : false;
				$cropped_img = cw_crop_img($path, $ri_width, $ri_height, $crop_img, $force_rebuild, $as_array);

				if (!empty($cropped_img)) {
					$srcset .= $cropped_img . ' ' . $ri_width . 'w, ';
					$sizes .= '(min-width: ' . $size_options['screensize'] . 'px) ' . $disp_sz . ', ';
	
					if ($i == 0) {
						$src = $cropped_img;
					}
				} else {
					$resize_failed = true;
				}
			}

			$i++;
		}
	} else {
		$src = $source[0];
		$srcset = wp_get_attachment_image_srcset($img_id, $size);
		$sizes = wp_get_attachment_image_sizes($img_id, $size, get_post_meta($img_id));
	}

	if ($resize_failed) {
		$img_output = '<img src="' . wp_get_attachment_url($img_id) . '" alt="' . $image_alt . '" />';
	} else {
		if (!empty($src)) {
			$img_output = '<img src="' . $src . '" srcset="' . $srcset . '" sizes="' . $sizes . ' 100vw" alt="' . $image_alt . '" />';
		}
	}

	if ($as_array) {
		return array(
			'id' => $img_id,
			'src' => $src,
			'srcset' => $srcset,
			'sizes' => $sizes,
			'alt' => $alt,
		);
	} else {
		if (!empty($src)) {
			return $img_output;
		} else {
			return NULL;
		}
	}
}

function get_cw_img($img_id = '', $size = 'full', $custom = array(), $alt = '', $force_rebuild = false, $as_array = false) {
	if (empty($img_id)) {
		return;
	}

	$img = '';
	$img = cw_responsive_img($img_id, $size, $custom, $alt, $force_rebuild, $as_array);

	return $img;
}

function cw_img($img_id = '', $size = 'full', $custom = array(), $alt = '', $force_rebuild = false, $as_array = false) {
	if (empty($img_id)) {
		return;
	}

	$img = '';
	$img = cw_responsive_img($img_id, $size, $custom, $alt, $force_rebuild, $as_array);

	echo $img;
}

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since CW 2
 * taken from the 2017 theme
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function cw_content_image_sizes_attr($sizes, $size) {
	$sa_width = $size[0];

	if (740 <= $sa_width) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 768px) 82vw, 740px';
	}

	if (is_active_sidebar('sidebar-1') || is_archive() || is_search() || is_home() || is_page()) {
		if (!(is_page() && 'one-column' === get_theme_mod('page_options')) && 767 <= $sa_width) {
			$sizes = '(max-width: 768px) 89vw, (max-width: 1024px) 54vw, (max-width: 1400px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter('wp_calculate_image_sizes', 'cw_content_image_sizes_attr', 10, 2);

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since CW 2
 * taken from the 2017 theme
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function cw_post_thumbnail_sizes_attr($attr, $attachment, $size) {
	if (is_archive() || is_search() || is_home()) {
		$attr['sizes'] = '(max-width: 768px) 89vw, (max-width: 1024px) 54vw, (max-width: 1400px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'cw_post_thumbnail_sizes_attr', 10, 3);
