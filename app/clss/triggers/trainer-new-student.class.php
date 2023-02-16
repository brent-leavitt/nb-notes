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
 
 
if( !class_exists( 'Trainer_New_Student' ) ){ 
	class Trainer_New_Student extends Trigger { 

		/**
		 * Difference between this and the 'new-student-registration' triggers are the data that they receive from the action hook. 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      const    $name   (description)
		 */
		protected const TRIGGER = 'Trainer_New_Student'; 

		
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

			add_action( 'nb_trainer_new_student', [ $this, 'init' ], 10, 2 ); 
		
		}
			
		
		/**
		 * Initializes and executes the action hook //NEEDS WORK BECAUSE IT NEEDS TO LISTEN TO THE INCOMING PARAMATERS. 
		 *
		 * @since     1.0.0
		 * @param     array ...$args // params: $student_id,  $next_trainer_id
		 * @return    void
		 */

		 public function init( ...$args ) {

			//This is where the incoming parameter data is received. 
			error_log( "The ". __FILE__ ."::". __METHOD__ ." has been called. Here are the paramaters being passed. ". var_export( $args, true ) );
			
			//student ID
			$this->submitter_id = $args[ 0 ];

			//Trainer ID 
			$this->target_id = $args[ 1 ]; 
			
			//This is a system generated notification, as a part of the registration process. 
			$this->source = 'system'; 

			//pull the trigger. 
			$this->build(); 
			
		}	

	}

}
?>