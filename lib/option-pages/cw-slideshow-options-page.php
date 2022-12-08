<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class cw_slideshow_options_Admin {
	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'cw_slideshow_options_options';
	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'cw_slideshow_options_option_metabox';
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
		$this->title = __( 'Slideshow Options', 'cw_slideshow_options' );
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
		$this->options_page = add_submenu_page( 'edit.php?post_type=slides', 'Slideshow Options', 'Slideshow Options', 'edit_posts', $this->key, array( $this, 'admin_page_display' ));
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
		$prefix = '_cwso_';
		
		$cmb = new_cmb2_box( array(
			'id'	  => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		// Set our CMB2 fields
		$cmb->add_field( array(
			'name' => 'Slide Pause Time',
			'desc' => 'How long each slide is shown before changing. Use seconds in numbers only only. Default is 5 seconds.',
			'id' => $prefix.'pause',
			'type' => 'text',
			'attributes' => array(
				'placeholder' => '5'
			)
		) );
		$cmb->add_field( array(
			'name' => 'Slide Animation Speed',
			'desc' => 'Speed at which slides animate in and out. Use seconds in numbers and decimal points only only. Default is .5 seconds.',
			'id' => $prefix.'speed',
			'type' => 'text',
			'attributes' => array(
				'placeholder' => '.5'
			)
		) );
		$cmb->add_field( array(
			'name' => 'Slideshow Mode',
			'id' => $prefix.'mode',
			'type' => 'radio',
			'options' => array(
				'horizontal' => 'Horizontal',
				'vertical' => 'Vertical',
				'fade' => 'Fade'
			),
			'default' => 'horizontal'
		) );
		$cmb->add_field( array(
			'name' => 'Next/Previous Arrows',
			'id' => $prefix.'controls',
			'type' => 'radio',
			'options' => array(
				'true' => 'On',
				'false' => 'Off',
			)
		) );
		$cmb->add_field( array(
			'name' => 'Pager Dots',
			'id' => $prefix.'pager',
			'type' => 'radio',
			'options' => array(
				'true' => 'On',
				'false' => 'Off',
			)
		) );

		// $cmb->add_field( array(
		// 	'name' => 'Use Cropper',
		// 	'desc' => 'Manually Crop Images (beta)',
		// 	'id' => $prefix.'cropper',
		// 	'type' => 'checkbox',
		// ) );

		// if( cw_slideshow_options_get_option('_cwso_cropper') == 'on') {
		// 	$cmb->add_field( array(
		// 		'name' => 'Width',
		// 		'desc' => 'NOTE: If this value changes, you will need to re-save each slide',
		// 		'id'   => $prefix.'slide_width',
		// 		'type' => 'text'
		// 	) );

		// 	$cmb->add_field( array(
		// 		'name' => 'Height',
		// 		'desc' => 'NOTE: If this value changes, you will need to re-save each slide',
		// 		'id'   => $prefix.'slide_height',
		// 		'type' => 'text'
		// 	) );
		// }
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
 * Helper function to get/return the cw_slideshow_options_Admin object
 * @since  0.1.0
 * @return cw_slideshow_options_Admin object
 */
function cw_slideshow_options_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new cw_slideshow_options_Admin();
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
function cw_slideshow_options_get_option( $key = '' ) {
	// global $cw_slideshow_options_Admin;
	// return cmb2_get_option( myprefix_admin()->key, $key );
	// $cw_slideshow_options = get_option('cw_slideshow_options_options');
	$cw_slideshow_options = get_option(cw_slideshow_options_admin()->key);
	return $cw_slideshow_options[$key];

}
// Get it started
cw_slideshow_options_admin();