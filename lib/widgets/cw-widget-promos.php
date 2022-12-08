<?php
class cw_promos extends WP_Widget {

function __construct() {
	parent::__construct(
		// Base ID of your widget
		'cw_promos', 

		// Widget name will appear in UI
		__('Promos', 'cw_promos_domain'),

		// Widget description
		array( 'description' => __( 'Display a Promo assigned to a Location', 'cw_promos_domain' ), ) 
	);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
	$position = $instance['position'];

	// before and after widget arguments are defined by themes
	echo $args['before_widget'];

	// This is where you run the code and display the output
	cw_get_promo($position);

	echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
	if ( isset( $instance[ 'position' ] ) ) {
		$position = $instance[ 'position' ];
	} else {
		$position = '';
	}

	// Widget admin form
?>

<p>
	<select id="<?php echo $this->get_field_id( 'position' ); ?>" name="<?php echo $this->get_field_name( 'position' ); ?>" >
		<option value="">Select a Position</option>
		<?php
			$terms = get_terms('promos_categories');
			if(!empty($terms)) {
				foreach ($terms as $term) {
					$selected = '';
					if($position == $term->term_id) {
						$selected = 'selected';
					}
					echo'<option value="'.$term->term_id.'" '.$selected.'>'.$term->name.'</option>';
				}
			}
		?>
	</select>
</p>

<?php }

			// Updating widget replacing old instances with new
			public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['position'] = ( ! empty( $new_instance['position'] ) ) ? strip_tags( $new_instance['position'] ) : '';
			return $instance;
		}
	} // Class cw_sidenav ends here

// Register and load the widget
function cw_promos_load_widget() {
	register_widget( 'cw_promos' );
}
add_action( 'widgets_init', 'cw_promos_load_widget' );