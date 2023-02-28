<?php 

Namespace Nb_Notes\App\Clss;
 


/**
 * Controls the different classes that handle notificaiton processes.
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Director' ) ){ 
	class Director { 

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
		 * the result of our actions. 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      bool
		 */
		private $result = false; 

		

		
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

		public function __construct(  $receiver_id, $sender_id, $slug, $params, $html )
		{			
			$this->set( 'receiver_id', $receiver_id );
			$this->set( 'sender_id', $sender_id );
			$this->set( 'slug', $slug );
			$this->set( 'params', $params ); 
			$this->set( 'html', $html ); 
				
			$this->init(); 
			
		}
		

		/**
		 * set properties
		 *
		 * @since     1.0.0
		 * @param     string $name
		 * @param     mixed $val
		 * @return    void 
		 */	 
		public function set( $name, $val)
		{
			$this->$name = $val; 
		}


		/**
		 * Setup our classes that we need to control
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		private function init() {
			
			//Build notification
			$builder_slug = '\Nb_Notes\App\Clss\Builders\\'. ucfirst( $this->slug );
			//error_log( "The builder slug is {$builder_slug}." ); 
			
			$this->builder = ( class_exists( $builder_slug ) ) ? new $builder_slug : new builders\Generic();			
			//error_log( "The set builder property is ".var_export( $this->builder, true ) ); 

			//if notification requires email.		
			if( $this->builder->is_email() )  
				$this->sender = new Sender(); 

			//Setup notification recorder. 
			$this->recorder = new Recorder(); 
			
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
			$sent = ( $this->builder->is_email() )? 
					$this->sender->send( $package, $this->html ):
					'failed';
			

			//Add headers and attachments to the package. 
			$package += [
				'headers' 	=> $this->sender->get_headers(),
				'attach' 	=> $this->sender->get_attach()
			];
			//make a record of our actions.
			$this->recorder->record( $package, $sent ); 

			//Add Admin_Note meta data to student file (if applicable)
			$user = get_user_by( 'id', $this->receiver_id ); 
			
			if ( in_array( 'student', (array) $user->roles ) ) 
			{
				if( method_exists( $this->builder, 'get_admin_note' ) &&
					( $admin_note =  $this->builder->get_admin_note() ) )
					{
						if( !empty( $admin_note ) )
							$this->recorder->add_admin_note( $this->receiver_id, $admin_note ); 
					}
			}

			
				
			
			$this->set( 'result', $sent ); 
		}	

		
		/**
		 * Prepares notification content. 
		 *
		 * @since     1.0.0
		 * @return    array
		 */
		private function prepare(   )
		{
			$this->builder->build( $this->params, $this->html );

			return array(
				'type' 		=>	$this->builder->is_email()? 'email' : 'system' , //this logic is not recorded anywhere else. 
				'receiver' 	=>	$this->receiver_id, 
				'sender' 	=>	$this->sender_id, 
				'subject' 	=>	$this->builder->get_subject(),
				'content'	=>	$this->builder->get_content() 
			); 
		}
		
	

				
		/**
		 * Get the result of the action taken. 
		 *
		 * @since     1.0.0
		 * @return    bool
		 */
		public function get_result(){
		
			return $this->result; 			
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