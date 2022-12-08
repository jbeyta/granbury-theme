<?php
/**
 * Template Name: Sidebar Template
 * Template Post Type: page
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>

	<div id="main-content" role="main">
		<div class="row">
			<div class="s12 m8">
				<?php
					while(have_posts()) {
						the_post();
						echo '<h1 class="page-title">'.get_the_title().'</h1>';
						the_content();
						// comments_template( '', true );
					}
				?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>

<?php get_footer(); ?>