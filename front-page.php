<?php
/**
 * Template Name: Home Page Template
 * Template Post Type: page
 * Description: Custom home page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>
	
	<div id="main-content" role="main">
		<div class="row">
			<div class="s12">
				<?php
					// $tev_args = array(
					// 	'posts_per_page' => 5,
					// 	'start_date' => 'now',
					// 	'post_parent' => 0,
					// );
					
					// $events = tribe_get_events($tev_args);
					// if (!empty($events)) {
					// 	foreach ($events as $key => $event) {
					// 	}
					// }
				
					// while(have_posts()) {
					// 	the_post();
						
					// 	echo '<h2 class="event-title">'.get_the_title().'</h2>';
					// 	the_content();
					// }
				?>

				<h1 class="visually-hidden"><?php the_title(); ?></h1>
				
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