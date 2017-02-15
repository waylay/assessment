<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://webcodesigner.com
 * @since      1.0.0
 *
 * @package    Find_Franchises_By_Zip
 * @subpackage Find_Franchises_By_Zip/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Find_Franchises_By_Zip
 * @subpackage Find_Franchises_By_Zip/admin
 * @author     Cristian Ionel <cristian.ionel@gmail.com>
 */
class Find_Franchises_By_Zip_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Find_Franchises_By_Zip_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Find_Franchises_By_Zip_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/find-franchises-by-zip-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Find_Franchises_By_Zip_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Find_Franchises_By_Zip_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/find-franchises-by-zip-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Register and add settings
	 */
	public function add_plugin_settings() {


		// Settings section for both CSV file types (Customer Price List and List Prices)
		add_settings_section(
				'franchise_map_settings_section', // ID
				'Upload your CSV files', // Title
				 null, // Callback
				'franchise_map' // Page
		);


		// Customer Price List file
		add_settings_field(
				'franchise_locations',
				'Upload Franchise Locations File',
				array( $this, 'input_franchise_locations_file_upload' ),
				'franchise_map',
				'franchise_map_settings_section'
		);

		// List Prices file
		add_settings_field(
				'zip_to_county_codes',
				'Upload ZIP to County Code',
				array( $this, 'input_zip_to_county_codes_file_upload' ),
				'franchise_map',
				'franchise_map_settings_section'
		);

	}

	/**
	 * Add the control page
	 */
	public function add_plugin_settings_page() {
		add_menu_page(
			'Franchise Map',
			'Franchise Map',
			'manage_options',
			'franchise_map',
			array( $this, 'plugin_settings_page_html' )

		);
	}

	public function plugin_settings_page_html()
	{
		$this->handle_franchise_locations_file_upload();
		$this->handle_zip_to_county_codes_file_upload();

		?>
		<div class="wrap">

		    <h2>Franchise Map - Upload your CSV files</h2>

		    <hr>
		    <form name="franchise_csv_upload" method="post" action="" enctype="multipart/form-data">
			    <?php
			        do_settings_sections( 'franchise_map' );
			        wp_nonce_field( 'franchise_map_form' );
			        submit_button('Update the Franchise Map');
							// File upload errors
	            settings_errors();
			    ?>

		    </form>


		</div>
		<?php
	}



	// Customer Price List file input
	public function input_franchise_locations_file_upload()	{
		?>
			<input type="file" name="franchise_locations" />
		<?php
	}

	// List Prices file input
	public function input_zip_to_county_codes_file_upload()	{
		?>
			<input type="file" name="zip_to_county_codes" />
		<?php
	}

	private function handle_franchise_locations_file_upload()	{

	  	if( !empty($_FILES["franchise_locations"]["tmp_name"]) ){

		  	if( !check_admin_referer( 'franchise_map_form') ) {
		  		die('Security Check!');
		  	}

				// TODO Check file type

		  	$urls = wp_handle_upload($_FILES["franchise_locations"], array('test_form' => FALSE));
		    $movefile = $urls['url'];


		    //Import uploaded file to Database
		    global $wpdb;
		    $entries = 0;
				$output = '';
	      $handle = fopen($movefile, "r");
				$table_name = $wpdb->prefix.'franchise_locations';
		    while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {

			    // Skip the first row
			    if ($entries === 0) {
			    	$entries++;
			      continue;
			    }

			    if ( count($data) == 6  ) {

				    $update_row = array(
		    			'franchise_id' => $data[0],
		    			'franchise_name' => $data[1],
		    			'phone' => $data[2],
		    			'website' => $data[3],
		    			'email' => $data[4],
		    			'county_codes' => $data[5]
	    			);

				    $update = $wpdb->replace($table_name,
				    	$update_row,
							array(
				        '%d',
								'%s',
								'%s',
								'%s',
								'%s',
								'%s',
							)
			    	);
						if($update){
			    		$entries++;
						}
		    	} // endif

			} //endwhile

			// if we updated at least one row
			if($entries > 1) {
				// Show the updated message
				add_settings_error(
			        'franchise_locations_files_updated',
			        'settings_updated',
			        'Franchise Locations Updated.',
			        'updated'
			  );

			} else {
				add_settings_error(
			        'franchise_locations_files_updated',
			        'settings_updated',
			        'Franchise Locations file uploaded but nothing got updated, please check the file and try again.',
			        'error'
			  );

				return false;
			}

	  } //endif

		return false;
	}


	private function handle_zip_to_county_codes_file_upload()	{

	  	if( !empty($_FILES["zip_to_county_codes"]["tmp_name"]) ){

		  	if( !check_admin_referer( 'franchise_map_form') ) {
		  		die('Security Check!');
		  	}

				// TODO Check file type

		  	$urls = wp_handle_upload($_FILES["zip_to_county_codes"], array('test_form' => FALSE));
		    $movefile = $urls['url'];


		    //Import uploaded file to Database
		    global $wpdb;
		    $entries = 0;
				$output = '';
	      $handle = fopen($movefile, "r");
				$table_name = $wpdb->prefix.'zip_to_county_codes';
		    while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {

			    // Skip the first row
			    if ($entries === 0) {
			    	$entries++;
			      continue;
			    }

			    if ( count($data) == 5  ) {

				    $update_row = array(
		    			'zip' => $data[0],
		    			'county_code' => $data[1],
		    			'city' => $data[2],
		    			'state' => $data[3],
		    			'county' => $data[4]
	    			);

				    $update = $wpdb->replace($table_name,
				    	$update_row,
							array(
								'%s',
								'%s',
								'%s',
								'%s',
								'%s'
							)
			    	);
						if($update){
			    		$entries++;
						}
		    	} // endif

			} //endwhile

			// if we updated at least one row
			if($entries > 1) {
				// Show the updated message
				add_settings_error(
			        'zip_to_county_codes_files_updated',
			        'settings_updated',
			        'ZIP Codes Updated.',
			        'updated'
			  );

			} else {
				add_settings_error(
			        'zip_to_county_codes_files_updated',
			        'settings_updated',
			        'ZIP Codes file uploaded but nothing got updated, please check the file and try again.',
			        'error'
			  );

				return false;
			}

	  } //endif

		return false;
	}

}
