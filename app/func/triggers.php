<?php 

Namespace Nb_Notes\App\Func;
use Nb_Notes\App\Clss\Trigger; 


/**
 * Triggers to be used throughout the NB_Notes Plugin
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

//SETUP TRIGGERS
$nb_triggers = [
    'Assignment_Submitted',
    'Assignment_Resubmitted',
    'Assignment_Incomplete',
    'Assignment_Graded',
    'Trainer_New_Student',
    'Trainer_Reassignment',
    'New_Student_comment',
    'New_Trainer_Comment',
    'New_Student_Registration',
    'New_Student_Verification',
    'Password_Reset', 
    'Certification_Complete',
    'Certification_Pending',
    'Certification_Issued',
    'Certification_Renewal_Started',
    'Certification_Renewal_Pending',
    'Certification_Renewal_Complete',
    //what else? 
]; 


/**
 * Instantiate each trigger and make it listen. 
 *
 * @since     1.0.0
 * @return    void
 */

function nb_make_triggers_listen( $triggers )
{

        foreach( $triggers as $t )
        {
            $trigger = new $t();
            $trigger->listen(); 
        }
} 


/**
 * At plugin activation, available Nb_Note_Triggers will be stored in the options table for templates to be linked to. 
 *
 * @since     1.0.0
 * @return    void
 */

function nb_activate_triggers(){
    global $nb_triggers; 
  
    if( !get_option( 'nb_notes_trigger_templates' ) )
    {
        //array of triggers set with empty sub-arrays set as a holding bay for indexing of trigger templates (Nb_Notes_Templates CPTs)
        $base_triggers_array = []; 
        foreach( $nb_triggers as $trigger )
            $base_triggers_array[ $trigger ] = []; 

        add_option( 'nb_notes_trigger_templates', $base_triggers_array ); 
    }

}

add_action( 'nb_notes_activate', 'Nb_Notes\App\Func\nb_activate_triggers' ); 

?>