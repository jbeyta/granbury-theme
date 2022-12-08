<?php
/**
 * Template Name: Affiliates Template
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header(); ?>


	<div class="main-content affs row">
		<div class="small-12 medium-8 large-8 columns">
			<?php if (have_posts()) : while (have_posts()) : the_post();
				the_content();
			endwhile; endif; ?>
			<hr>

			<?php
				$limit = 5;
				$offset = 0;
				$search_params = array();

				$affs = get_abilene_affiliates( $search_params, $limit, $offset);

				// echo '<pre>';
				// print_r($affs);
				// echo '</pre>';
			?>

			<div class="aff-listing">
				<figure class="aff-logo">
					<?php
						$logo_url = 'http://wfar.dev/wp-content/uploads/2014/06/tree-family.jpg';
						$sized_logo = aq_resize( $logo_url, 480, false, true, true );
					?>
					<img src="<?php echo $sized_logo; ?>" alt="" />
				</figure>

				<div class="aff-info">
					<h6 class="aff-title">Archer County Appraisal District</h6>
					<p>
						101 S CENTER<br>
						ARCHER CITY, TX 763511141
					</p>
					<p><b>Office: </b>9405742172</p>
					<p><b>Fax: </b>9405742509</p>
				</div>
			</div>

		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
