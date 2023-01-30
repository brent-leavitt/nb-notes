<?php

Namespace Nb_Notes\App\Clss;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */
class Nb_Notes_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		//error_log( "The plugin has been activated! Whoop!" );
		self::build_database(); 

	}


	private static function build_database(){
		global $wpdb;
		$table_name = 'nb_notes';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			note_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			note_type tinytext NOT NULL,
			note_subject tinytext NOT NULL,
			note_content text NOT NULL,
			note_recipient int NOT NULL,
			note_headers text NULL,
			note_attach text NULL,
			note_status tinytext NOT NULL,
			note_active bit(1) DEFAULT 0 NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		add_option( 'nb_notes_db_version', NB_NOTES_DB_VERSION );
	}
}	
