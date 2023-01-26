<?php 

Namespace Nb_Notes\App\Clss\Triggers;
//use ; 


/**
 * Trigger that is fired when an assignment is submitted. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Triggers
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Assignment_Submitted' ) ){ 
	class Assignment_Submitted extends Trigger { 

		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      string    TRIGGER   (description)
		 */
		protected const TRIGGER = 'Assignment_Submitted'; 
		
		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $_; 
		
		
		//Then Methods

		/**
		 * (description)
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */
		public function __construct(  ){
				
				
				
		}
		
		
		/**
		 * Listening for 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */	 
		public function listen()
		{
			add_action( 'nb_assignment_submitted', [ $this, 'init' ], 10, 2 ); 
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
			//error_log( "The ". __FILE__ ."::". __METHOD__ ." has been called. Here are the paramaters being passed. ". var_export( $args, true ) );
			
			//The assignment ID is the only argument being passed to the builder from this trigger. 
			$this->args[ 'asmt_id' ] = $args[ 0 ];
			
			//Define submitter_id, target_id, and source of the trigger. 
			//Submitter ID will be the student, or author of the post. 
			$this->submitter_id = $args[1]->post_author;
			
			//Assuming the source of all submitted assignmen triggers are students, but probably should verify this. 
			$this->source = 'student'; 

			//pull the trigger. 
			$this->fire(); 
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
		 * Returns the targetted receiver's user ID. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */
		protected function set_target_id( $type )
		{
			switch( $type ){
				//Get "trainer" type from student meta, returns the trainer's ID or 0 if not found. 
				case "trainer":
					return  get_user_meta( $this->submitter_id, 'student_trainer', TRUE ) ?? 0 ;

				//Get "admin" type, If this notice is being targetted to the admin set as -1 because there are multiple admins.	
				case "admin":
					return -1; 
				
				//"student" type, should never be triggered here, but just in case. 	
				case "student":
					return $this->submitter_id; 

				//"system" type is default at 0, and hence should not be set here either.	
				case "system":
				default:
					return 0;
			}
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