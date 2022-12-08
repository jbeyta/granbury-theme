<?php
class cw_links extends WP_Widget {

function __construct() {
	parent::__construct(
		// Base ID of your widget
		'cw_links', 

		// Widget name will appear in UI
		__('Links', 'cw_links_domain'),

		// Widget description
		array( 'description' => __( 'Create a Link or Button.', 'cw_links_domain' ), ) 
	);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$select_page = $instance['select_page'];
	$ext_url = $instance['ext_url'];
	$make_button = $instance['make_button'];

	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) ) {
		echo $args['before_title'] . $title . $args['after_title'];
	}

	$class = '';
	if($make_button == 'on') {
		$class = 'button';
	}

	// This is where you run the code and display the output
	if(!empty($select_page)) {
		echo '<a class="'.$class.'" href="'.get_the_permalink($select_page).'">'.get_the_title($select_page).'</a>';
	} elseif(!empty($ext_url)) {
		echo '<a class="'.$class.'" href="'.$ext_url.'">'.$ext_url.'</a>';
	}

	echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	} else {
		$title = __( '', 'cw_links_domain' );
	}

	if ( isset( $instance[ 'select_page' ] ) ) {
		$select_page = $instance[ 'select_page' ];
	} else {
		$select_page = '';
	}

	if ( isset( $instance[ 'ext_url' ] ) ) {
		$ext_url = $instance[ 'ext_url' ];
	} else {
		$ext_url = '';
	}

	if (!empty($instance['make_button'])) {
		$make_button = 'checked';
	} else {
		$make_button = '';
	}

	global $cw_page_list;
	// Widget admin form
?>

<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
<br><br>
<b>NOTE: Page link will override external link</b><br>
<select id="<?php echo $this->get_field_id( 'select_page' ); ?>" name="<?php echo $this->get_field_name( 'select_page' ); ?>" >
<?php
	if(!empty($cw_page_list)) {
		foreach ($cw_page_list as $id => $page) {
			$selected = '';
			if($select_page == $id) {
				$selected = 'selected';
			}
			echo'<option value="'.$id.'" '.$selected.'>'.$page.'</option>';
		}
	}
?>
</select>
<br><br>

<label for="<?php echo $this->get_field_id( 'ext_url' ); ?>">External URL</label><br>
<input class="widefat" id="<?php echo $this->get_field_id( 'ext_url' ); ?>" name="<?php echo $this->get_field_name( 'ext_url' ); ?>" type="url" value="<?php echo esc_attr( $ext_url ); ?>" />
<br><br>
<label for="<?php echo $this->get_field_id( 'make_button' ); ?>">Make Link a Button</label>&nbsp;
<input class="widefat" id="<?php echo $this->get_field_id( 'make_button' ); ?>" name="<?php echo $this->get_field_name( 'make_button' ); ?>" type="checkbox" value="on" <?php echo $make_button; ?>/>
</p>

<?php }

			// Updating widget replacing old instances with new
			public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['select_page'] = ( ! empty( $new_instance['select_page'] ) ) ? strip_tags( $new_instance['select_page'] ) : '';
			$instance['ext_url'] = ( ! empty( $new_instance['ext_url'] ) ) ? strip_tags( $new_instance['ext_url'] ) : '';
			$instance['make_button'] = ( ! empty( $new_instance['make_button'] ) ) ? strip_tags( $new_instance['make_button'] ) : '';
			return $instance;
		}
	} // Class cw_sidenav ends here

// Register and load the widget
function cw_links_load_widget() {
	register_widget( 'cw_links' );
}
add_action( 'widgets_init', 'cw_links_load_widget' );