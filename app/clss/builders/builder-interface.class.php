<?php 

Namespace Nb_Notes\App\Clss\Builders;
//use ; 


/**
 * (description here)
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Builders/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !interface_exists( 'Builder_Interface' ) ){ 
	interface Builder_Interface { 

		
		//Methods Definitions

		/**
		 * The director method that puts all the variable and dynamic content together into a cohesive message. 
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		public function build( array $params );


		/**
		 * Returns the content of the notification
		 *
		 * @since     1.0.0
		 * @return    string
		 */
		public function get_content();


		/**
		 * Returns the subject of the notification
		 *
		 * @since     1.0.0
		 * @return    string
		 */
		public function get_subject();


		/**
		 * Check if the notification is to send an email. Most often the answer is yes. 
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		public function is_email();

		
		
		
		
	}	
}
?>