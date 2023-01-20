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
		 * The IDs of the notification CPT templates created by an admin_user and stored in options table. 
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      array
		 */
		protected $templates; 
		
		

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
		 * Loads the IDs for all Notification templates for this particular trigger
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		protected function get_template_ids(){
			
			$templates  = get_option( 'nb_notes_trigger_templates' ); 

			//sets the array of notification CPT ids, if there be any set.  
			if( isset(  $templates[ $this::TRIGGER ] ) )
				$this->templates =  $templates[ $this::TRIGGER ];
	
		}
		
		
		/**
		 * Fires the trigger once all parameters have been set
		 *
		 * @since     1.0.0
		 * @return    void
		 */	 
		protected function fire()
		{
			//get notification templates as created by the admins in the Notification CPT and stored in the Options array. 
			$this->get_template_ids(); 
	
			//Assembles everythign together and sends it on it way.  
			$this->build(); 
		}
	

		/**
		 * Loads Templates and parameteres to be sent and sends them. 
		 *
		 * @since     1.0.0
		 * @return    void
		 */	 
		protected function build()
		{
			//If there are templates available
			if( !empty( $this->templates ) )
			{
				//foreach template ID, load the template, and prepare to send. 
				foreach( $this->templates as $tmpl_id )
				{
					$template_params = get_post_meta( $tmpl_id, 'nb_notice_template_params', TRUE ); 
					
					//assigns meta data from the post (which functionality has not been created yet); 
					$builder 	= $template_params[ 'builder' ] ?? NULL;
					$html 		= $template_params[ 'html' ] ?? true; 			
					$receiver	= $template_params[ 'receiver' ] ?? 'student';	//This can be sepecified with the notificaiton template. 
					$sender		= $template_params[ 'sender' ] ?? 'system'; 		//This can also be specified with the notification template. 

					//Content from template needs to be taken in. 
					//parameters from Action hook need to be assigned. 
					//shortcode action where content and parameters are merged needs to happen. 
					
					$params = [
						'content' 	=> $template->post_content,
						'subject' 	=> $template->post_title,
						'args' 		=> $this->args
					];

					$this->send(  $receiver, $sender, $builder, $params, $html );
				}
			}
			else
			{	//if not template is available, maybe have system default.
				//load a default template for this hook. Has (some variables) $content pre-defined. 
				include( NB_NOTES_PATH. 'app/tmpl/email/defaults/' . strtolower( $this::TRIGGER ) .'.tmpl.php' ); 
				
				//May need to set inside of a foreach loop. 
				foreach( $templates as $tmpl )
					$this->send( $tmpl[ 'receiver' ], $tmpl[ 'sender' ], $tmpl[ 'builder' ], $tmpl[ 'params' ], $tmpl[ 'html' ],  );
		
			}
		
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