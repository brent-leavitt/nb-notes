<?php

/**
 *
 * @link              https://www.brentleavitt.com
 * @since             1.0.0
 * @package           Nb_Notes
 *
 * @wordpress-plugin
 * Plugin Name:       NB Notes
 * Plugin URI:        https://www.trainingdoulas.com
 * Description:       This handles notifications uses to run New Beginnings Childbirth Services online learning platform. Built on top of LearnDash LMS and Restricted Content Pro. LearnDash_NBCS is a required plugin. 
 * Version:           1.0.0
 * Author:            Brent Leavitt
 * Author URI:        https://www.brentleavitt.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nb-notes
 * Domain Path:       /app/lang
 */



namespace Nb_Notes;
use Nb_Notes\App\Clss\Nb_Notes as Notes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * CONSTANTS
 */
if( !defined( 'NB_NOTES_VERSION' ) )
	define( 'NB_NOTES_VERSION', '1.0.0' );

if( !defined( 'NB_NOTES_DB_VERSION' ) )
	define( 'NB_NOTES_DB_VERSION', '1.0.0' );

if( !defined( 'NB_NOTES_PATH' ) )
	define( 'NB_NOTES_PATH', plugin_dir_path( __FILE__ ) );

if( !defined( 'NB_NOTES_URL' ) )
	define( 'NB_NOTES_URL', plugin_dir_url( __FILE__ ) );

if( !defined( 'NB_NOTES_NAME' ) )
	define( 'NB_NOTES_NAME', plugin_basename( __FILE__ ) );


require NB_NOTES_PATH . '/app/clss/nb-notes.php';

register_activation_hook( __FILE__, '\Nb_Notes\activate'  );

register_deactivation_hook( __FILE__, '\Nb_Notes\deactivate' );

	
/**
 * Activate the plugin
 *
 * @since     1.0.0
 * @return    void
 */
function activate() {
	
	\Nb_Notes\App\Clss\Nb_Notes_Activator::activate(); 
	
	do_action( 'nb_notes_activate' );

}



/**
 * Runs on plugin Deactivation
 *
 * @since     1.0.0
 * @return    void
 */
function deactivate() {
	
	//\Nb_Notes\App\Clss\Nb_Notes_Deactivator::deactivate(); 
	do_action( 'nb_notes_deactivate' );

}




$nb_notes= new Notes();
$nb_notes->go();