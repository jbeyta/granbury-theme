<?php
class cw_sidenav extends WP_Widget {

function __construct() {
	parent::__construct(
		// Base ID of your widget
		'cw_sidenav', 

		// Widget name will appear in UI
		__('Side Nav', 'cw_sidenav_domain'),

		// Widget description
		array( 'description' => __( 'Creates navigation for pages and their children.', 'cw_sidenav_domain' ), ) 
	);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
	global $post;
	$title = apply_filters( 'widget_title', $instance['title'] );

	// before and after widget arguments are defined by themes
	echo $args['before_widget'];
	if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];

	// This is where you run the code and display the output
	// child pages sidenav

	// we only want it running on pages, not posts
	if(is_page()) {
		// check if we're on a child page
		if($post->post_parent) {
			echo '<ul class="styleless sidenav child-page">';
				// make a nav item for the parent page
				echo '<li class="page_item page-item-'.$post->post_parent.'"><a href="'.get_the_permalink($post->post_parent).'">'.get_the_title($post->post_parent).'</a></li>';
				// list out siblings (children of this page's parent)
				wp_list_pages(array(
					'title_li' => '',
					'child_of' => $post->post_parent
				));
			echo '</ul>';
			// if we're on the parent page and then check if the page has children
		} else {
			// check for child pages so it only show on pages that actually have children
			$childs = get_pages('child_of='.$post->ID);
			if(!empty($childs)) {
				echo '<ul class="styleless sidenav parent-page">';
					// make a nav item for this page, since this only appears on the parent page, we know the parent is the current page. we can go ahead and put the current class here
					echo '<li class="page_item page-item-'.$post->ID.' current_page_item"><a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a></li>';
					// list out children of this page
					wp_list_pages(array(
						'title_li' => '',
						'child_of' => $post->ID
					));
				echo '</ul>';
			}
		}
	}


	echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
	if ( isset( $instance[ 'title' ] ) ) {
		$title = $instance[ 'title' ];
	} else {
		$title = __( '', 'cw_sidenav_domain' );
	}
// Widget admin form
?>

<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<?php }

			// Updating widget replacing old instances with new
			public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			return $instance;
		}
	} // Class cw_sidenav ends here

// Register and load the widget
function cw_sidenav_load_widget() {
	register_widget( 'cw_sidenav' );
}
add_action( 'widgets_init', 'cw_sidenav_load_widget' );