<?php
	echo '<div class="search-result">';
		echo '<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
		echo '<p>';
			the_excerpt();
			echo '<a class="readmore" href="'.get_the_permalink().'">Read More</a>';
		echo '</p>';
	echo '</div>';