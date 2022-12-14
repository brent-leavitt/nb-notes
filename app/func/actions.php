<?php 
Namespace Nb_Notes\App\Func;
//use ; 

/**
 * (description here)
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 


/**
 * fires a notification to be processed
 *
 * @since     1.0.0
 * @param     bool    $receiver_id     //who receives the notification
 * @param     int     $sender_id      //who sends the notificaiton
 * @param     string  $slug         //tempalte slug
 * @param     array   $params        //all available variables to be included with this notificaiton
 * @param     bool    $html           //
 * @return    bool    (description)
 */

function nb_notifiy( int $receiver_id, int $sender_id, string $slug, array $params, bool $html = true ):bool
{

    $control =  new Controller(); 
    $control->set_receiver( $receiver_id );
    $control->set_sender( $sender_id );
    $control->set_slug( $slug );
    $control->set_params( $params ); 
    $control->set_html( $html ); 
    $control->go();  

    return $control->get_result();  
}



?>