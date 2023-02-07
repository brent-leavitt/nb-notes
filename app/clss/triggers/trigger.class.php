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
		
		

		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      (type)    $name   (description)
		 */
		//protected $_; 
		
		

		
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
			/* 
			error_log( 'The send method from the trigger abstract class has been called. These are the parameters being sent: 
			 	RECEIVER: '.$receiver.'
			 	SENDER: '.$sender .'
			 	BUILDER: '.$builder .'
			 	PARAMS: '. var_export( $params , true ) .'
			 	HTML: '.$html 
			);
			*/
			/*
			error_log( "The RECIEVER ID is: ".	$this->get_user_id( $receiver ). "
				The SENDER ID is: ".	$this->get_user_id( $sender )  ); 
			*/

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
		public function get_user_id( $user_type ): int
		{
			return ( strcmp( $user_type, $this->source ) == 0 )? $this->submitter_id : $this->set_target_id( $user_type ); 
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