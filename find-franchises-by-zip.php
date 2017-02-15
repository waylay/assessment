<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://webcodesigner.com
 * @since             1.0.0
 * @package           Find_Franchises_By_Zip
 *
 * @wordpress-plugin
 * Plugin Name:       Find Franchises by ZIP Code
 * Plugin URI:        http://webcodesigner.com/find-franchises-by-zip
 * Description:       This plugin lets customers enter their zip code into a search bar and see location results.
 * Version:           1.0.0
 * Author:            Cristian Ionel
 * Author URI:        http://webcodesigner.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       find-franchises-by-zip
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-find-franchises-by-zip-activator.php
 */
function activate_find_franchises_by_zip() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-find-franchises-by-zip-activator.php';
	Find_Franchises_By_Zip_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-find-franchises-by-zip-deactivator.php
 */
function deactivate_find_franchises_by_zip() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-find-franchises-by-zip-deactivator.php';
	Find_Franchises_By_Zip_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_find_franchises_by_zip' );
register_deactivation_hook( __FILE__, 'deactivate_find_franchises_by_zip' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-find-franchises-by-zip.php';
require plugin_dir_path( __FILE__ ) . 'includes/classs-franchisearch.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_find_franchises_by_zip() {

	$plugin = new Find_Franchises_By_Zip();
	$plugin->run();

}
run_find_franchises_by_zip();
