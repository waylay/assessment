<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://webcodesigner.com
 * @since      1.0.0
 *
 * @package    Find_Franchises_By_Zip
 * @subpackage Find_Franchises_By_Zip/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Find_Franchises_By_Zip
 * @subpackage Find_Franchises_By_Zip/includes
 * @author     Cristian Ionel <cristian.ionel@gmail.com>
 */
class Find_Franchises_By_Zip_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'find-franchises-by-zip',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
