<?php

/**
 * Fired during plugin activation
 *
 * @link       http://webcodesigner.com
 * @since      1.0.0
 *
 * @package    Find_Franchises_By_Zip
 * @subpackage Find_Franchises_By_Zip/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Find_Franchises_By_Zip
 * @subpackage Find_Franchises_By_Zip/includes
 * @author     Cristian Ionel <cristian.ionel@gmail.com>
 */
class Find_Franchises_By_Zip_Activator {

	/**
	 * Create required tables
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$zip_to_county_codes_table = $wpdb->prefix.'zip_to_county_codes';

		// ZIP,County_Code,City,ST,County
		$zip_to_county_codes_sql = "CREATE TABLE $zip_to_county_codes_table (
			zip varchar(10) NOT NULL,
			county_code varchar(10) NOT NULL,
			city varchar(255) NOT NULL,
			state varchar(255) NOT NULL,
			county varchar(255) NOT NULL,
			PRIMARY KEY (`zip`)
		) $charset_collate;";

		dbDelta( $zip_to_county_codes_sql );


		$franchise_locations_table = $wpdb->prefix.'franchise_locations';

		// franchise_id,franchise_name,phone,website,email,county_codes
		$franchise_locations_sql = "CREATE TABLE $franchise_locations_table (
			franchise_id int NOT NULL,
			franchise_name varchar(255) NOT NULL,
			phone varchar(15) NOT NULL,
			website varchar(255) NOT NULL,
			email varchar(255) NOT NULL,
			county_codes varchar(255) NOT NULL,
			PRIMARY KEY (`franchise_id`)
		) $charset_collate;";

		dbDelta( $franchise_locations_sql );

	}

}
