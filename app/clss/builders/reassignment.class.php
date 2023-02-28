<?php 

Namespace Nb_Notes\App\Clss\Builders;
//use ; 


/**
 * This is the builder for trainer reassignment emails. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Builders/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Reassignment' ) ){ 
	class Reassignment extends Builder { 

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
		 * Old Trainer
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      object 
		 */
		private $old_trainer; 
				
		
		/**
		 * New Trainer
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      object
		 */
		private $new_trainer; 
		
		
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
		 * (description)
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */
		public function __construct(  ){
				
				
				
		}
				
		/**
		 * Builds emails for trainer reassignments. Both student and trainer notifications. 
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

			//Add Trainers
			$this->add_trainers(); 

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
			
			 $student_id =  $args[ 'student' ]; 
			 $student = get_user_by( 'id', $args[ 'student' ] ); 
			 $student_profile = home_url('/wp-admin/admin.php?page=edit_student&student_id=') . $student_id;
					
			 $old_trainer = $this->old_trainer;
			 $new_trainer = $this->new_trainer;

			 $receipt ="
			 ========================
			 
			 Student Name: {$student->first_name} {$student->last_name}
			 Student ID: {$student_id}
			 Student Profile: {$student_profile}

			 ------------------------

			 Old Trainer: {$old_trainer->first_name} {$old_trainer->last_name}
			 New Trainer: {$new_trainer->first_name} {$new_trainer->last_name}


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
			$old_trainer = $this->old_trainer;
			$new_trainer = $this->new_trainer;
			
			$hr = '<hr style="border: #e5e5e5 1px solid;" >';
			
			$receipt ="
			{$hr}
			<ul>
				 <li><b>Old Trainer:</b> {$old_trainer->first_name} {$old_trainer->last_name}</li>
				 <li><b>New Trainer:</b> {$new_trainer->first_name} {$new_trainer->last_name} ({$new_trainer->user_email})</li>
			</ul>"; 
			 
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
			$old_trainer = $this->old_trainer;
			$new_trainer = $this->new_trainer;

			$this->admin_note = "The trainer has been reassigned. The previous trainer was {$old_trainer->first_name} {$old_trainer->last_name}, and the new trainer is {$new_trainer->first_name} {$new_trainer->last_name}. All three parties have been notified."; 
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
		 * Load old and new trainer object to their respective properties. 
		 *
		 * @since     1.0.0
		 * @return    NULL
		 */	 
		private function add_trainers()
		{

			$args = $this->args;

			$this->old_trainer = get_user_by( 'id', $args[ 'trainers' ][ 'old_trainer' ] );
			$this->new_trainer = get_user_by( 'id', $args[ 'trainers' ][ 'new_trainer' ] );
		
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