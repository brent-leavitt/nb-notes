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
		private $__; 

		

		
		//Then Methods

		/**
		 * (description)
		 *
		 * @since     1.0.0
		 * @param     int 		$receiver_id 	//Who is receiving the notificaiton
		 * @param     int 		$sender_id 		//Who is sending the notificaiton
		 * @param     string 	$slug 			//the type of notification
		 * @param     array 	$params 		//
		 * @param     bool	 	$html 			//html or plain text
		 * @return    void
		 */
		public function __construct(  $receiver_id, $sender_id, $slug, $params, $html  ){
			
			$this->set_receiver( $receiver_id );
			$this->set_sender( $sender_id );
			$this->set_slug( $slug );
			$this->set_params( $params ); 
			$this->set_html( $html ); 
				
			$this->init(); 
			
		}
		
		
		/**
		 * Setup our classes that we need to control
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		private function init() {

			//Build notification
			$this->builder 		= new $slug(); 
			$this->sender 		= new Sender(); 
			$this->recorder 	= new Recorder(); 
			$this->admin_noter 	= new Admin_Noter(); 
			
		}	


		/**
		 * Makes the magic happen. This is called externally
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		public function go() {

			//prepare the package to be sent
			$package = $this->prepare(); 
			
			//Send the email
			$sent = ( $this->builder->do_email() )? 
					$this->sender->send($package, $this->html ):
					false;
			
			//make a record of our actions.
			$this->recorder->record( $package, $sent ); 

			//Add Admin_Note meta data to student file (if applicable)
			if( method_exists( $this->builder->get_admin_note() ) &&
				( $admin_note =  $this->builder->get_admin_note() ) )
				$this->admin_noter->add_note( $this->receiver_id, $this->sender_id, $admin_note ); 
		}	

		
		/**
		 * Prepares notification content. 
		 *
		 * @since     1.0.0
		 * @return    array
		 */
		private function prepare(   )
		{
			$this->builder->build( $this->params );

			return array(
				'receiver' 	=>	$this->receiver_id, 
				'sender' 	=>	$this->sender_id, 
				'subject' 	=>	$this->builder->get_subject(),
				'content'	=>	$this->builder->get_content()
			); 
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