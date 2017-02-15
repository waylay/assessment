<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://webcodesigner.com
 * @since      1.0.0
 *
 * @package    Find_Franchises_By_Zip
 * @subpackage Find_Franchises_By_Zip/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Find_Franchises_By_Zip
 * @subpackage Find_Franchises_By_Zip/public
 * @author     Cristian Ionel <cristian.ionel@gmail.com>
 */
class Find_Franchises_By_Zip_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/find-franchises-by-zip-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/find-franchises-by-zip-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}

	public function add_modal_html()
	{
		?>
		<div id="results-modal">
			<!-- Trigger/Open The Modal -->
			<form class="search-franchises" action="/" method="post">
				<input type="text" class="search-text" name="zip_code" value="" placeholder="Type your ZIP Code" requried>
				<input type="submit" class="search-button" value="Search">
			</form>

			<!-- The Modal -->
			<div id="modal">
				<h3>Search Results</h3>
			</div>

		</div>
		<?php
	}

	function search_franchises_ajax_request() {

    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST)) {

			global $wpdb;
			$zip = mysql_escape_string($_REQUEST['zip_code']);

			$county = $wpdb->get_results("SELECT * FROM wp_zip_to_county_codes WHERE zip = $zip", ARRAY_A);

			// FINISH THE COUNTY QUERY


    }
		die();
	}

}
