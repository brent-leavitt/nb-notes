<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
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
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NB_NOTES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nb-notes-activator.php
 */
function activate_nb_notes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nb-notes-activator.php';
	Nb_Notes_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nb-notes-deactivator.php
 */
function deactivate_nb_notes() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nb-notes-deactivator.php';
	Nb_Notes_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nb_notes' );
register_deactivation_hook( __FILE__, 'deactivate_nb_notes' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nb-notes.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nb_notes() {

	$plugin = new Nb_Notes();
	$plugin->run();

}
run_nb_notes();
