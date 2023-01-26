<?php 

Namespace Nb_Notes\App\Clss\Builders;
//use ; 


/**
 * This is the abstract builder class for building content to be sent in notices. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Builders/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Builder' ) ){ 
	abstract class Builder implements Builder_Interface { 

		//Props

		/**
		 * The body of the notification to be sent. 
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      string
		 */
		protected $content; 
		
		
		/**
		 * The title of the notification to be sent.
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      string
		 */
		protected $subject; 
		
		
		/**
		 * Whether or not this notification requires an email to be sent. 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		protected $is_email = true; 
		
		
		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $_; 
		
		

		
		//Methods

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
		 * Appends the website name to the end of the subject line. 
		 *
		 * @since     1.0.0
		 * 
		 * @return    VOID
		 */
		protected function finalize()
		{
			error_log( __METHOD__. ' is called.' ); 
			//Append Website Name to end of Subject Line
			$this->subject .= ' - '. get_bloginfo( 'name' ); 
			
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