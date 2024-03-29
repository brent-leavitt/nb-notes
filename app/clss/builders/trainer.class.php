<?php 

Namespace Nb_Notes\App\Clss\Builders;
//use ; 


/**
 * This is the default class for builders. This will be loaded if no other builder is set. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Builders/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Trainer' ) ){ 
	class Trainer extends Builder { 

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
		 * Incoming args use to build the receipt
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      array 
		 */
		private $args; 
		
		
		/**
		 * Trainer 
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      object 
		 */
		private $trainer; 
		
		
		/**
		 * Admin Note 
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      string
		 */
		protected $admin_note = ''; 
		
		
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
		 * Builds out the parameters required for this type of email.
		 *
		 * @since     1.0.0
		 * @param     array 	$params 	
		 * @param     bool 	$html 	//default is false
		 * @return    (type)    (description)
		 */	 
		public function build( array $params, bool $html = false )
		{
		
			//What parameters are being sent to the builder? 
			$this->args = $params[ 'args' ];

			//process incoming content, run shortcodes on it, then assign to content property. 
			$this->content = $params[ 'content' ]; //do_shortcode( $params[ 'content' ] ); //I don't think this works.  

			//set the trainer object
			$this->trainer = get_user_by( 'id', $this->args[ 'trainer_id' ] );

			//call and append the assignment receipt.
			$this->content .= $this->add_receipt( $html );

			//assign incoming subject to subject property. 
			$this->subject = $params[ 'subject' ]; 

			//Build an admin_note. 
			$this->build_admin_note(); 
			
			//Finalize the notification to be sent. 
			$this->finalize(); 
	
		}
		
		
		/**
		 * Appends a reassignment receipt to the content being generated. 
		 *
		 * @since     1.0.0
		 * @param     bool	 	$html
		 * @return    (type)    (description)
		 */
		private function add_receipt( bool $html )
		{
			//build out the receipt
			return ( $html )? $this->build_html_receipt() : $this->build_plain_receipt() ; 
			
		}
		
		/**
		 * Build Plain Text Receipt, that will be sent to admin/trainers etc. 
		 *
		 * @since     1.0.0
		 * @return    string 
		 */	 

		 private function build_plain_receipt( ): string
		 {
 
			 $args = $this->args;
			
			 $student_id =  $args[ 'student_id' ]; 
			 $student = get_user_by( 'id', $student_id ); 
			 $student_profile = home_url( '/wp-admin/admin.php?page=edit_student&student_id=' ) . $student_id;

			 $receipt ="
			 ========================
			 
			 Student Name: {$student->first_name} {$student->last_name}
			 Student ID: {$student_id}
			 Student Profile: {$student_profile}

			 ======================="; 
			 
			 return $receipt; 
		 }
		 
		 
		 /**
		  * Build HTML Receipt
		  *
		  * @since     1.0.0
		  * @return    string 
		  */	 
		 
		 private function build_html_receipt(): string
		 {
			
			$trainer = $this->trainer;
			
			$hr = '<hr style="border: #e5e5e5 1px solid;" >';
			
			$receipt ="
			{$hr}
			<p><b>Trainer:</b> {$trainer->first_name} {$trainer->last_name}</p>
			<p><b>Email:</b> {$trainer->user_email}</p> 
			<p><b>About:</b> {$trainer->description}</p>
			"; 
			
			return $receipt; 
		 }

				
		/**
		 * Builds the admin note to be recorded the student's file. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */	 

		protected function build_admin_note()
		{

			$trainer = $this->trainer;

			$this->admin_note = "{$trainer->first_name} {$trainer->last_name} has been assigned as trainer. A notice has been issued to both trainer and student."; 
		
		}
		

		/**
		 * Retrieves the admin note that has been built to be sent to the student's admin_notes file. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */	

		public function get_admin_note()
		{

			return $this->admin_note;
		
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