<?php
class cw_shortcode extends WP_Widget {

function __construct() {
	parent::__construct(
		// Base ID of your widget
		'cw_shortcode', 

		// Widget name will appear in UI
		__('Shortcode', 'cw_shortcode_domain'),

		// Widget description
		array( 'description' => __( 'Use Shortcode', 'cw_shortcode_domain' ), ) 
	);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
	$shortcode = $instance['shortcode'];

	// before and after widget arguments are defined by themes
	echo $args['before_widget'];

	// This is where you run the code and display the output
	if(!empty($shortcode)) {
		echo do_shortcode($shortcode);
	}

	echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {

	if ( isset( $instance[ 'shortcode' ] ) ) {
		$shortcode = $instance[ 'shortcode' ];
	} else {
		$shortcode = '';
	}

	// Widget admin form
?>

<p>
<label for="<?php echo $this->get_field_id( 'shortcode' ); ?>"><?php _e( 'Enter Shortcode:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'shortcode' ); ?>" name="<?php echo $this->get_field_name( 'shortcode' ); ?>" type="text" value="<?php echo esc_attr( $shortcode ); ?>" />
</p>

<?php }

			// Updating widget replacing old instances with new
			public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['shortcode'] = ( ! empty( $new_instance['shortcode'] ) ) ? strip_tags( $new_instance['shortcode'] ) : '';
			return $instance;
		}
	} // Class cw_sidenav ends here

// Register and load the widget
function cw_shortcode_load_widget() {
	register_widget( 'cw_shortcode' );
}
add_action( 'widgets_init', 'cw_shortcode_load_widget' );