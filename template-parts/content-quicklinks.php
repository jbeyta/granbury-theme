<?php
	$qlinks = cw_quicklinks_get_option( 'cwo_quicklinks' );

	if(!empty($qlinks)) {
		// echo_pre($qlinks);
		// $count = count($qlinks);
		echo '<ul class="quicklinks styleless">';
		foreach ($qlinks as $qlink) {
			if(!empty($qlink['ql_page']) || !empty($qlink['ql_url']) || !empty($qlink['ql_file'])) {
				echo '<li class="quicklink">';
				// echo_pre($qlink);
				if(!empty($qlink['ql_login'])) {
					echo '<a class="inner expando" href="'.wp_login_url().'">';
				} elseif(!empty($qlink['ql_url'])) {
					echo '<a class="inner expando" href="'.$qlink['ql_url'].'">';
				} elseif(!empty($qlink['ql_page'])) {
					echo '<a class="inner expando" href="'.get_the_permalink($qlink['ql_page']).'">';
				} elseif(!empty($qlink['ql_file'])) {
					$file = get_post($qlink['ql_file']);
					echo '<a class="inner expando" href="'.$file->guid.'">';
				}
			}

			$title = '';

			if(!empty($qlink['ql_title'])) {
				$title = $qlink['ql_title'];
			} elseif(!empty($qlink['ql_page'])) {
				$title = get_the_title($qlink['ql_page']);
			} elseif(!empty($qlink['ql_file'])) {
				$title = get_the_title($qlink['ql_file']);
			}

			echo '<h5 class="button-title">'.$title.'</h5>';

			if(!empty($qlink['ql_page']) || !empty($qlink['ql_url']) || !empty($qlink['ql_file'])) {
				echo '</a></li>'; // end inner
			}
		}
		echo '</ul>';
	}
?>