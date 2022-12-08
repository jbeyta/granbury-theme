<?php
	echo '<div class="news-list-article">';
		if(has_post_thumbnail()) {
			 $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );
			//  echo_pre($image);
			echo '<div class="row">';
				echo '<div class="img-cont s6">';
					echo '<a href="'.get_the_permalink().'">';
						the_post_thumbnail();
					echo '</a>';
				echo '</div>';

				echo '<div class="s6 title-date">';
					echo '<h5 class="post-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>';
					echo '<p class="date">'.get_the_date('n/j/Y').'</p>';
				echo '</div>';
			echo '</div>';
		} else {
			echo '<div class="title-date">';
				echo '<h5 class="post-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h5>';
				echo '<p class="date">'.get_the_date('n/j/Y').'</p>';
			echo '</div>';
		}
	echo '</div>';
