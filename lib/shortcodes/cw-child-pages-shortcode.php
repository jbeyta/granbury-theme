<?php
// child pages sc
function cw_get_child_pages( $atts, $content = null ) {
	global $post;

	extract(shortcode_atts(array(
		'style' => 'list'
	), $atts));

	ob_start();

		global $post;

		$args = array(
			'post_type' => 'page',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_parent' => $post->ID
		);
		
		$posts = new WP_Query($args);
		if($posts->have_posts()) {
			if($style == 'list') {
				echo '<ul>';
			}

			if($style == 'grid') {
				echo '<div class="row ai-stretch">';
			}

			while($posts->have_posts()) {
				$posts->the_post();

				if($style == 'list') {
					echo '<li><a href="'.get_the_permalink().'"><h6>'.get_the_title().'</h6></a></li>';
				}

				if($style == 'grid') {
					echo '<div class="s6 m4 l3" style="text-align: center; margin-bottom: 30px;">';
						if(has_post_thumbnail()) {
							echo '<a href="'.get_the_permalink().'">'.get_the_post_thumbnail().'</a>';
						}

						echo '<a href="'.get_the_permalink().'"><h6>'.get_the_title().'</h6></a>';
					echo '</div>';
				}
			}

			if($style == 'list') {
				echo '</ul>';
			}

			if($style == 'grid') {
				echo '</div>';
			}
		}
		
		wp_reset_query();

	$temp = ob_get_contents();
	ob_end_clean();

	return $temp;
}
add_shortcode( 'cw_child_pages', 'cw_get_child_pages' );