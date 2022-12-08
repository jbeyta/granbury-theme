<?php
/**
 * Template Name: 2/3rds width, No Sidebar Template
 * Template Post Type: page
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>

	<div id="main-content" role="main">
		<div class="row">
			<div class="m8 m-push-2">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<?php
					while(have_posts()) {
						the_post();
						the_content();
					}
				?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>