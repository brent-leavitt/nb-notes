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
		 * (description)
		 *
		 * @since    1.0.0
		 * @access   private 
		 * @var      (type) (description)
		 */
		private $_; 
		
		

		
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
		 * Builds out the parameters required for this type of email.
		 *
		 * @since     1.0.0
		 * @param     array 	$params 	
		 * @param     bool 	$html 	//default is false
		 * @return    (type)    (description)
		 */	 
		public function build( array $params, bool $html = false )
		{
		
			//process incoming content, run shortcodes on it, then assign to content property. 
			$this->content = $params[ 'content' ]; //do_shortcode( $params[ 'content' ] ); //I don't think this works.  

			//call and append the assignment receipt.
			$this->content .= $this->add_receipt( $params[ 'args' ][ 'asmt_id' ], $html );

			//assign incoming subject to subject property. 
			$this->subject = $params[ 'subject' ]; 
			
			//Finalize the notification to be sent. 
			$this->finalize(); 
	
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