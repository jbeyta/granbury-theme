<?php
/**
 * The template for displaying Current Discussion on posts
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

/* Get data from current discussion on post. */
$discussion    = cw_get_discussion_data();
$has_responses = $discussion->responses > 0;

if ( $has_responses ) {
	/* translators: %1(X comments)$s */
	$meta_label = sprintf( _n( '%d Comment', '%d Comments', $discussion->responses, 'cw' ), $discussion->responses );
} else {
	$meta_label = __( 'No comments', 'cw' );
}
?>

<div class="discussion-meta">
	<?php
	if ( $has_responses ) {
		cw_discussion_avatars_list( $discussion->authors );
	}
	?>
	<p class="discussion-meta-info">
		<span><?php echo esc_html( $meta_label ); ?></span>
	</p>
</div><!-- .discussion-meta -->
