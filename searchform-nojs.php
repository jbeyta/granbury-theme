<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
?>

	<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
		<div class="row">
			<div class="s9 input-text-cont">
				<input type="text" value="" name="s" placeholder="Search" id="s">
			</div>

			<div class="s3 input-submit-cont">
				<input type="submit" id="searchsubmit" value="Go" class="button">
			</div>
		</div>
	</form>