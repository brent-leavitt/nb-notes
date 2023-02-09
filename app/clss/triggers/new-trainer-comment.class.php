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
 
 
if( !class_exists( 'New_Trainer_Comment' ) ){ 
	class New_Trainer_Comment extends Trigger { 

		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      const    $name   (description)
		 */
		protected const TRIGGER = 'New_Trainer_Comment'; 
		
		
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

			add_action( 'nb_new_trainer_comment', [ $this, 'init' ], 10, 4 ); 
		
		}
			
		
		/**
		 * Initializes and executes the action hook
		 *
		 * @since     1.0.0
		 * @param     array ...$args  [0] => $student_id, [1] => $trainer_id, [2] => $commenter_id, [3] => $comment_obj
		 * @return    void
		 */

		 public function init( ...$args ) {

			//This is where the incoming parameter data is received. 
			error_log( "The ". __FILE__ ."::". __METHOD__ ." has been called. Here are the paramaters being passed. ". var_export( $args, true ) );
					
			//Define target_id and submitter_id 
			$this->target_id 		= $args[ 0 ]; //Student_ID
			$this->submitter_id 	=   $args[ 2 ]; //Trainer_ID

			//The comment_obj is being passed to the builder from this trigger. 
			$this->args[ 'comment' ] 	= $args[ 3 ];
			
			//The source of a new comment triggers could be the trainer or someone else. 
			if( $args[ 1 ] === $args[ 2 ] ) //if the trainer and commenter IDs are the same then the trigger came from the trainer. 
				$this->source = 'trainer'; 
			else  
				$this->source = 'admin'; //otherwise assume that it is an adminstrator who is commenting. 

			//pull the trigger. 
			$this->build();  
			
		}
	}
}
?>