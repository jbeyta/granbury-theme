<?php
// posts list
function cw_posts_list( $atts, $content = null ) {
	global $post;

	ob_start();

		echo '<div class="article-list">';
			$posts = get_posts();

			foreach($posts as $post) {
				echo '<article class="news-article">';
					echo '<span class="close">X</span>';
					
					echo '<h4 class="article-title">';
						echo get_the_title($post->ID);
					echo '</h4>';

					$date = get_the_date('F j, Y');

					echo '<p class="article-date"><b>Posted '.$date.'</b></p>';

					$post_content = $post->post_content;
					$post_excerpt = strip_tags(substr($post_content, 0, 100));

					echo '<p class="article-excerpt">';
						echo $post_excerpt.'...<br><span class="readmore">Read More</span>';
					echo '</p>';

					echo '<div class="article-content">';
						echo get_the_post_thumbnail($post->ID);
						echo '<p>'.$post_content.'</p>';
					echo '</div>';

				echo '</article>';
			}
			wp_reset_query();

		echo '</div>';

	$temp = ob_get_contents();
	ob_end_clean();

	return $temp;
}
add_shortcode( 'get_posts', 'cw_posts_list' );