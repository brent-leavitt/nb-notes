<?php 

Namespace Nb_Notes\App\Clss\Builder;
//use ; 


/**
 * (description here)
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Builder/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !interface_exists( 'Builder_Interface' ) ){ 
	interface Builder_Interface { 

		
		//Methods Definitions

		/**
		 * 
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		public function build();


		/**
		 * 
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		public function get_content();


		/**
		 * 
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		public function get_subject();


		/**
		 * 
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		public function do_email();

		
		
		
		
	}	
}
?>