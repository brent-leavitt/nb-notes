<?php 

Namespace Nb_Notes\App\Clss\Builder;
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
 
 
if( !class_exists( 'Builder' ) ){ 
	class Builder implements Builder_Interface { 

		//Props

		/**
		 * The body of the notification to be sent. 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      string
		 */
		private $content; 
		
		
		/**
		 * The title of the notification to be sent.
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      string
		 */
		private $subject; 
		
		
		/**
		 * Whether or not this notification requires an email to be sent. 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $is_email = true; 
		
		
		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type)    $name   (description)
		 */
		private $; 
		
		

		
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