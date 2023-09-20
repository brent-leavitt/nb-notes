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
		private $receiver_email; 
		
	
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
		 * headers
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      array //array of email headers, including the "from:" line. 
		 */
		private $headers = []; 
		
		
	
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
				
				add_action( 'wp_mail_failed', array( $this, 'failed' ), 10, 1 );
				
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
			return ( $prepared )? $this->do_send() : 'not prepared'; 
			
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
			
			//Set receiver email

			$this->receiver_email	= $this->get_email( $package[ 'receiver' ] ); 
			$this->sender_email 	= $this->get_email( $package[ 'sender' ], true ); 
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
			$this->headers[] = ( !empty( $this->sender_email ) )? 'From:'.$this->sender_email : ''; 
		
			//Do a little more work if we are sending an HTML formatted email. 
			if( strcmp( $this->format, 'html' ) === 0 )
			{
				include( NB_NOTES_PATH. 'app/tmpl/email/html_wrapper1.php' ); 
				$this->content = $nb_html_header . $this->content . $nb_html_footer;

				$this->headers[] = 'Content-Type: text/html; charset=UTF-8'; 
			}

			//error_log( 'email is prepared: '. var_export( $this, true ) ); 

			//If no errors, let them know we're ready!
			return true; 
		}
			

		
		
		/**
		 * Hooking into WordPress mailer functionality. Logs error on failed send. 
		 *
		 * @since     1.0.0
		 * @return    string //returns a string response that gets recorded in the database. 
		 */	 
		private function do_send()
		{
			//error_log( "Inside the DO_SEND function, are headers set?  ". var_export( $this->headers, true ) ); 
			
			$sent = wp_mail( $this->receiver_email, 
							$this->subject, 
							$this->content, 
							$this->headers, 
							$this->attach ); 	

			//error_log( "The DO_SEND function was called and the status of sent is: {$sent}." ); 				

			return ( $sent )? 'sent' : 'failed'; 
		
		}
		
		
		/**
		 * Gets the user's email address from the user ID
		 *
		 * @since     1.0.0
		 * @param     int $user_id
		 * @return    MIXED $email or false 
		 */	 
		private function get_email(int $user_id, bool $is_sender = false )
		{	
			$email = '';
			
			//If the User_ID is something other than zero, 
			//we are either going to find the email address 
			//or declare false because the email	is not found.
			if( $user_id !== 0 )
			{
				$user = get_user_by( 'id', $user_id );
				$email = ( $user ) ? $user->user_email : false;
			}		
			
			//If the email is set, send it home. 
			if( !empty( $email ) )
				return $email; 				

			//However, if email is false but this is not a sender. We need to send a false return. 
			if( $email === false && $is_sender === false )
				return false;

			//if we're still going we're going to assume that we're looking for a sender and we haven't found one yet. 
			//return either the plugin specified system email address, or the website's default admin email address. 
			$email = get_option( 'nb_notes_system_email' ); 
			return ( !empty( $email ) )? $email : get_option( 'admin_email' ); 
			
		}
	
		/**
		 * If WordPress Fails to send email, record the response to the error log. 
		 *
		 * @since     1.0.0
		 * @param     object $WP_Error
		 * @return    (type)    (description)
		 */	 
		public function failed( $error )
		{

			error_log( 'Wordpress failed to send the email. Here are the details: '. var_export( $error, true ) ); 
		
		}
	
		/**
		 * get the headers for recording in the database. 
		 *
		 * @since     1.0.0
		 * @return    array   The array of headers prepared to be sent out with the email
		 */	 
		public function get_headers()
		{

			return $this->headers;
		
		}	
		/**
		 * get the attachements for recording in the databse. 
		 *
		 * @since     1.0.0
		 * @return    array 	The array of attachments prepared to be sent out with the email.
		 */	 
		public function get_attach()
		{

			return $this->attach; 
		
		}



	}

}
?>