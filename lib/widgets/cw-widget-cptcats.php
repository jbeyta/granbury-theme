<?php
class cw_cptcats extends WP_Widget {

function __construct() {
	parent::__construct(
		// Base ID of your widget
		'cw_cptcats', 

		// Widget name will appear in UI
		__('Custom Post Type Categories', 'cw_cptcats_domain'),

		// Widget description
		array( 'description' => __( 'Show a dropdown or list of categories for a custom post type. Works best on archives.', 'cw_cptcats_domain' ), ) 
	);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
	$display_type = $instance['display_type'];

    // prepare html for the different views
    $display = array();

    if($display_type == 'list') {
        $display['start'] = '<ul class="styleless cpt-cats-list">';
        $display['end'] = '</ul>';
        $display['child_start'] = '<li class="cpt-cats-list-item"><a href="';
        $display['child_start_b'] = '"';
        $display['child_start_c'] = '>';
        $display['child_end'] = '</a></li>';
    } else {
        $display['start'] = '<select class="cpt-cats-select">';
        $display['end'] = '</select>';
        $display['child_start'] = '<option value="';
        $display['child_start_b'] = '"';
        $display['child_start_c'] = '>';
        $display['child_end'] = '</option>';
    }

    // This is where you run the code and display the output
	$post_type = get_post_type();
	$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type) );
	foreach( $taxonomies as $taxonomy ) {

		// get category terms
        $terms = get_terms( $taxonomy );
        if(!empty($terms)) {
            // before and after widget arguments are defined by themes
            echo $args['before_widget'];
            if ( ! empty( $title ) ) {
                echo $args['before_title'] . $title . $args['after_title'];
            }

            echo  $display['start'];
                $current = '';
                if(!get_queried_object()->term_id) {
                    if($display_type == 'select') {
                        $current = ' selected';
                    } else {
                        $current = 'class="current"';
                    }
                }

                echo $display['child_start'].get_post_type_archive_link($post_type).$display['child_start_b'].$current.$display['child_start_c'].'All Categories'.$display['child_end'];

                foreach( $terms as $term ) {
                    $current = '';
                    if(get_queried_object()->term_id == $term->term_id) {
                        if($display_type == 'select') {
                            $current = ' selected';
                        } else {
                            $current = 'class="current"';
                        }
                    }

                    echo $display['child_start'].get_term_link($term->term_id).$display['child_start_b'].$current.$display['child_start_c'].$term->name.$display['child_end'];
                }

                echo $args['after_widget'];
            echo  $display['end'];
        }
    }
}
		
// Widget Backend 
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	} else {
		$title = __( '', 'cw_cptcats_domain' );
	}

	$display_type = $instance[ 'display_type' ];
	// Widget admin form
?>

<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id( 'display_type' ); ?>">Display Type</label><br>
    <select id="<?php echo $this->get_field_id( 'display_type' ); ?>" name="<?php echo $this->get_field_name( 'display_type' ); ?>" >
        <option value="list" <?php if($display_type == 'list') {echo 'selected';} ?>>List</option>
        <option value="select" <?php if($display_type == 'select') {echo 'selected';} ?>>Dropdown</option>
    </select>
</p>

<?php }

			// Updating widget replacing old instances with new
			public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['display_type'] = ( ! empty( $new_instance['display_type'] ) ) ? strip_tags( $new_instance['display_type'] ) : '';
			return $instance;
		}
	} // Class cw_sidenav ends here

// Register and load the widget
function cw_cptcats_load_widget() {
	register_widget( 'cw_cptcats' );
}
add_action( 'widgets_init', 'cw_cptcats_load_widget' );