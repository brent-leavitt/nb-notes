<?php

Namespace Nb_Notes\App\Clss;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

class Nb_Notes_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'nb-notes',
			false,
			NB_NOTES_PATH . '/app/lang/'
		);

	}



}
