<?php 

Namespace Nb_Notes\App\Clss\Triggers;
use function Nb_Notes\App\Func\notify; 


/**
 * (description here)
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Triggers
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Trainer_Reassignment' ) ){ 
	class Trainer_Reassignment extends Trigger { 

		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      const    $name   (description)
		 */
		protected const TRIGGER = 'Trainer_Reassignment'; 
		
			
		//Then Methods

	
		/**
		 * Listening for 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */	 
		public function listen()
		{

			add_action( 'nb_trainer_reassignment', [ $this, 'init' ], 10, 4 ); 
		
		}
			
		
		/**
		 * Initializes and executes the action hook //NEEDS WORK BECAUSE IT NEEDS TO LISTEN TO THE INCOMING PARAMATERS. 
		 *
		 * @since     1.0.0
		 * @param     array ...$args //action hook params: user_id, old_trainer, new_trainer, userdata
		 * @return    void
		 */

		 public function init( ...$args ) {
 
			//This is where the incoming parameter data is received. 
			error_log( "The ". __FILE__ ."::". __METHOD__ ." has been called. Here are the paramaters being passed. ". var_export( $args, true ) );
			

			//This is a little different because we want all three to be notified: student, old trainer, and new trainer. 
			//defaults to system as the source of the notice 
			$this->submitter_id = 0;

			//the student being impacted by the reassignment. 
			$this->target_id = $args[ 0 ]; 

			//who are the trainers impacted by this reassignment?
			$this->args[ 'trainers' ][ 'old_trainer' ] = $args[ 1 ]; 
			$this->args[ 'trainers' ][ 'new_trainer' ] = $args[ 2 ];
			
			//Assuming the source of the trainer reassignment would only be an administrator. 
			$this->source = 'admin'; 


			//pull the trigger. 
			$this->build(); 
		}	

		
		/**
		 * (description)
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */
		private function set_()
		{
		
			
		}
		
		
		
		/**
		 * (description)
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */
		private function get_(){
		
			
		}
	
		
		
		/**
		 * (description)
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */	 
		public function _()
		{

			
		
		}

	}

}
?>