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
    'ASSIGNMENT_SUBMITTED',
    'ASSIGNMENT_RESUBMITTED',
    'ASSIGNMENT_INCOMPLETE',
    'ASSIGNMENT_GRADED',
    'TRAINER_NEW_STUDENT',
    'TRAINER_REASSIGNMENT',
    'NEW_STUDENT_COMMENT',
    'NEW_TRAINER_COMMENT',
    'NEW_STUDENT_REGISTRATION',
    'NEW_STUDENT_VERIFICATION',
    'PASSWORD_RESET', 
    //what else? 
]; 

function nb_make_triggers_listen( $triggers )
{

        foreach( $triggers as $t )
        {
            $trigger = new $t();
            $trigger->listen(); 
        }
} 

function nb_activate_triggers(){
    global $nb_triggers; 
  
    if( !get_option( 'nb_notes_trigger_templates' ) )
    {
        //array of triggers set with empty arrays set as a holding bay for indexing of trigger templates (Nb_Notes_Templates CPTs)
        $base_triggers_array = []; 
        foreach( $nb_triggers as $trigger )
            $base_triggers_array[ $trigger ] = []; 

        add_option( 'nb_notes_trigger_templates', $base_triggers_array ); 
    }
}

add_action( 'nb_notes_activate', 'Nb_Notes\App\Func\nb_activate_triggers' ); 

?>