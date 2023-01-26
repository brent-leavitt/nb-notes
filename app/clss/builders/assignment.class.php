<?php 

Namespace Nb_Notes\App\Clss\Builders;
//use ; 


/**
 * This is the abstract builder class for building content to be sent in notices. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Builder/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Assignment' ) ){ 
	class Assignment extends Builder { 

		//Props

		/**
		 * Parent Class has: 
		 *	
		 * private $content; //string
		 * private $subject; //string
		 * private $is_email = true; //bool
		 * 
		 * 
		 */
		
		
		
		
		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type) (description)
		 */
		//private $; 
		
		

		
		//Methods


		/**
		 * Parent Class has: 
		 *	
		 * public __construct() 	//(empty)
		 * public init() 			//(empty)
		 * private set_() 			//(empty)
		 * private get_() 			//(empty)
		 * public get_subject() 	//(string)
		 * public get_content() 	//(string)
		 * public is_email() 		//(bool)
		 */


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
		public function init() {

			
		
		}	

						
		/**
		 * Builds out the parameters required for this type of email.
		 *
		 * @since     1.0.0
		 * @param     array 	$params 	
		 * @return    (type)    (description)
		 */	 
		public function build( array $params )
		{
			//incoming parameters
			/*
				- template content
				- template subject
				- assignment id
			*/

			//process incoming content, run shortcodes on it, then assign to content property. 
			$this->content = $params[ 'content' ]; //do_shortcode( $params[ 'content' ] ); //I don't think this works.  

			//call and append the assignment receipt.
			$this->content .= $this->add_receipt( $params[ 'args' ][ 'asmt_id' ] );

			//assign incoming subject to subject property. 
			$this->subject = $params[ 'subject' ]; 
			
			//Finalize the notification to be sent. 
			$this->finalize(); 

		}
		
		
		/**
		 * Appends an assignment receipt to the content being generated. 
		 *
		 * @since     1.0.0
		 * @param     int 	$asmt_id
		 * @return    (type)    (description)
		 */
		private function add_receipt( int $asmt_id )
		{
			$asmt = get_post( $asmt_id );
			
			$course_id = $asmt->post_parent; //
				
			$asmt_url = home_url('/?p=').$course_id;

			//build out the receipt
			return "
========================

Assignment Name: {$asmt->post_title}

Assignment: 
{$asmt->post_content}

=======================

Link: {$asmt_url}
Assignment ID: {$asmt->ID}
Student ID: {$asmt->post_author}
Last submitted: {$asmt->post_modified}

=======================";
			
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
		 * Returns the content of the builder
		 *
		 * @since     1.0.0
		 * @return    string
		 */	 
		public function get_content()
		{

			return $this->content ?? ''; 
		
		}


		
		
		/**
		 * Returns the subject of the notification
		 *
		 * @since     1.0.0
		 * @return    string
		 */	 
		public function get_subject()
		{

			return $this->subject ?? ''; 
		
		}


		
		
		/**
		 * Returns whether or not this notification is an email
		 *
		 * @since     1.0.0
		 * @return    bool
		 */	 
		public function is_email()
		{

			return $this->is_email; 
		
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