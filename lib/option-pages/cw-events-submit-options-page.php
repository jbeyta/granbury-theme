<?php
/**
 * CMB2 Theme Options
 * NOTE: The only reason this page exists is becuase Gravity Forms does not have date and time in one input.
 * @version 0.1.0
 */
class cw_events_submit_options_Admin {
	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'cw_events_submit_options_options';
	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'cw_events_submit_options_option_metabox';
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
		$this->title = __( 'Event Submission Options', 'cw_events_submit_options' );
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
		$this->options_page = add_submenu_page( 'edit.php?post_type=tribe_events', 'Event Submission Options', 'Event Submission Options', 'edit_posts', $this->key, array( $this, 'admin_page_display' ));
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
		$prefix = '_cweso_';
		
		$cmb = new_cmb2_box( array(
			'id'	  => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		global $cw_forms_list;

		// Set our CMB2 fields
		$cmb->add_field( array(
			'name' => 'Events Submission Form.',
			'desc' => '<b>NOTE:</b> If you\'re not sure about this, leave this for the developers.<br>
			Requires Gravity Forms<br><br>
			A form must be prepared to handle this. The form must include the following fields:<br>
			event start date<br>
			event start time<br>
			event end date<br>
			event end time<br>
			event title<br>
			Content and image fields are not required but highly recommended.<br><br>
			You will need to refresh this page after saving to load the fields for a newly selected form.',
			'id' => $prefix.'form_id',
			'type' => 'select',
			'options' => $cw_forms_list
		) );
		$cmb->add_field( array(
			'name' => 'Event status after submission.',
			'id' => $prefix.'event_status',
			'type' => 'select',
			'options' => array(
				'draft' => 'Draft',
				'pending' => 'Pending Review',
				'publish' => 'Published'
			)
		) );

		$form_id = cw_events_submit_options_get_option('_cweso_form_id');
		if($form_id) {

			$form = GFAPI::get_form( $form_id );

			$fields = array('' => 'Select a Field');

			$form_fields = $form['fields'];

			// echo_pre($form_fields);
			if(!empty($form_fields)) {
				foreach($form_fields as $f) {
					// echo_pre($f);
					$fields[$f->id] = $f->label;
				}
			}
			$cmb->add_field( array(
				'name' => 'Event Title Field',
				'desc' => '<b>NOTE:</b> This field should be required by the form',
				'id' => $prefix.'event_title_field',
				'type' => 'select',
				'options' => $fields
			) );

			$cmb->add_field( array(
				'name' => 'Event Start Date Field',
				'desc' => '<b>NOTE:</b> This field should be required by the form',
				'id' => $prefix.'event_start_date_field',
				'type' => 'select',
				'options' => $fields
			) );

			$cmb->add_field( array(
				'name' => 'Event Start Time Field',
				'desc' => '<b>NOTE:</b> This field should be required by the form',
				'id' => $prefix.'event_start_time_field',
				'type' => 'select',
				'options' => $fields
			) );

			$cmb->add_field( array(
				'name' => 'Event End Date Field',
				'desc' => '<b>NOTE:</b> This field should be required by the form',
				'id' => $prefix.'event_end_date_field',
				'type' => 'select',
				'options' => $fields
			) );

			$cmb->add_field( array(
				'name' => 'Event End Time Field',
				'desc' => '<b>NOTE:</b> This field should be required by the form',
				'id' => $prefix.'event_end_time_field',
				'type' => 'select',
				'options' => $fields
			) );

			$cmb->add_field( array(
				'name' => 'Content',
				'id' => $prefix.'event_content_field',
				'type' => 'select',
				'options' => $fields
			) );

			$cmb->add_field( array(
				'name' => 'Image',
				'id' => $prefix.'event_image_field',
				'type' => 'select',
				'options' => $fields
			) );		
		}
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
 * Helper function to get/return the cw_events_submit_options_Admin object
 * @since  0.1.0
 * @return cw_events_submit_options_Admin object
 */
function cw_events_submit_options_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new cw_events_submit_options_Admin();
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
function cw_events_submit_options_get_option( $key = '' ) {
	// global $cw_events_submit_options_Admin;
	// return cmb2_get_option( myprefix_admin()->key, $key );
	// $cw_events_submit_options = get_option('cw_events_submit_options_options');
	$cw_events_submit_options = get_option(cw_events_submit_options_admin()->key);
	return $cw_events_submit_options[$key];

}
// Get it started
cw_events_submit_options_admin();