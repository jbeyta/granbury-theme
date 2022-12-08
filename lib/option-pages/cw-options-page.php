<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class cw_options_Admin {
	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'cw_options_options';
	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'cw_options_option_metabox';
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
		$this->title = __( 'Site Options', 'cw_options' );
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
		$this->options_page = add_menu_page( $this->title, $this->title, 'edit_posts', $this->key, array( $this, 'admin_page_display' ), 'dashicons-forms' );
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
	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {
		$prefix = '_cwo_';
		
		$cmb = new_cmb2_box( array(
			'id'	  => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );


		global $cw_states;

		// Set our CMB2 fields
		$cmb->add_field( array(
			'name' => 'Site Logo',
			'id' => $prefix.'logo',
			'type' => 'file',
			'query_args' => array(
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			)
		) );
		$cmb->add_field( array(
			'name' => 'Site Logo (svg)',
			'id' => $prefix.'logo_svg',
			'type' => 'textarea_code',
		) );
		$cmb->add_field( array(
			'name' => 'Google Analytics Code',
			'id' => $prefix.'ga',
			'type' => 'text',
		) );
		$cmb->add_field( array(
			'name' => 'Facebook Tracking Code',
			'id' => $prefix.'tracking_code',
			'type' => 'textarea_code',
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
 * Helper function to get/return the cw_options_Admin object
 * @since  0.1.0
 * @return cw_options_Admin object
 */
function cw_options_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new cw_options_Admin();
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
function cw_options_get_option( $key = '' ) {
	// global $cw_options_Admin;
	// return cmb2_get_option( myprefix_admin()->key, $key );
	// $cw_options = get_option('cw_options_options');
	$cw_options = get_option(cw_options_admin()->key);
	return $cw_options[$key];

}
// Get it started
cw_options_admin();