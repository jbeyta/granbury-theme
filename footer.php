<?php
/**
 * @package WordPress
 * @subpackage CW
 * @since CW 1.0
 */
?>
	<footer role="contentinfo">
		<div class="row">
			<div class="s12 copy">
				<?php echo do_shortcode('[contact_info social="show_all"]'); ?>
				<p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>, All Rights Reserved.</p>
			</div>
		</div>
	</footer>

	<div class="back-to-top">
		<?php echo cw_get_icon_svg('totop'); ?>
	</div>

	<!-- WP_FOOTER() -->
	<?php wp_footer(); ?>
</body>
</html>