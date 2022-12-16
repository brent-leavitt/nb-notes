<?php 

Namespace Nb_Notes\App\Clss\Triggers;
//use ; 


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
		 * Who is this email being sent to?
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      int    
		 */
		protected $receiver_id; 
		
		
		/**
		 * Who is sending the email? 
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      int 
		 */
		protected $sender_id; 
		
		
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
		protected $; 
		
		

		
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
		protected function get_templates_ids(){
			
			$templates  = get_option( 'nb_notes_templates' ); 

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
		
			//Process incoming parameters. //NOT SURE IF NEEDED. 
			$this->prepare_params(); 

			//Connects everythign together and sends it on it way.  
			$this->connect(); 

		}
	

		/**
		 * Loads Templates and parameteres to be sent and sends them. 
		 *
		 * @since     1.0.0
		 * @return    void
		 */	 
		protected function connect()
		{
			
			//If there are templates available
			if( !empty( $this->templates ) )
			{
				//foreach template ID, load the template, and prepare to send. 
				foreach( $this->templates as $tmpl_id )
				{
					$template = get_post( $tmpl_id ); 
					
					//assigns meta data from the post (which functionality has not been created yet); 
					$builder 	= $template->nb_note_template_params[ 'builder' ];
					$html 		= $template->nb_note_template_params[ 'html' ]; 

					//Content from template needs to be taken in. 
					//parameters from Action hook need to be assigned. 
					//shortcode action where content and parameters are merged needs to happen. 
					
					$params = [
						'content' 	=> $template->post_content,
						'subject' 	=> $template->post_title,
						'args' 		=> $this->args

					];

					$this->send( $builder, $params, $html );
				}
			}
			else
			{	//if not template is available, maybe have system default.
				//load a default template for this hook. Has (some variables) $content pre-defined. 
				include( NB_NOTES_PATH. 'app/tmpl/email/defaults/' . $this::TRIGGER .'.tmpl.php' ); 
				
				$this->send( $builder, $params, $html );
			}
		
		}
	


		/**
		 * The final action to be taken by any trigger 
		 *
		 * @since     1.0.0
		 * @param     string 	$builder
		 * @param     array 	$params
		 * @param     bool 		$html
		 * @return    void
		 */	 

		 protected function send( $builder, $params, $html )
		 {
			 $sender_id = 0; //system generated 
			 $sent = notifiy( $this->receiver_id, $sender_id, $builder, $params, $html ); 
			 //Could process this further to back up or make more redundant.
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