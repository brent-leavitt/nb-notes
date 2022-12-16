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
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private TRIGGER = 'Assignment_Submitted'; 
		
		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $; 
		
		
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

			add_action( 'nb_assignement_submitted', [ $this, 'init' ] ); 
		
		}

				
		
		/**
		 * Initializes and executes the action hook //NEEDS WORK BECAUSE IT NEEDS TO LISTEN TO THE INCOMING PARAMATERS. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */

		public function init() {

			//get notification templates as created by the admins in the Notification CPT and stored in the Options array. 
			$this->get_template_ids(); 
			
			//Process incoming parameters. 
			$this->prepare_params(); 

			//Connects everythign together and sends it on it way.  
			$this->connect(); 

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
		 * (description)
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */
		private function get_(){
		
			
		}
			
		
		
		/**
		 * Loads Templates and parameteres to be sent and sends them. 
		 *
		 * @since     1.0.0
		 * @return    void
		 */	 
		public function connect()
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