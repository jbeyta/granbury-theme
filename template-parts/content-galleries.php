<?php
	$images = get_post_meta($post->ID, '_cwmb_gallery_images', true);
	$desc = get_post_meta($post->ID, '_cwmb_gallery_desc', true);

	if(!empty($desc)) {
		echo '<p>'.nl2br($desc).'</p>';
	}

	if(!empty($images)) {
		echo '<div class="gal-grid row">';
		foreach ($images as $id => $img) {

			$post_obj = get_post($id);
			$title = strip_tags($post_obj->post_content);

			echo '<div class="image s6 m4 l3 end">';
				echo '<a href="'.$img.'" data-lightbox="gallery-'.$post->ID.'" data-title="'.$title.'">';
					cw_img($id);
				echo '</a>';
			echo '</div>';
		}
		echo '</div>';
	}