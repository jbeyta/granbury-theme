<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class cw_quicklinks_Admin {
	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'cw_quicklinks_options';
	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'cw_quicklinks_option_metabox';
	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';
	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';
	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Quick Links', 'cw_quicklinks' );
	}
	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
	}
	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}
	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'update_core', $this->key, array( $this, 'admin_page_display' ), 'dashicons-index-card' );
		// add_action( "admin_head-{$this->options_page}", array( $this, 'enqueue_js' ) );
	}
	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}

    private function page_list() {
        $cw_page_list = array('' => 'Select a Page');
        
        $pages_args = array(
            'post_type' => 'page',
            'orderby' => 'title',
            'order' => 'ASC',
            'posts_per_page' => -1
        );

        $pages = new WP_Query($pages_args);

        if($pages->have_posts()) {
            global $post;
            while($pages->have_posts()) {
                $pages->the_post();
            
                $cw_page_list[$post->ID] = get_the_title();
            }
        }
        wp_reset_query();
        
        asort($cw_page_list);

        return $cw_page_list;
	}
	
	private function cw_media_list() {

		$margs = array(
			'post_type' => 'attachment',
			'post_mime_type' =>'application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'post_status' => 'inherit',
			'posts_per_page' => -1
		);

		$media = new WP_Query( $margs );

		$cw_media_list = array('' => 'Select a file');
		foreach($media->posts as $file) {
			$cw_media_list[$file->ID] = $file->post_title;
		}

		asort($cw_media_list);
		return $cw_media_list;
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {
		$prefix = 'cwo_';

		$cmb = new_cmb2_box( array(
			'id'	  => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		// echo_pre($this->metabox_id);

		// Set our CMB2 fields
		$cmb->add_field( array(
			'name' => 'Section title',
			'id' => $prefix.'title',
			'type' => 'text'
		) );

		$group_field_id = $cmb->add_field( array(
			'id'		  => $prefix.'quicklinks',
			'type'		=> 'group',
			'options'	 => array(
				'group_title'   => __( 'Quick Link {#}', 'cmb' ), // since version 1.1.4, {#} gets replaced by row number
				'add_button'	=> __( 'Add Another Link', 'cmb' ),
				'remove_button' => __( 'Remove Link', 'cmb' ),
				'sortable'	  => false, // beta
			),
		) );

		// Id's for group's fields only need to be unique for the group. Prefix is not needed.
		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Link Title',
			'desc' => 'NOTE: Page title, file name, or URL will be used if Link Title is empty. If Page URL, Page, and File are all empty, this Quick Link will not be shown',
			'id' => 'ql_title',
			'type' => 'text'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Page URL',
			'id' => 'ql_url',
			'type' => 'text_url'
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Page',
			'desc' => 'NOTE: Page selected here will override URL entered above',
			'id' => 'ql_page',
			'type' => 'select',
			'options' => $this->page_list()
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'File',
			'desc' => 'NOTE: File selected here will override selected page and URL entered above',
			'id' => 'ql_file',
			'type' => 'select',
			'options' => $this->cw_media_list()
		) );

		$cmb->add_group_field( $group_field_id, array(
			'name' => 'Description',
			'id' => 'ql_desc',
			'type' => 'textarea'
		) );
	}
	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}
		throw new Exception( 'Invalid property: ' . $field );
	}
}

/**
 * Helper function to get/return the cw_quicklinks_Admin object
 * @since  0.1.0
 * @return cw_quicklinks_Admin object
 */
function cw_quicklinks_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new cw_quicklinks_Admin();
		$object->hooks();
	}
	return $object;
}
/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed		Option value
 */
function cw_quicklinks_get_option( $key = '' ) {
	// global $cw_cpt_Admin;
	// return cmb2_get_option( myprefix_admin()->key, $key );
	$cw_cpt = get_option(cw_quicklinks_admin()->key);
	return $cw_cpt[$key];

}
// Get it started
cw_quicklinks_admin();
