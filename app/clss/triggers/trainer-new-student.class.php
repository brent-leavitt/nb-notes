<?php 

Namespace Nb_Notes\App\Clss\Triggers;
use function Nb_Notes\App\Func\notify; 
use Nb_Notes\App\Clss\Director; 


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
		 * Listening for 'nb_trainer_new_student' action hook, fired from 
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
			//error_log( "The ". __FILE__ ."::". __METHOD__ ." has been called. Here are the paramaters being passed. ". var_export( $args, true ) );
			
			//student ID
			$this->target_id = $args[ 0 ]; 
			
			//set args to be sent:
			$this->args[ 'student_id' ] = $args[ 0 ];
			$this->args[ 'trainer_id' ] = $args[ 1 ];

			//This is a system generated notification, as a part of the registration process. 
			$this->source = 'system'; 

			//pull the trigger. 
			$this->build(); 
			
		}	


		/**
		 * The final action to be taken by any trigger 
		 *
		 * @since     1.0.0
		 * @param     string	$receiver
		 * @param     string 	$sender 	
		 * @param     string 	$builder
		 * @param     array 	$params
		 * @param     bool 		$html 		//default is true
		 * @return    void
		 */	 

		 protected function send( $receiver, $sender, $builder, $params, $html = true )
		 {			
			$receiver_id = 0; 

			switch( $receiver ){
				case 'student':
					$receiver_id = $this->args[ 'student_id' ];
					break;
				case 'trainer': 
					$receiver_id = $this->args[ 'trainer_id' ];
					break;
			}

			$director = new Director( 
				$receiver_id, 
				$this->get_user_id( $sender ), 
				$builder, 
				$params,
				$html
			 ); 
			
			return $director->go(); 		 

		 }
	


	}

}
?>