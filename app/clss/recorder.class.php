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
		private $headers; 

		/**
		 * sender ID
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $attach; 
		
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
		private $active = 1; 
		
		
		

		
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

			$this->date = date("Y-m-d H:i:s");

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
			if( property_exists( $this, $key )  )
				$this->$key = $item; 
		}
		



		/**
		 * commit message in database for later use
		 *
		 * 	id mediumint(9) NOT NULL AUTO_INCREMENT,
		 * 	note_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		 * 	note_type tinytext NOT NULL,
		 * 	note_subject tinytext NOT NULL,
		 * 	note_content text NOT NULL,
		 * 	note_recipient int NOT NULL,
		 * 	note_headers text NULL,
		 * 	note_attach text NULL,
		 * 	note_status tinytext NOT NULL,
		 * 	note_active bit(1) DEFAULT 0 NOT NULL,
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 **/
			
		private function commit(){
			global $wpdb;
			
			$inserted = $wpdb->insert( 
				'nb_notes', 
				array( 
					'note_date' => $this->date, 
					'note_type' => $this->type, 
					'note_subject' => $this->subject, 
					'note_content' => $this->content, 
					'note_recipient' => $this->receiver, 
					'note_headers' => $this->headers, 
					'note_attach' => $this->attach, 
					'note_status' => $this->status, 
					'note_active' => $this->active
				), 
				array( 
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%s',
					'%s',
					'%s',
					'%d'
				) 
			);

			return ( !empty( $inserted ) ) ? $wpdb->insert_id : 0 ;
		}


		/**
		 * Make a database record of the message being sent. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 **/	

		public function record( $package, $sent ){

			error_log( __METHOD__ . ": " . __LINE__ . ' We are going to record this in the database : ' . var_export( $this, true ) );
			$this->init( $package );
			$this->mark_status( $sent );			
			$inserted_id = $this->commit();	
			
			if( $inserted_id === 0 )
				error_log( 'Failed to insert the note in the database for: ' . var_export( $this, true ) ); 
		}



		/**
		 * Updates the status of the message if already recorded in database. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 **/	

		public function mark_status( $status ){
			
			if( strcmp( $status, $this->status ) !== 0 && !empty( $status ) ){
				$this->status = $status;
				
				/* if(  $this->ID !===  ){
					
				} */
				
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