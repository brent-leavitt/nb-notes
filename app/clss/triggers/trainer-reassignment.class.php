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
		 * Listening for 'nb_trainer_reassignment', called in learndash-nbcs->app->classes->edit_student_processor::161
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
		 * Initializes and executes the action hook 
		 *
		 * @since     1.0.0
		 * @param     array ...$args //action hook params: user_id, old_trainer, new_trainer, userdata
		 * @return    void
		 */

		 public function init( ...$args ) {
 
			//This is where the incoming parameter data is received. 
			error_log( "The ". __FILE__ ."::". __METHOD__ ." has been called. Here are the paramaters being passed. ". var_export( $args, true ) );
			
			if( empty( $args[ 2 ] ) ){//New trainer is unassigned, then abort. This should never happen now, but just in case... 
				error_log( "A new trainer was not assigned." ); 
				return; 
			}
			//This is a little different because we want all three to be notified: student, old trainer, and new trainer. 
			//defaults to system as the source of the notice 
			$this->submitter_id = get_current_user_id();

			//the student being impacted by the reassignment. 
			$this->target_id = $args[ 0 ]; 
			$this->args[ 'student' ] = $args[ 0 ];

			//who are the trainers impacted by this reassignment?
			$this->args[ 'trainers' ][ 'old_trainer' ] = $args[ 1 ]; 
			$this->args[ 'trainers' ][ 'new_trainer' ] = $args[ 2 ];
			
			//Assuming the source of the trainer reassignment would only be an administrator. 
			$this->source = 'admin'; 

			//pull the trigger. 
			$this->build(); 
		}	

		/**
		 * The build function is overridden by this particular class because we need to notify two trainers instead of one. 
		 *
		 * @since     1.0.0
		 * @return    void
		 */	 
		protected function build()
		{
			//load a default template for this hook. Has (some variables) $content pre-defined. 
			include( NB_NOTES_PATH. 'app/tmpl/email/default_trigger_vars/' . strtolower( $this::TRIGGER ) .'.tmpl.php' ); 
		
			foreach( $templates as $tmpl )
				if( strcmp( $tmpl[ 'receiver' ], 'trainer' ) === 0 ){
					//we need to repent this action twice, old and new trainer. 
					
					//First send to old trainer: 
					$this->target_id = $this->args[ 'trainers' ][ 'old_trainer' ];
					$this->send_one( $tmpl );

					//Then send to new trainer: 
					$this->target_id = $this->args[ 'trainers' ][ 'new_trainer' ];
					$this->send_one( $tmpl );

				}
				else //assume it is the student we sending to. 
				{
					$this->target_id = $this->args[ 'student' ];
					$this->send_one( $tmpl ); 
				}
				
		}



		/**
		 * Send one email at a time.
		 * 
		 * @since     1.0.0
		 * @return    void
		 */	 
		protected function send_one( $tmpl )
		{
			$this->send( $tmpl[ 'receiver' ], $tmpl[ 'sender' ], $tmpl[ 'builder' ], $tmpl[ 'params' ], $tmpl[ 'html' ],  );
		}
	}

}
?>