<?php
	$images = get_post_meta($post->ID, '_cwmb_gallery_images', true);
	$desc = get_post_meta($post->ID, '_cwmb_gallery_desc', true);

	if(!empty($desc)) {
		echo '<p>'.nl2br($desc).'</p>';
	}

	if(!empty($images)) {
		echo '<div class="row">';
		foreach ($images as $id => $img) {

			echo '<div class="s6 m4 l3 end">';
				echo '<a href="'.$img.'" data-lightbox="gallery-'.$post->ID.'">';
					cw_img($id);
				echo '</a>';
			echo '</div>';
		}
		echo '</div>';
	}