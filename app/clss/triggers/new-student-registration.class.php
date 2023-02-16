<?php 

Namespace Nb_Notes\App\Clss\Triggers;
use function Nb_Notes\App\Func\notify; 


/**
 * Difference between this trigger and the 'trainer-new-student' trigger is in the data that they receive from the action hook. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/Triggers
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
if( !class_exists( 'New_Student_Registration' ) ){ 
	class New_Student_Registration extends Trigger { 

		/**
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      const    $name   (description)
		 */
		protected const TRIGGER = 'New_Student_Registration'; 
		
		
		//Then Methods

	
		/**
		 * Listening for 
		 *
		 * @since     1.0.0
		 * @param     $view
		 * @return    (type)    (description)
		 */	 
		public function listen()
		{

			add_action( 'nb_new_student_registration', [ $this, 'init' ], 10, 2 ); 
			
		}
			
		
		/**
		 * Initializes and executes the action hook //NEEDS WORK BECAUSE IT NEEDS TO LISTEN TO THE INCOMING PARAMATERS. 
		 *
		 * @since     1.0.0
		 * @param     array ...$args // params: $membership_id, $data (data from rcp_membership_post_activate hook from Restricted Content Pro)
		 * @return    void
		 */

		 public function init( ...$args ) {

			//This is where the incoming parameter data is received. 
			error_log( "The ". __FILE__ ."::". __METHOD__ ." has been called. Here are the paramaters being passed. ". var_export( $args, true ) );
			//This trigger may be impossible to test locally as we need a sandbox gateway to work for us first, and the action 
			//hook associated with this only gets called with system initiates the action, I don't believe it can be manually triggered.
			
			/*  REFERENCE
			
			RCP_Membership::__set_state(array(
				'id' => '44',
				'customer_id' => '12',
				'user_id' => '31',
				'customer' => NULL,
				'member' => NULL,
				'object_id' => '1',
				'object_type' => 'membership',
				'currency' => 'USD',
				'initial_amount' => '25',
				'recurring_amount' => '25',
				'created_date' => '2023-02-16 00:00:00',
				'activated_date' => '2023-02-16 00:00:00',
				'trial_end_date' => NULL,
				'renewed_date' => NULL,
				'cancellation_date' => NULL,
				'expiration_date' => '2023-03-16 23:59:59',
				'payment_plan_completed_date' => NULL,
				'times_billed' => '0',
				'maximum_renewals' => '0',
				'status' => 'active',
				'auto_renew' => '0',
				'gateway_customer_id' => '',
				'gateway_subscription_id' => '',
				'gateway' => 'manual',
				'signup_method' => 'manual',
				'subscription_key' => '',
				'notes' => 'February 16, 2023 18:43:21 - Membership activated.',
				'upgraded_from' => '0',
				'date_modified' => '2023-02-16 18:43:21',
				'disabled' => '0',
				'uuid' => 'urn:uuid:0116e115-2a90-45fa-a1c6-6a6955a9cc3b',
			 )), */


			//Define target_id and submitter_id 
			//Needs to be extracted from membership
		/*	$this->target_id = $args[ 1 ]->user_id; //Student_ID //NEEDS TO BE TESTED. 

			//The membership data is being passed to the builder from this trigger. 
			$this->args[ 'membership' ] = $args[ 1 ];

			//The source of a new membership triggers will always be the system.  
			$this->source = 'system'; //otherwise assume that it is an adminstrator who is commenting. 

			//pull the trigger. 
			$this->build();  */
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