<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>

	<div id="main-content" class="archive-page" role="main">
		<div class="row">
			<div class="s12">
				<?php if ( have_posts() ) : ?>
					<h1 class="page-title archive-title">
						<?php
							if ( is_day() ) :
								printf( __( 'Daily Archives: %s', 'cw' ), '<span>' . get_the_date() . '</span>' );
							elseif ( is_month() ) :
								printf( __( 'Monthly Archives: %s', 'cw' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'cw' ) ) . '</span>' );
							elseif ( is_year() ) :
							printf( __( 'Yearly Archives: %s', 'cw' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'cw' ) ) . '</span>' );
							else :
								if(get_queried_object()->label) {
									echo get_queried_object()->label;
								}

								if(get_queried_object()->taxonomy) {
									$tax_name = unslug(get_queried_object()->taxonomy);
									echo $tax_name.' - '.get_queried_object()->name;
								}
							endif;
						?>
					</h1>

					<?php
						if(get_queried_object()->label == 'Affiliates' || get_queried_object()->taxonomy == 'affiliates_categories') {
							$tax = 'affiliates_categories';
							$terms = get_terms($tax);
							if($terms) {
								echo '<div class="controls" style="margin-bottom: 30px;">';
									echo '<select id="aff-cats">';
										echo '<option value="'.get_bloginfo('url').'/affiliates">All Categories</option>';
										foreach ($terms as $key => $term) {
											$selected = '';
											if(get_queried_object()->name == $term->name) {
												$selected = 'selected';
											}
											echo '<option value="'.get_bloginfo('url').'/affiliates-category/'.$term->slug.'" '.$selected.'>'.$term->name.'</option>';
										}
									echo '</select>';
								echo '</div>';
							}
						}
					?>

					<?php /* Start the Loop */
						// use line below to change sort order
						$posts = query_posts($query_string .'&orderby=title&order=asc&posts_per_page=-1'); 
						echo '<div class="'.get_post_type().'-mother">';
							while ( have_posts() ) : the_post();
								get_template_part( 'template-parts/content', get_post_type() );
							endwhile;
						echo '</div>';

						if (function_exists('pagination')) {
							pagination($posts->max_num_pages);
						}
					?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>