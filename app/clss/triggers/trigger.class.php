<?php 

namespace Nb_Notes\App\Clss\Triggers;
use Nb_Notes\App\Clss\Director; 


/**
 * This is the base class for trigger objects for all things that they share in common. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Triggers/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Trigger' ) ){ 
	abstract class Trigger implements Trigger_Interface { 
		
		
		/**
		 * The user ID for the person responsible for launching the trigger. Default is 0 for system. 
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      int
		 */
		protected $submitter_id = 0; 

		/**
		 * The user ID for the person targeted to receive the notificaiton. Default is 0 for system. 
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      int
		 */
		//protected $target_id = 0; 
		
		/**
		 * The source of the submitted trigger, it could be a student, trainer, admin, or system. Default is system.  
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      string
		 */
		protected $source = 'system'; 
		
		/**
		 * Slug of the builder name
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      string
		 */
		protected $builder; 
		
		
		/**
		 * Availale parameters or arguments for this notification
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      array
		 */
		protected $args; 
	

		
		//Then Methods

		/**
		 * (description)
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */
		public function __construct(  )
		{
		}


		/**
		 * Loads Templates and parameteres to be sent and sends them. 
		 *
		 * @since     1.0.0
		 * @return    void
		 */	 
		protected function build()
		{
			//load a default template for this hook. Has (some variables) $content pre-defined. 
			include( NB_NOTES_PATH. 'app/tmpl/email/default_trigger_vars/' . strtolower( $this::TRIGGER ) .'.tmpl.php' ); 
			
			//May need to set inside of a foreach loop. 
			foreach( $templates as $tmpl )
				$this->send( $tmpl[ 'receiver' ], $tmpl[ 'sender' ], $tmpl[ 'builder' ], $tmpl[ 'params' ], $tmpl[ 'html' ],  );
		
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
			
			$director = new Director( 
				$this->get_user_id( $receiver ), 
				$this->get_user_id( $sender ), 
				$builder, 
				$params,
				$html
			 ); 
			
			return $director->go(); 		 

		 }
 
				 
		/**
		 * If the type of user requested matches the source user type, then return the submitter_id, else the target_id. 
		 * 
		 * @since     1.0.0
		 * @param     string 	$user_type
		 * @return    int		$user_id
		 */	 
		private function get_user_id( $user_type ): int
		{
			return ( strcmp( $user_type, $this->source ) == 0 )? $this->submitter_id : $this->set_target_id( $user_type ); 
		}

		
		/**
		 * Returns the targetted receiver's user ID. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */

		private function set_target_id( $type )
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
	}
}
?>