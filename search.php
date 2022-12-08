<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
<div role="main">
	<div class="search main-content row">
		<div class="s12 m8">
			<?php

				if ( have_posts() && strlen( trim(get_search_query()) ) != 0) {
					echo '<h1 class="page-title">Results for: &ldquo;'.get_search_query().'&rdquo;</h1>';

					while ( have_posts() ) {
						the_post();
						get_template_part( 'template-parts/content', 'search' );
					}
				} elseif(have_posts() && strlen( trim(get_search_query()) ) == 0) {
					echo '<h1 class="page-title">Oops! Nothing was put into the search field.</h1>';
				} else {
					echo '<h1 class="page-title">Nothing found for: &ldquo;'.get_search_query().'&rdquo;</h1>';
				}		
			?>
		</div>

		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer();