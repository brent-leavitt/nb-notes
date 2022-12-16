<?php 

Namespace Nb_Notes\App\Clss\Triggers;
//use ; 


/**
 * This is the base class for trigger objects for all things that they share in common. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Triggers/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'Trigger' ) ){ 
	abstract class Trigger implements Trigger_Interface { 

		/**
		 * Who is this email being sent to?
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      int    
		 */
		protected $receiver_id; 
		
		
		/**
		 * Who is sending the email? 
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      int 
		 */
		protected $sender_id; 
		
		
		/**
		 * Slug of the builder name
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      string
		 */
		protected $builder; 
		
		
		/**
		 * Availale parameters or arguments for this notification
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      array
		 */
		protected $args; 
		
		
		
		/**
		 * The IDs of the notification CPT templates created by an admin_user and stored in options table. 
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      array
		 */
		protected $templates; 
		
		

		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   protected 
		 * @var      (type)    $name   (description)
		 */
		protected $; 
		
		

		
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
		 * The final action to be taken by any trigger 
		 *
		 * @since     1.0.0
		 * @param     string 	$builder
		 * @param     array 	$params
		 * @param     bool 		$html
		 * @return    void
		 */	 

		protected function send( $builder, $params, $html )
		{
			$sender_id = 0; //system generated 
			$sent = notifiy( $this->receiver_id, $sender_id, $builder, $params, $html ); 
			//Could process this further to back up or make more redundant.
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
		 * Loads the IDs for all Notification templates for this particular trigger
		 *
		 * @since     1.0.0
		 * @return    void
		 */
		protected function get_templates_ids(){
			
			$templates  = get_option( 'nb_notes_templates' ); 

			//sets the array of notification CPT ids, if there be any set.  
			if( isset(  $templates[ $this::TRIGGER ] ) )
				$this->templates =  $templates[ $this::TRIGGER ];
	
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