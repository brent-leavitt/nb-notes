<?php

Namespace Nb_Notes\App\Clss;
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/includes
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */
class Nb_Notes {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Nb_Notes_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->autoload(); 
		
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'deactivate']] );

		$this->version = ( defined( 'NB_NOTES_VERSION' ) ) ? NB_NOTES_VERSION : '1.0.0';
		$this->plugin_name = 'nb-notes';

		
		$this->loader = new Nb_Notes_Loader();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}
	

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Nb_Notes_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Nb_Notes_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Nb_Notes_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Nb_Notes_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Nb_Notes_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	
	/**
	 * Activate the plugin
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	public function activate() {
		
		do_action( 'nb_notes_activate' );
		echo "<p>"; 
			_e( "The plugin has been activated! Whoop!", 'nb-notes' ); 
		echo "</p>";

	}


	
	/**
	 * Runs on plugin Deactivation
	 *
	 * @since     1.0.0
	 * @return    void
	 */
	public function deactivate() {
		
		do_action( 'nb_notes_deactivate' );


	}


	
	/**
	 *	This loads all classes, as needed, automatically! Slick!
	 *
	 * @since     1.0.0
	 * @return    void
	**/

	private function autoload(){
				
		spl_autoload_register( function( $class ){
			
			$path = strtolower( str_replace( '\\', '/', $class) );				
			$path = str_replace( 'nb_note/', '', $path );				
			$path = NB_NOTES_PATH. $path . '.class.php';
			
			if( file_exists( $path ) )
				require $path;
			
		} );
	} 