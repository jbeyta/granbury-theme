<?php
/**
 * Template Name: NTREIS Affiliates Directory
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
get_header();

$upload_dir = wp_upload_dir();
if( !empty($_GET["filter"]))
	$filter_term = $_GET["filter"];
?>


	<div class="main-content affs row">
		<div class="small-12 medium-8 large-8 columns">
			<form style="text-align: right;" action="" method="get">

				<input type="search" placeholder="Search Affiliates" style="    height: 35px;margin-top:1px;width: 50%;display: inline-block" name="filter" value="<?php echo $filter_term; ?>" />
				<button class="button tiny" style="    height: 35px;padding: 12px 20px; display: inline-block;">Search</button>
			</form>

			<?php if (have_posts()) : while (have_posts()) : the_post();
				the_content();
			endwhile; endif; ?>
			<hr>

			<?php
				$limit = 400;
				$offset = 0;
				$search_params = array();

				$affiliates = get_affiliates( $search_params, $limit, $offset);

				// echo '<pre>';
				// print_r($affs);
				// echo '</pre>';
				$last_category = "";
				$found_count = 0;
				foreach($affiliates as $affiliate) {
				 // echo '<pre>';
				 // print_r($affiliate);
				 // echo '</pre>';
					$filter_term = strtolower(trim($filter_term));
					if(
						trim(strtolower($affiliate["organization_name"])) != "vendor"
						&&
						(
							empty($filter_term)
								||
							strpos(strtolower($affiliate["organization_name"]), $filter_term ) > -1
						)
					) {
						$found_count++;
						foreach($affiliate as $key => &$value) {
							if( is_string($value) )
								$value = implode('-', array_map('ucfirst', explode('-', ucwords(strtolower(trim($value))) )) );

						}

						if($last_category != $affiliate["affiliate_category"]) {
							print "<h3>" . $affiliate["affiliate_category"] . "</h3>\n";
							$last_category = $affiliate["affiliate_category"];
						}
				?>

				<div class="aff-listing">
					<figure class="aff-logo">
						<?php
			//echo $upload_dir['basedir']  . "/offices/" . $affiliate["office_id"] . ".jpg";
			if(file_exists( $upload_dir['basedir'] . "/offices/" . $affiliate["office_id"] . ".jpg") ) {
				print "<img style=\"float:right;max-width: 200px;\" src=\"" . $upload_dir['baseurl'] . "/offices/" . $affiliate["office_id"] . ".jpg\">\n";
			}
						?>

					</figure>

					<div class="aff-info">

						<h6 class="aff-title"><?php echo $affiliate["organization_name"]; ?></h6>
	<?php
	if(!empty($affiliate["affiliate_category"])) {
			print "<div style=\"margin:-10px 0 10px 0;font-size: 12px; font-weight: 500;\">" . $affiliate["affiliate_category"] . "</div>";
	} ?>


						<p>
							<?php echo $affiliate["address_street"]; ?><br>
							<?php echo $affiliate["city"]; ?>, <?php echo $affiliate["state"]; ?> <?php echo $affiliate["zip"]; ?>
						</p>
	<?php
		if(empty($affiliate["phone_1_desc"]))
			$affiliate["phone_1_desc"] = "Office";
		if(empty($affiliate["phone_2_desc"]))
			$affiliate["phone_2_desc"] = "Fax";
		if(empty($affiliate["phone_3_desc"]))
			$affiliate["phone_3_desc"] = "Other";

			if(!empty($affiliate["phone_1_number"]))
				print "<p><b>" . $affiliate["phone_1_desc"] . ": </b>" .  $affiliate["phone_1_number"] . "</p>\n";
			if(!empty($affiliate["phone_2_number"]))
				print "<p><b>" . $affiliate["phone_2_desc"] . ": </b>" .  $affiliate["phone_2_number"] . "</p>\n";
			if(!empty($affiliate["phone_3_number"]))
				print "<p><b>" . $affiliate["phone_3_desc"] . ": </b>" .  $affiliate["phone_3_number"] . "</p>\n";
			if(!empty($affiliate["email"]))
				print "<p><b>Email: </b><a href=\"mailto://" . strtolower($affiliate["email"]) . "\">" . strtolower($affiliate["email"]) . "</a></p>\n";
			if(!empty($affiliate["website"]))
				print "<p><b>Web: </b><a href=\"http://" . strtolower($affiliate["website"]) . "\">" . strtolower($affiliate["website"]) . "</a></p>\n";

	?>
					</div>
				</div>
				<?php
					} // if...
				} // foreach($affiliates as $affiliate) {


				if( $found_count == 0)
					print "There are no affiliates with your search query";
			?>
		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>
