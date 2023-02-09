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
 
 
if( !class_exists( 'New_Student_Comment' ) ){ 
	class New_Student_Comment extends Trigger { 

		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      const    $name   (description)
		 */
		protected const TRIGGER = 'New_Student_Comment'; 
		
		
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

			add_action( 'nb_new_student_comment', [ $this, 'init' ], 10, 3 ); 
		
		}
			
		
		/**
		 * Initializes and executes the action hook
		 *
		 * @since     1.0.0
		 * @param     array ...$args  [0] => $trainer_id, [1] => $student_id, [2] => $comment_obj
		 * @return    void
		 */

		 public function init( ...$args ) {

			//This is where the incoming parameter data is received. 
			error_log( "The ". __FILE__ ."::". __METHOD__ ." has been called. Here are the paramaters being passed. ". var_export( $args, true ) );
					
			//Define target_id and submitter_id 
			$this->target_id 		= $args[ 0 ]; //Trainer ID
			$this->submitter_id 	=   $args[ 1 ]; //Student_ID

			//The comment_obj is being passed to the builder from this trigger. 
			$this->args[ 'comment' ] 	= $args[ 2 ];
			
			//The source of all new student comment triggers are students. 
			$this->source = 'student'; 

			//pull the trigger. 
			$this->build();  

		}
	}
}
?>