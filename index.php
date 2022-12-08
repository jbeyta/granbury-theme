<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */

get_header(); ?>

	<div class="main row" role="main">
		<div class="s12 m8">
			<?php
				if(is_home()) {
					$newsid = get_option('page_for_posts');
					if(!empty($newsid)) {
						echo '<h1 class="page-title">'.get_the_title($newsid).'</h1>';
					}
				}
			?>

			<?php if ( have_posts() ) : ?>
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content', get_post_type() ); ?>
				<?php endwhile; ?>
			<?php else : ?>
				<article id="post-0" class="post no-results not-found">

				<?php if ( current_user_can( 'edit_posts' ) ) :
					// Show a different message to a logged-in user who can add posts.
				?>
					<header class="entry-header">
						<h2 class="entry-title"><?php _e( 'No posts to display', 'cw' ); ?></h2>
					</header>

					<div class="entry-content">
						<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'cw' ), admin_url( 'post-new.php' ) ); ?></p>
					</div><!-- .entry-content -->

				<?php else :
					// Show the default message to everyone else.
				?>
					<header class="entry-header">
						<h2 class="entry-title"><?php _e( 'Nothing Found', 'cw' ); ?></h2>
					</header>

					<div class="entry-content">
						<p>Nothing here yet. Check back soon!</p>
					</div><!-- .entry-content -->
				<?php endif; // end current_user_can() check ?>
				</article><!-- #post-0 -->
			<?php endif; // end have_posts() check ?>

			<nav class="prev-next-posts row">
				<div class="prev-posts-link s6 columns">
					<?php echo get_next_posts_link( 'Older Entries', $posts->max_num_pages ); // display older posts link ?>
				</div>
				<div class="next-posts-link s6 columns">
					<?php echo get_previous_posts_link( 'Newer Entries' ); // display newer posts link ?>
				</div>
			</nav>			
		</div>

		<?php get_sidebar(); ?>
	</div><!-- .content -->
<?php get_footer(); ?>