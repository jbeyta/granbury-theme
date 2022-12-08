<?php


// fancy costumizable pagination
// from http://sgwordpress.com/teaches/how-to-add-wordpress-pagination-without-a-plugin/
//
// usage
//
// if (function_exists('pagination')) {
// 	pagination($posts->max_num_pages);
// }

// IF PAGINTION IS NOT WORKING READ THIS
// make sure you use the right query var, some of the ones on the internet are wrong, even from the wp website. It's 'paged' and not 'page', see below
// $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

function pagination($pages = '', $range = 4) {
	$showitems = ($range * 2)+1;

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages) {
			$pages = 1;
		}
	}

	if(1 != $pages) {
		echo "<div class=\"pagination\">";
		// echo "<span>Page ".$paged." of ".$pages."</span>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages)  {
			echo "<a href='".get_pagenum_link(1)."'>";
			echo cw_get_icon_svg('dbl_chev_left');
			echo "</a>";
		}

		if($paged > 1 && $showitems < $pages) {
			echo "<a href='".get_pagenum_link($paged - 1)."'>";
			echo cw_get_icon_svg('chevron_left');
			echo "</a>";
		}

		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
			}
		}

		if ($paged < $pages && $showitems < $pages) {
			echo "<a href=\"".get_pagenum_link($paged + 1)."\">";
			echo cw_get_icon_svg('chevron_right');
			echo "</a>";
		}

		if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
			echo "<a href='".get_pagenum_link($pages)."'>";
			echo cw_get_icon_svg('dbl_chev_right');
			echo "</a>";
		}

		echo "</div>\n";
	}
}