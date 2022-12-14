<?php 

Namespace Nb_Notes\App\Clss;
//use ; 


/**
 * Controls the different classes that handle notificaiton processes.
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Controller' ) ){ 
	class Controller { 

		/**
		 * builds the content of the messages to be sent
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      object    $name   (description)
		 */
		private $builder; 
		
		

		/**
		 * sends notification via email
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      object    $name   (description)
		 */
		private $sender; 
		
		

		/**
		 * Records notification in the databse
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      object    $name   (description)
		 */
		private $recorder; 
		
		

		/**
		 * Records admin_notes for a user (when needed). 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      object    $name   (description)
		 */
		private $admin_noter; 


		/**
		 * Who receives the notice. 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      int 
		 */
		private $receiver_id; 

		

		/**
		 * Who is sending the notice. 0 for system generated.
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      int   
		 */
		private $sender_id = 0; 

		

		/**
		 * The template slug, used to call the appropriate class.
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      string  
		 */
		private $slug; 

		

		/**
		 * The parameters to be passed to a template. 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      array 
		 */
		private $params = []; 

		

		/**
		 * Whether or not the output should be html or plain text. Default is html.
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      bool   
		 */
		private $html = true; 

		

		/**
		 * 
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
		 * (description)
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */
		public function go() {

			//Build notification
			$this->builder = new $slug(); 
			$content = $this->builder->build( $this->params ); 
			
			//Send the email
			if( $this->builder->do_email() )
				$this->sender
		}	

		
		
		/**
		 * Sets the receiver of the notice by their ID. 
		 *
		 * @since     1.0.0
		 * @param     bool $receiver_id
		 * @return    void
		 */
		private function set_receiver( $receiver_id )
		{
			$this->receiver_id = $receiver_id;
			
		}
		
		
		
		/**
		 * Sets the sender of the notice by their ID. 
		 *
		 * @since     1.0.0
		 * @param     bool $sender_id
		 * @return    void
		 */
		private function set_sender( $sender_id = 0 )
		{
			$this->sender_id = $sender_id;
			
		}
		
		
		
		/**
		 * Sets the slug by which template classes are called. 
		 *
		 * @since     1.0.0
		 * @param     string $slug
		 * @return    void
		 */
		private function set_slug( $slug )
		{
			$this->slug = $slug;

			
		}
		
		
		
		/**
		 * Array of parameters that are available for the given notificaiton
		 *
		 * @since     1.0.0
		 * @param     array $params
		 * @return    void
		 */
		private function set_params( $params )
		{
			$this->params = $params; 
			
		}
		
		
		
		/**
		 * Sets whether HTML is true or false. 
		 *
		 * @since     1.0.0
		 * @param     $html
		 * @return    void
		 */
		private function set_html( $html )
		{
			$this->html = $html; 
			
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