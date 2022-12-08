<?php
/**
 * Template Name: Front-End Affiliates Directory
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header();

$current_url = get_permalink($post->ID);
$query_string = $_SERVER['QUERY_STRING'];

$upload_dir = wp_upload_dir();
if( !empty($_GET["filter"]))
	$filter_term = $_GET["filter"];
?>

	<div class="main-content affs row" role="main">
		<div class="small-12 medium-8 large-8 columns">
			<?php
				$title = get_the_title();

				echo '<h2 class="page-title">'.$title.'</h2>';

				if( isset($_GET['category']) && !empty($_GET['category']) ) {
					$nope = str_replace($_GET['category'], '', $query_string);
					echo '<p class="search-terms">'.$_GET['category'].' <a href="'.$current_url.'?'.$nope.'"><i class="fa fa-times" aria-hidden="true"></i></a></p>';
				}

				if( isset($_GET['search']) && !empty($_GET['search']) ) {
					$nope = str_replace($_GET['search'], '', $query_string);
					echo '<p class="search-terms">'.$_GET['search'].' <a href="'.$current_url.'?'.$nope.'"><i class="fa fa-times" aria-hidden="true"></i></a></p>';
				}
			?>
			<form id="aff-search" class="real-search aff flex-container-row" action="<?php echo $current_url; ?>" method="get"  style="padding-top: 15px;">
				
				<?php
					$taxonomy = 'affiliates_categories';

					$terms = get_terms($taxonomy);
					$terms_slugs_names = array();

					if(!empty($terms)) {
						echo '<select id="aff-cats" name="category">';
							echo '<option value="">All Categories</option>';
						foreach ($terms as $term) {
							$selected = '';
							if(isset($_GET['category']) && $_GET['category'] == $term->slug) {
								$selected = 'selected';
							}

							if(!isset($_GET['category']) || empty($_GET['category'])) {
								if(!isset($_GET['search']) || empty($_GET['search'])) {
									$terms_slugs_names[$term->slug] = $term->name;
								}
							}
							
							echo '<option value="'.$term->slug.'" '.$selected.'>'.$term->name.'</option>';
						}
						echo '</select>';
					}						
				?>
				
				<input type="search" placeholder="Search by Title" name="search" value="" />
				<button class="button tiny">Search</button>
			</form>

			<?php
				if (have_posts()) : while (have_posts()) : the_post();
					// the_content();
				endwhile; endif;

				$aargs = array(
					'post_type' => 'affiliates',
					'posts_per_page' => -1,
					'orderby' => 'title',
					'order' => 'ASC',
				);
				
				// global $cw_meta_queries;
				// if(!empty($cw_meta_queries)) {
				// 	$aargs['meta_query'] = $cw_meta_queries;
				// }

				if(!empty($terms_slugs_names)) {
					foreach ($terms_slugs_names as $slug => $name) {

						$aargs['tax_query'] = array(
							array(
								'taxonomy' => $taxonomy,
								'field' => 'slug',
								'terms' => $slug
							)
						);

						$affs = new WP_Query($aargs);
						if($affs->have_posts()) {
							echo '<h3 class="cat-name">'.$name.'</h3>';
							while($affs->have_posts()) {
								$affs->the_post();

								include(locate_template('content-affiliates.php'));
							}
						}

						wp_reset_query();
					}
				} else {
					// check for what to include in query
					if( isset($_GET['category']) && !empty($_GET['category']) ) {
						$aargs['tax_query'] = array(
							array(
								'taxonomy' => $taxonomy,
								'field' => 'slug',
								'terms' => $_GET['category']
							)
						);
					}

					if( isset($_GET['search']) && !empty($_GET['search']) ) {
						$aargs['s'] = $_GET['search'];
					}

					$affs = new WP_Query($aargs);
					if($affs->have_posts()) {
						while($affs->have_posts()) {
							$affs->the_post();

							include(locate_template('content-affiliates.php'));
						}
					} else {
						if(!empty($_GET['search'])) {
							echo '<p>No results for: '.$_GET['search'].'</p>';
						} else {
							echo '<p>Please enter a search term or select a category</p>';
						}
					}

					wp_reset_query();
				}
			?>
		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
