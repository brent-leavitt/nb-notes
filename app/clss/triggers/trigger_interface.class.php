<?php 

Namespace Nb_Notes\App\Clss\Triggers;
//use ; 


/**
 * (description here)
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Triggers/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !interface_exists( 'Trigger_Interface' ) ){ 
	interface Trigger_Interface { 

		
		//Methods Definitions

		/**
		 * Every class must listen for add_action(hooks) from other parts of the system so that they know when to act. 
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		public function listen();

		
		
		/**
		 * The base action that gets called when a listener picks up an action to perform. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */
		public function init();
		

		
		
		/**
		 * After the work is done, this must be called. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */
		protected function send();
		
		
		
	}	
}
?>