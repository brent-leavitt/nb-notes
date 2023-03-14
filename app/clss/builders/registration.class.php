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
 
 
if( !class_exists( 'Registration' ) ){ 
	class Registration extends Builder { 

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
		 * Appends a registration receipt to the content being generated. 
		 * This should only be generating HTML emails right now. Not Plain Text. 
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
		 * //NOT ACTIVE// Build Plain Text Receipt, that will be sent to admin/trainers etc. 
		 *
		 * @since     1.0.0
		 * @return    string 
		 */	 

		 private function build_plain_receipt( ): string
		 {
 
			 $args = $this->args;
			
			

			 $receipt ="
			 ========================
			 
		

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
			$args = $this->args;
		
			
			$hr = '<hr style="border: #e5e5e5 1px solid;" >';
			$a_class = 'style="color:#AC1B5C;"';

			$receipt ="
			{$hr}
			
			<h2>What Are My Next Steps?</h2>
			
			<ol>
				<li>Meet your trainer/schedule a coachng call</li>
				<li>Order your books</li>
				<li>Start your training</li>
			</ol>
			<p>Each step is further detailed below.</p>
			{$hr}
			<h3>Meet Your Trainer/Schedule a Coaching Call</h3>
			<p>Shortly, you will be receiving an email that will introduce your doula trainer. These are real human beings with real lives! (No robots) Within the first week of starting your training, your doula trainer will reach out to you to setup a coaching call. This coaching call is the perfect time to ask questions about your goals and objectives in training to become a doula, ask questions about course specifics and to get to know your trainer better! </p>
			<h3>Order Your Books</h3>
			<p>As you are getting started with your training, you will need to order the required texts for your specific program. These books can be found in the introductory material for your course of study. They can typically be obtained from popular online book sellers in print or digital format. We recommend securing your own personal copy, though you may also find copies at a local library. <a {$a_class} href='https://www.trainingdoulas.com/books/'>View Required Books.</a></p>
			<h3>Start Your Training</h3>
			<p>Access to your training materials starts immediately upon receipt of payment for a course subscription. You are free to start your training immediately, reading course materials and submitting assignments as soon as you are able to complete all requirements (books may be required to complete a given assignment). Though we recommend you progress through the training chronologically, you are free to proceed in any order that works best for you. You can submit multiple assignments at once, before a trainer has graded any given assignment. For more details on course-related questions, <a {$a_class} href='https://www.trainingdoulas.com/questions-about-becoming-a-doula-faq/'>visit the FAQ page.</a></p>



			"; 
			
			//$receipt .= "<p>This is the membership user ID: {$this->args['membership']->get_user_id()}.</p>"; 
			//$receipt .= var_export( $this->args[ 'membership' ], true ); 
			

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

			$this->admin_note = ''; 
		
		}
		
		/**
		 * Retrieves the admin note that has been built to be sent to the student's admin_notes file. 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		
		public function get_admin_note()
		{

			return $this->admin_note;
		
		} */	 
		
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