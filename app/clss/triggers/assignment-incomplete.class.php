<?php 

Namespace Nb_Notes\App\Clss\Triggers;
use function Nb_Notes\App\Func\get_assigned_trainer_id_from_student_id ; 


/**
 * Trigger that is fired when an assignment is marked as incomplete, 
 * meaning that the trainer is requesting more information 
 * of the student for the given assingment. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Triggers
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Assignment_Incomplete' ) ){ 
	class Assignment_Incomplete extends Trigger { 

		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      string    TRIGGER   (description)
		 */
		protected const TRIGGER = 'Assignment_Incomplete'; 
		
		
		
		//Then Methods
		
		/**
		 * Listening for the 'nb_assignment_incomplete' trigger. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */	 
		public function listen()
		{
			add_action( 'nb_assignment_incomplete', [ $this, 'init' ], 10, 2 ); 
		}

				
		
		/**
		 * Initializes and executes the action hook //NEEDS WORK BECAUSE IT NEEDS TO LISTEN TO THE INCOMING PARAMATERS. 
		 *
		 * @since     1.0.0
		 * @param     array ...$args  [0] => $post_id, [1] => $post_obj
		 * @return    void
		 */

		public function init( ...$args ) {

			//This is where the incoming parameter data is received. 
			error_log( "The ". __FILE__ ."::". __METHOD__ ." has been called. Here are the paramaters being passed. ". var_export( $args, true ) );
			
			//The assignment ID is the only argument being passed to the builder from this trigger. 
			$this->args[ 'asmt_id' ] = $args[ 0 ];
			
			//Define submitter_id and source of the trigger. 
			//Submitter ID will be the trainer assigned to the student. 
			$this->submitter_id = get_assigned_trainer_id_from_student_id( $args[1]->post_author );
		
			//The source of an assignment_incomplete trigger is only from a trainer. 
			$this->source = 'trainer'; 

			//pull the trigger. 
			$this->build(); 
		}	
	}
}

?>