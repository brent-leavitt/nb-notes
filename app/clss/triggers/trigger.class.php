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

			error_log( "The trigger::fire() method has been called. " ); 
			//get notification templates as created by the admins in the Notification CPT and stored in the Options array. 
			$this->get_template_ids(); 
	
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
					$builder 	= $template->nb_note_template_params[ 'builder' ] ?? NULL;
					$html 		= $template->nb_note_template_params[ 'html' ] ?? true; 			
					$receiver	= $template->nb_note_template_params[ 'receiver' ] ?? 'student';	//This can be sepecified with the notificaiton template. 
					$sender		= $template->nb_note_template_params[ 'sender' ] ?? 0; 				//This can also be specified with the notification template. 


					//Content from template needs to be taken in. 
					//parameters from Action hook need to be assigned. 
					//shortcode action where content and parameters are merged needs to happen. 
					
					$params = [
						'content' 	=> $template->post_content,
						'subject' 	=> $template->post_title,
						'args' 		=> $this->args
					];

					$this->send(  $receiver_id, $builder, $params, $html, $sender_id );
				}
			}
			else
			{	//if not template is available, maybe have system default.
				//load a default template for this hook. Has (some variables) $content pre-defined. 
				include( NB_NOTES_PATH. 'app/tmpl/email/defaults/' . strtolower( $this::TRIGGER ) .'.tmpl.php' ); 
				
				//May need to set inside of a foreach loop. 
				foreach( $templates as $tmpl )
					$this->send( $tmpl[ 'receiver' ],  $tmpl[ 'builder' ], $tmpl[ 'params' ], $tmpl[ 'html' ], $tmpl[ 'sender' ] );
		
			}
		
		}
	


		/**
		 * The final action to be taken by any trigger 
		 *
		 * @since     1.0.0
		 * @param     int 		$receiver_id
		 * @param     string 	$builder
		 * @param     array 	$params
		 * @param     bool 		$html 		//default is true
		 * @param     string 	$sender_id 	//default is 0 for system. 
		 * @return    void
		 */	 

		 protected function send( $receiver_id, $builder, $params, $html = true, $sender_id = 0 )
		 {
			 error_log( 'The send method from the trigger abstract class has been called. These are the parameters being sent: 
			 	RECEIVER_ID: '.$receiver_id .'
			 	BUILDER: '.$builder .'
			 	PARAMS: '. var_export( $params , true ) .'
			 	HTML: '.$html .'
			 	SENDER ID: '.$sender_id 
			);

			$director = new Director( $receiver_id, $sender_id, $builder, $params, $html ); 
			
			return $director->go(); 		 

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