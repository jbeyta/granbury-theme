<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class cw_contact_Admin {
	private function get_gforms() {
		if(!function_exists('is_plugin_active')) {
			return;
		}
		if ( is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
			$form_list = array('' => 'Select a Form');

			$gforms = RGFormsModel::get_forms( null, 'title' );
			if(!empty($gforms)) {
				foreach ($gforms as $key => $form) {
					$form_list[$form->id] = $form->title;
				}
			}

			return $form_list;
		} else {
			return null;
		}
	}

	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'cw_contact_options';
	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'cw_contact_option_metabox';
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
		$this->title = __( 'Contact Info', 'cw_contact' );
	}
	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
		// add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
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
		$this->options_page = add_menu_page( $this->title, $this->title, 'edit_posts', $this->key, array( $this, 'admin_page_display' ), 'dashicons-phone' );
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
			<hr>
			<h3>Shortcode:</h3>
			<p>[contact_info]</p>

			<h4 class="sc-options-title button">Shortcode Options</h4>
			<p class="sc-options">
				<b>NOTE: Address is shown by default. To hide address use:</b>
				<br>[contact_info address="hide"]
				<br>
				<b>style: display the address in one line rather than paragraph form. Applies only to the address.</b>
				<br>[contact_info style="inline"]
				<br>
				<br>
				<b>title: add a custom title to the address</b>
				<br>[contact_info title="Our Organization"]
				<br>
				<br>
				<b>phone: show phone numbers:</b>
				<br>[contact_info phone1="show"] - will show phone number 1
				<br>[contact_info phone2="show"] - will show phone number 2
				<br>
				<br>
				<b>fax: show phone numbers:</b>
				<br>[contact_info fax="show"] - will show fax number
				<br>
				<br>
				<b>email: show email address:</b>
				<br>[contact_info email="show"]
				<br>
				<br>
				<b>hours: show hours</b>
				<br>[contact_info hours="show"]
				<br>
				<br>
				<b>social: Social Links are not shown by default. To show them:</b>
				<br>[contact_info social="facebook"] - show the facebook link (same for other social links, youtube, linkedin, etc.)
				<br>
				<br>
				<b>icon: Icons are not shown by default. To show them:</b>
				<br>[contact_info icon=true] - shows preselected icons for phones numbers, fax number, email and hours
				<br>
				<br>
				<b>show_all: Show everything</b>
				<br>[contact_info show_all=true]
				<br>
				<br>
			</p>
			<hr>
			<script>
				jQuery('.sc-options-title').css({
					'cursor': 'pointer',
					'color': 'blue'
				});

				jQuery('.sc-options').hide();

				jQuery('.sc-options-title').click(function(){
					console.log('click');
					jQuery('.sc-options').slideToggle();
				});
			</script>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}
	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {
		$prefix = '_cwc_';
		
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
		// $cmb->add_field( array(
		// 	'name' => 'Contact Form (used on home page)',
		// 	'id' => $prefix.'contact_gform',
		// 	'type' => 'select',
		// 	'options' => $this->get_gforms()
		// ) );
		
		$cmb->add_field( array(
			'name' => 'Address',
			'id' => $prefix.'address1',
			'type' => 'text',
		) );
		$cmb->add_field( array(
			'name' => 'Address 2',
			'id' => $prefix.'address2',
			'type' => 'text',
		) );
		$cmb->add_field( array(
			'name' => 'City',
			'id' => $prefix.'city',
			'type' => 'text',
		) );
		$cmb->add_field( array(
			'name' => 'State',
			'id' => $prefix.'state',
			'type' => 'select',
			'options' => $cw_states,
		) );
		$cmb->add_field( array(
			'name' => 'Zip',
			'id' => $prefix.'zip',
			'type' => 'text',
		) );
		$cmb->add_field( array(
			'name' => 'Phone',
			'id' => $prefix.'phone',
			'type' => 'text',
		) );
		$cmb->add_field( array(
			'name' => 'Phone 2',
			'id' => $prefix.'phone2',
			'type' => 'text',
		) );
		$cmb->add_field( array(
			'name' => 'Fax',
			'id' => $prefix.'fax',
			'type' => 'text',
		) );
		$cmb->add_field( array(
			'name' => 'Email',
			'id' => $prefix.'email',
			'type' => 'text',
		) );
////////////////////////////////////// Hours //////////////////////////////////////

		$cmb->add_field( array(
			'name' => 'Hours',
			'id' => $prefix.'hours',
			'type' => 'textarea',
		) );

		// $cmb->add_field( array(
		// 	'name' => 'Monday Open',
		// 	'id' => $prefix.'mon_open',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Monday Close',
		// 	'id' => $prefix.'mon_close',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );

		// $cmb->add_field( array(
		// 	'name' => 'Tuesday Open',
		// 	'id' => $prefix.'tue_open',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Tuesday Close',
		// 	'id' => $prefix.'tue_close',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );

		// $cmb->add_field( array(
		// 	'name' => 'Wednesday Open',
		// 	'id' => $prefix.'wed_open',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Wednesday Close',
		// 	'id' => $prefix.'wed_close',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );

		// $cmb->add_field( array(
		// 	'name' => 'Thursday Open',
		// 	'id' => $prefix.'thu_open',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Thursday Close',
		// 	'id' => $prefix.'thu_close',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );

		// $cmb->add_field( array(
		// 	'name' => 'Friday Open',
		// 	'id' => $prefix.'fri_open',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Friday Close',
		// 	'id' => $prefix.'fri_close',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );

		// $cmb->add_field( array(
		// 	'name' => 'Saturday Open',
		// 	'id' => $prefix.'sat_open',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Saturday Close',
		// 	'id' => $prefix.'sat_close',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );

		// $cmb->add_field( array(
		// 	'name' => 'Sunday Open',
		// 	'id' => $prefix.'sun_open',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Sunday Close',
		// 	'id' => $prefix.'sun_close',
		// 	'type' => 'text_time',
		// 	'time_format' => 'g:i a',
		// ) );

////////////////////////////////////// end Hours //////////////////////////////////////
		$cmb->add_field( array(
			'name' => 'Facebook',
			'id' => $prefix.'facebook',
			'type' => 'text_url',
		) );
		$cmb->add_field( array(
			'name' => 'Twitter',
			'id' => $prefix.'twitter',
			'type' => 'text_url',
		) );
		$cmb->add_field( array(
			'name' => 'Youtube',
			'id' => $prefix.'youtube',
			'type' => 'text_url',
		) );
		$cmb->add_field( array(
			'name' => 'Linked In',
			'id' => $prefix.'linked',
			'type' => 'text_url',
		) );
		$cmb->add_field( array(
			'name' => 'Pinterest',
			'id' => $prefix.'pinterest',
			'type' => 'text_url',
		) );
		$cmb->add_field( array(
			'name' => 'Instagram',
			'id' => $prefix.'instagram',
			'type' => 'text_url',
		) );

		// map options
		// $cmb->add_field( array(
		// 	'name' => 'Latitude',
		// 	'id' => $prefix.'lat',
		// 	'type' => 'text',
		// 	'before_row' => '<hr><h3>Map Options</h3><div style="background-color: rgba(0, 0, 0, .125); padding: 15px;"><p>Use if map gives wrong location</p>'
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Longitude',
		// 	'id' => $prefix.'lon',
		// 	'type' => 'text',
		// 	'after_row' => '</div>'
		// ) );


		// $cmb->add_field( array(
		// 	'name' => 'Hide Controls',
		// 	'desc' => 'Hide Controls on Map',
		// 	'id' => $prefix.'hide_controls',
		// 	'type' => 'checkbox'
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Allow Scroll Zoom',
		// 	'desc' => 'Allow Scroll Zoom on Map',
		// 	'id' => $prefix.'allow_scroll_zoom',
		// 	'type' => 'checkbox',
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Zoom Level',
		// 	'id' => $prefix.'zoom_level',
		// 	'type' => 'select',
		// 	'options' => array(
		// 		'1' => '1',
		// 		'2' => '2',
		// 		'3' => '3',
		// 		'4' => '4',
		// 		'5' => '5',
		// 		'6' => '6',
		// 		'7' => '7',
		// 		'8' => '8',
		// 		'9' => '9',
		// 		'10' => '10',
		// 		'11' => '11',
		// 		'12' => '12',
		// 		'13' => '13',
		// 		'14' => '14',
		// 		'15' => '15',
		// 		'16' => '16',
		// 		'17' => '17',
		// 		'18' => '18',
		// 		'19' => '19',
		// 	)
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Saturation',
		// 	'desc' => '0 = grayscale, 100 = normal, 200 = oversaturated',
		// 	'id' => $prefix . 'saturation',
		// 	'type' => 'own_slider',
		// 	'min' => '0',
		// 	'max' => '200',
		// 	'default' => '100', // start value
		// 	'value_label' => 'Amount:',
		// ));

		// $cmb->add_field( array(
		// 	'name' => 'Use simplified graphics (removes road outlines and some style features)',
		// 	'desc' => 'Simplified',
		// 	'id' => $prefix.'simplified',
		// 	'type' => 'checkbox',
		// ) );
		// $cmb->add_field( array(
		// 	'name' => 'Hue',
		// 	'id' => $prefix.'hue_hex',
		// 	'type' => 'colorpicker',
		// ) );
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
 * Helper function to get/return the cw_contact_Admin object
 * @since  0.1.0
 * @return cw_contact_Admin object
 */
function cw_contact_admin() {
	static $object = null;
	if ( is_null( $object ) ) {
		$object = new cw_contact_Admin();
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
function cw_contact_get_option( $key = '' ) {
	// global $cw_contact_Admin;
	// return cmb2_get_option( myprefix_admin()->key, $key );
	// $cw_contact = get_option('cw_contact_options');
	$cw_contact = get_option(cw_contact_admin()->key);
	return $cw_contact[$key];

}
// Get it started
cw_contact_admin();