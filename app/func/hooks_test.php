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

add_action( 'nb_assignment_submitted', function( $a, $b ){
    //error_log( 'Called from nb_assignment_submitted hook in: ' .__FILE__  ); 
}, 10, 2 ); 

add_action( 'nb_assignment_resubmitted', function( $a, $b ){
    //error_log( 'Called from nb_assignment_resubmitted hook in: ' .__FILE__ ); 
}, 10, 2 ); 

add_action( 'nb_assignment_completed', function( $a, $b ){
    //error_log( 'Called from nb_assignment_completed hook in: ' .__FILE__ ); 
}, 10, 2 ); 

add_action( 'nb_assignment_incomplete', function( $a, $b ){
   // error_log( 'Called from nb_assignment_incomplete hook in: ' .__FILE__ ); 
}, 10, 2 ); 

//Listening for Trainer Reassignment
add_action( 'nb_trainer_reassignment', function( $a, $b, $c, $d ){
   // error_log( 'nb_trainer_reassignment hook has been called in: ' .__FILE__ ); 
    //error_log( sprintf( "The values being passed by the hook are as follows. A: %d, B: %d, C: %d ", $a, $b, $c ). var_export( $d, true ) ); 
}, 10, 4 ); 


//Listening for New Trainer Assignment
add_action( 'nb_trainer_new_student', function( $a, $b ){
    error_log( sprintf( "The values for NB_TRAINER_NEW_STUDENT hook are as follows. A: %d, B: %d", $a, $b ) ); 
}, 10, 2 ); 

//Listening for New Student Comment
add_action( 'nb_new_student_comment', function( $a, $b, $c ){
    //error_log(  sprintf( "The values for nb_new_student_comment hook are as follows. A: %d, B: %d, C: %s", $a, $b, var_export( $c, true ) )  ); 
}, 10, 3 ); 

//Listening for New Trainer Comment
add_action( 'nb_new_trainer_comment', function( $a, $b, $c, $d ){
    //error_log(  sprintf( "The values for nb_new_trainer_comment hook are as follows. A: %d, B: %d, C: %d, D: %s", $a, $b, $c, var_export( $d, true ) )  ); 
}, 10, 4 ); 

//Listening for New Student Registration
add_action( 'nb_new_student_registration', function( $a, $b ){
    error_log( sprintf( "Called from nb_new_student_registration hook are as follows. A: %d, B: %s", $a, var_export( $b, true ) ) ); 
}, 10, 2 ); 
?>