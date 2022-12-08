<?php
class cw_cptarchs extends WP_Widget {

function __construct() {
	parent::__construct(
		// Base ID of your widget
		'cw_cptarchs', 

		// Widget name will appear in UI
		__('Custom Post Type Archives', 'cw_cptarchs_domain'),

		// Widget description
		array( 'description' => __( 'Show a dropdown or list of date archives for a custom post type.', 'cw_cptarchs_domain' ), ) 
	);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
	$title = apply_filters( 'widget_title', $instance['title'] );
    $show_months_option = $instance['show_months'];
    $arch_type = $instance['arch_type'];
    $limit_to_type = $instance['limit_to_type'];

    $show_months = false;
    if($show_months_option == 'yes') {
        $show_months = true;
    }

    if($limit_to_type && $limit_to_type != get_post_type()) {
        return;
    }

    // This is where you run the code and display the output
    // ob_start();

    echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $cwdisplay = array();
        $cwdisplay['start'] = '<ul class="styleless cpt-archive-list">';
        $cwdisplay['end'] = '</ul>';
        $cwdisplay['child_start'] = '<li class="cpt-archive-list-item">';
        $cwdisplay['child_end'] = '</li>';

		$arch_args = array(
			'type'            => $arch_type,
			'limit'           => '',
			'format'          => 'custom', 
			'before'          => '',
			'after'           => '',
			'show_post_count' => false,
			'echo'            => false,
			'order'           => 'DESC',
			'post_type'     => get_post_type()
        );

        global $wp;

        $archs = wp_get_archives( $arch_args );
        $archs = array_filter(explode(PHP_EOL, $archs));

        if(!empty($archs)) {
            echo $cwdisplay['start'];
                foreach ($archs as $arch) {
                    $current = false;

                    if (strpos($arch, 'aria-current') !== false) {
                        $current = true;
                    }

                    echo $cwdisplay['child_start'];
                    echo $arch;
                    
                    if($show_months && $current) {
                        $child_args = array(
                            'type'            => 'monthly',
                            'limit'           => '',
                            'format'          => 'custom', 
                            'before'          => '',
                            'after'           => '',
                            'show_post_count' => false,
                            'echo'            => false,
                            'order'           => 'DESC',
                            'post_type'     => get_post_type(),
                        );

                        $child_archs = wp_get_archives( $child_args );
                        $child_archs = array_filter(explode(PHP_EOL, $child_archs));

                        if(!empty($child_archs)) {
                            echo $cwdisplay['start'];
                                foreach ($child_archs as $child_arch) {
                                    $current = false;

                                    if (strpos($child_arch, 'aria-current') !== false) {
                                        $current = true;
                                    }

                                    if (strpos($child_arch, $wp->query_vars['year']) !== false) {
                                        echo $cwdisplay['child_start'];
                                        echo $child_arch;
                                        echo $cwdisplay['child_end'];
                                    }
                                }
                            echo $cwdisplay['end'];
                        }

                    }
                    echo $cwdisplay['child_end'];
                }
            echo $cwdisplay['end'];
        }

    echo $args['after_widget'];

	// $temp = ob_get_contents();
	// ob_end_clean();

	// echo $temp;
}
		
// Widget Backend 
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	} else {
		$title = __( '', 'cw_cptarchs_domain' );
	}

    $show_months = $instance[ 'show_months' ];
    $arch_type = $instance[ 'arch_type' ];
    $limit_to_type = $instance[ 'limit_to_type' ];

    $post_types = get_post_types();
    
    $nopes = array(
        'post',
        'page',
        'attachment',
        'revision',
        'nav_menu_item',
        'custom_css',
        'customize_changeset',
        'oembed_cache',
        'user_request',
        'wp_block',
        'tribe_venue',
        'tribe_organizer',
        'tribe_events',
        'tribe-ea-record',
        'tribe',
        'deleted_event',
        'cw_post_type',
    );
    
    foreach ($post_types as $type => $type_name) {
        if(in_array($type, $nopes)) {
            unset($post_types[$type]);
        }
    }

	// Widget admin form
?>

<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id( 'show_months' ); ?>">Show Monthly Archives on Selected Years (only applies to yearly archives)</label><br>
    <select id="<?php echo $this->get_field_id( 'show_months' ); ?>" name="<?php echo $this->get_field_name( 'show_months' ); ?>" >
        <option value="yes" <?php if($show_months == 'yes') {echo 'selected';} ?>>Yes</option>
        <option value="no" <?php if($show_months == 'no') {echo 'selected';} ?>>No</option>
    </select>
</p>


<p>
    <label for="<?php echo $this->get_field_id( 'limit_to_type' ); ?>">Only show on:</label><br>
    <select id="<?php echo $this->get_field_id( 'limit_to_type' ); ?>" name="<?php echo $this->get_field_name( 'limit_to_type' ); ?>" >
        <option value="">All Post Types</option>
        <?php
            foreach ($post_types as $type) {
                $selected = '';
                if($limit_to_type == $type) {$selected = 'selected';}
                echo '<option value="'.$type.'" '.$selected.'>'.$type.'</option>';
            }
        ?>
    </select>
</p>

<p>
    <label for="<?php echo $this->get_field_id( 'arch_type' ); ?>">Archive Type</label><br>
    <select id="<?php echo $this->get_field_id( 'arch_type' ); ?>" name="<?php echo $this->get_field_name( 'arch_type' ); ?>" >
        <option value="yearly" <?php if($arch_type == 'yearly') { echo 'selected';} ?>>Yearly</option>
        <option value="monthly" <?php if($arch_type == 'monthly') { echo 'selected';} ?>>Monthly</option>
        <option value="daily" <?php if($arch_type == 'daily') { echo 'selected';} ?>>Daily</option>
    </select>
</p>

<?php }

			// Updating widget replacing old instances with new
			public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['show_months'] = ( ! empty( $new_instance['show_months'] ) ) ? strip_tags( $new_instance['show_months'] ) : '';
            $instance['arch_type'] = ( ! empty( $new_instance['arch_type'] ) ) ? strip_tags( $new_instance['arch_type'] ) : '';
            $instance['limit_to_type'] = ( ! empty( $new_instance['limit_to_type'] ) ) ? strip_tags( $new_instance['limit_to_type'] ) : '';
			return $instance;
		}
	} // Class cw_sidenav ends here

// Register and load the widget
function cw_cptarchs_load_widget() {
	register_widget( 'cw_cptarchs' );
}
add_action( 'widgets_init', 'cw_cptarchs_load_widget' );