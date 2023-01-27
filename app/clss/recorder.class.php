<?php 

Namespace Nb_Notes\App\Clss;
//use ; 


/**
 * This class should handle database communication with the plugin,
 * Right now it functions as more of class for the message type recorded in the database. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Recorder' ) ){ 
	class Recorder { 		

		/**
		 * date of the message being recorded
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $date; 
		
		/**
		 * what type of message is being recorded (generally its an email)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $type; 
		
		/**
		 * subject of the note
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $subject = ''; 
				
		/**
		 * content of the note
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $content; 
		
		/**
		 * receiver ID
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $receiver; 

		/**
		 * sender ID
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $sender = 0; 
		
		/**
		 * Status of the note being recorded. Sent, pending, unsent. 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $status = 'unsent'; 
		
		/**
		 * Whether or not this Note is active on the site. 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $active = true; 
		
		
		

		
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
		 * sets up the class with the 
		 *	
		 *	$pacakge = array(
		 *		'receiver' 	=>	$this->receiver_id, 
		 *		'sender' 	=>	$this->sender_id, 
		 * 		'subject' 	=>	$this->builder->get_subject(),
		 *		'content'	=>	$this->builder->get_content(),
		 *		//Could add an array of attachment links here.  
		 *	); 
		 *	
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */

		private function init( $package ) {

			foreach( $package as $key => $item )
				$this->set( $key, $item );		

		}	


		
		/**
		 * Set the values for predefined properties. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */

		private function set( $key, $item )
		{
			
			
		}
		



		/**
		 * commit message in database for later use
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 **/
			
		private function commit(){
			global $wpdb;
			
			$inserted = $wpdb->insert( 
				'messages', 
				array( 
					'message_date' => $this->date, 
					'message_type' => $this->type, 
					'message_content' => $this->content, 
					'message_recipient' => $this->recipient, 
					'message_status' => $this->status, 
					'message_active' => $this->active
				), 
				array( 
					'%s',
					'%s',
					'%s',
					'%d',
					'%s',
					'%s'
				) 
			);
			
			if( !empty( $inserted ) )
				$this->ID = $wpdb->insert_id;
				
		}


		/**
		 * Make a database record of the message being sent. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 **/	

		public function record( $package, $sent ){

			$this->init( $package );
			$this->set_status( $sent );
			
			
			//add subject line to the beginning of the message. 
			$this->content = "Subject: ". $this->subject ."
		=================================
		". $this->content;
			
			$this->commit();	
			$this->archived = ( !empty( $this->ID ) )? true : false ; 

		}



		/**
		 * Updates the status of the message if already recorded in database. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 **/	

		public function mark_status( $status ){
			
			if( strcmp( $status, $this->status ) !== 0 ){
				$this->status = $status;
				
				if( !empty( $this->ID ) ){
					
				}
				
			} 
			//check if message is recorded in databse. 
			
			//check status of message in database. 
			
			//check if status is not the same as $status

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