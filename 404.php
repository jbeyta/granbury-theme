<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>

	<div class="main row" role="main">
		<div class="s10 s-push-1 content-not-found">
			<h1 class="page-title">Not Found: 404</h1>
			<p>Content not found. Please make sure the url is correct or search for what you're looking for below.</p>
			<?php get_search_form(); ?>
		</div>
	</div>

<?php get_footer(); ?>