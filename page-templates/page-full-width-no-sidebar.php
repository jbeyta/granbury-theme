<?php
/**
 * Template Name: Full Width, No Sidebar Template
 * Template Post Type: page
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>

	<div id="main-content" role="main">
		<div class="row">
			<div class="s12">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<?php
					if(have_posts()) {
						while(have_posts()) {
							the_post();
							the_content();
						}
					}
				?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>