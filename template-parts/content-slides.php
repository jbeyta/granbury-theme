<?php
	$slides = array();

	$slides_args = array(
		'post_type' => 'slides',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);

	$the_slides = new WP_Query($slides_args);

	if($the_slides->have_posts()){
		global $post;
		while($the_slides->have_posts()) {
			$the_slides->the_post();
			
			$slide_image_id = get_post_meta($post->ID, '_cwmb_slide_image_id', true);
			if($slide_image_id) {
				$custom = array(
					'slide_large' => array(
						'w' => 2500,
						'h' => 1500,
						'crop' => true,
					),
					'slide_small' => array(
						'w' => (2500 / 2),
						'h' => (1500 / 2),
						'crop' => true,
					)
				);					

                $slide_image = get_cw_img($slide_image_id, 'slide_large', $custom);

				$data = array();
				if($slide_image) {
					$data = array(
						'slide_title' => $slide_title,
						'slide_caption' => $slide_caption,
						'slide_link' => $slide_link,
						'slide_image' => $slide_image,
					);

					array_push($slides, $data);
				}
			}
		}
	}
    wp_reset_query();
?>

<div id="cw_ss">
	<div class="cw-slideshow">
		<div class="slider cwslider">
            <?php foreach ($slides as $slide) {
                if($slide['slide_image']) {
                    echo '<div class="slide">';
                        echo '<div class="image-mother">';
                            echo $slide['slide_image'];
                        echo '</div>';

                        echo '<div class="slide-words">';
                            echo '<div class="inner">';
                                if($slide['slide_title']) {
                                    echo '<h3 class="slide-title">'.$slide['slide_title'].'</h3>';
                                }

                                if($slide['slide_caption']) {
                                    echo '<p class="slide-caption">'.$slide['slide_caption'].'</p>';
                                }

                                if($slide['slide_link']) {
                                    echo '<a class="slide-link button" href="'.$slide['slide_link'].'">Learn More</a>';
                                }
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            } ?>
        </div>
	</div>
</div>