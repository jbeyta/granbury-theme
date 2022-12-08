<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>
	<div id="main-content" class="single-gallery" role="main">
		<div class="row">
			<div class="s12 m8">
				<?php echo '<h1 class="page-title">'.get_the_title().'</h1>'; ?>
				<?php
					while (have_posts()) {
						the_post();
						get_template_part('template-parts/content', 'single-gallery');
					}
				?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>

<?php get_footer(); ?>
