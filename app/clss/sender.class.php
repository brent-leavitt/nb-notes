<?php 

Namespace Nb_Notes\App\Clss;
//use ; 


/**
 * This holds the responsibility for sending all emails from the NB Notes plugin. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Sender' ) ){ 
	class Sender{ 

		/**
		 * email addresss for who is receiving the email
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      string    
		 */
		private $recipient_email; 
		
	
		/**
		 * email address for who is sending the email
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      string 
		 */
		private $sender_email; 
		
	
		/**
		 * Subject of the note being sent.
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      string 
		 */
		private $subject; 
		
	
		/**
		 * Content of the note being sent. 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      string
		 */
		private $content; 
		
	
		/**
		 * HTML or plain text
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      string //html or plain? 
		 */
		private $format; 
		
	
		/**
		 * attachments
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      array //array of file paths for attachments. 
		 */
		private $attach = []; 
		
		

		
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
		 * Publicly accessible email send function for the class. 
		 *
		 * @since     1.0.0
		 * @param     array $package
		 * @param     bool $html
		 * @return    bool //Did we send the email successfullly? 
		 */
		public function send( $package, $html = true ) {

			//Unpack incoming message contents. 
			$this->unpack( $package );
			
			//Is this formatted as HTML or plain text?
			$this->format = ( $html )? 'html' : 'plain';

			//Prepare contents according to format.
			$prepared = $this->prepare(); 

			//Then send the email if contents are prepared. 
			return ( $prepared )? $this->do_send() : false; 
			
		}	

		
		
		/**
		 * Unpack incoming message materials. 
		 *
		 * @since     1.0.0
		 * @param     array $package
		 * @return    void
		 */
		private function unpack( $package )
		{
			
			$this->recipient_email	= $package[ 'recipient_email' ]; 
			$this->sender_email 	= $package[ 'sender_email' ]; 
			$this->subject 			= $package[ 'subject' ]; 
			$this->content 			= $package[ 'content' ]; 
			$this->attach 			= ( !empty( $package[ 'attach' ] ) )? 
											 $package[ 'attach' ] : [];

		}
		
		
		
		/**
		 * Prepares content to be sent, based off of HTML or Plain text parameter. 
		 *
		 * @since     1.0.0
		 * @return    bool
		 */

		private function prepare()
		{
			//Assign From email address if available. 
			$this->headers[] = ( !empty( $this->sender_email ) )? 'From: '.$this->sender_email : ''; 
		
			//Do a little more work if we are sending an HTML formatted email. 
			if( strcmp( $this->format, 'HTML' ) == 0 )
			{
				include( NB_NOTES_PATH. '/app/tmpl/email/html_wrapper.php' ); 
				$this->content = $nb_html_header . $this->content . $nb_html_footer;

				$this->headers[] = 'Content-Type: text/html; charset=UTF-8'; 
			}

			//If no errors, let them know we're ready!
			return true; 
		}
			

		
		
		/**
		 * Hooking into WordPress mailer functionality. 
		 *
		 * @since     1.0.0
		 * @return    bool //returns true or false based on wp_mail response. 
		 */	 
		public function do_send()
		{

			return wp_mail( $this->recipient_email, 
							$this->subject, 
							$this->content, 
							$this->headers, 
							$this->attach ); 
		
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