<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>

	<div id="main-content" class="single-<?php echo get_post_type(); ?>" role="main">
		<div class="row">
			<div class="s12 m8">
				<?php
					while ( have_posts() ) {
						the_post();
						get_template_part( 'template-parts/content', get_post_type() );
						// comments_template( '', true );
					}
				?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>

<?php get_footer(); ?>