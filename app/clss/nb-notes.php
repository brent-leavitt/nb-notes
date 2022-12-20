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
 * @subpackage Nb_Notes/App/Clss/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

class Nb_Notes {

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $name    The string used to uniquely identify this plugin.
	 */
	protected $name;

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
	public function go() {
		
		//set basic parameters. 
		$this->version = ( defined( 'NB_NOTES_VERSION' ) ) ? NB_NOTES_VERSION : '1.0.0';
		$this->name = 'nb-notes';

		//buggy, not fully working as expected. 
		add_action( 'init', [$this, 'depends_on'] );  

		$this->autoload(); 
		$this->required(); 

		$this->set_locale();
		
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_public_scripts' ] );
		

	}
	
	/**
	 * Checks and set plugin dependencies
	 * Buggy and not ideal. Needs a little more thought. 
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function depends_on() {
		if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
			include_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		}

		if ( current_user_can( 'activate_plugins' ) && !defined( 'DOULA_COURSE_PATH' ) ) {

			// Throw an error in the WordPress admin console.
			$error_message = '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'This plugin requires LearnDash-NBCS plugin to also be installed and active!', 'nb-notes' ). '</p></div>';
			add_action( 'admin_notices', function( $error_message ){ print( $error_message ); } ); 
			//print( $error_message ); 

			// Deactivate the plugin.
			deactivate_plugins( NB_NOTES_NAME );
		}
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

		$plugin_i18n = new Nb_Notes_I18n();
		add_action( 'plugins_loaded', [ $plugin_i18n, 'load_plugin_textdomain'] );

	}

	/**
	 * Register Scripts for Admin Area
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_admin_scripts() {

		$this->enqueue_scripts_styles( 'admin' );
	}

	/**
	 * Register Scripts for Public
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function enqueue_public_scripts() {
	
		$this->enqueue_scripts_styles( 'public' );
	
	}


	/**
	 * Enqueue Scripts and Styles based on 
	 *
	 * @since     1.0.0
	 * @param     $view
	 * @return    string    The name of the plugin.
	 */
	private function enqueue_scripts_styles( $view ) {
		$path = NB_NOTES_URL . 'app/tmpl/'. $view;

		//stylesheets
		wp_enqueue_style( $this->name, $path .'/css/nb-notes-'. $view .'.css', array(), $this->version, 'all' );

		//javascript/jquery
		wp_enqueue_script( $this->name, $path . '/js/nb-notes-'. $view .'.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->name;
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
	 *	This loads all classes, as needed, automatically! Slick!
	 *
	 * @since     1.0.0
	 * @return    void
	**/

	private function autoload(){
				
		spl_autoload_register( function( $class ){
			
			$path = strtolower( str_replace( '\\', '/', $class) );				
			$path = str_replace( 'nb_notes/', '', $path );				
			$path = str_replace( '_', '-', $path );				
			$path = NB_NOTES_PATH. $path . '.class.php';

			if( file_exists( $path ) )
				require $path;
			
		} );
	} 	
	/**
	 *	This loads all required function files. 
	 *
	 * @since     1.0.0
	 * @return    void
	**/

	private function required(){
				
		$functions = [
			'actions',
			'setup',
			'triggers',
			//''

		]; 

		foreach( $functions as $func ){

			$path = 'app/func/'. $func; 			
			$path = NB_NOTES_PATH. $path .'.php';
			
			if( file_exists( $path ) )
				require $path;
			
		}
	} 

}