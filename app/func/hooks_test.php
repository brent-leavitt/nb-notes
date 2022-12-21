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
    error_log( 'Called from nb_assignment_submitted hook in: ' .__FILE__  ); 
}, 10, 2 ); 

add_action( 'nb_assignment_resubmitted', function( $a, $b ){
    error_log( 'Called from nb_assignment_resubmitted hook in: ' .__FILE__ ); 
}, 10, 2 ); 

add_action( 'nb_assignment_completed', function( $a, $b ){
    error_log( 'Called from nb_assignment_completed hook in: ' .__FILE__ ); 
}, 10, 2 ); 

add_action( 'nb_assignment_incomplete', function( $a, $b ){
    error_log( 'Called from nb_assignment_incomplete hook in: ' .__FILE__ ); 
}, 10, 2 ); 

//Listening for Trainer Reassignment
add_action( 'nb_trainer_reassignment', function( $a, $b ){
    error_log( 'nb_trainer_reassignment hook has been called in: ' .__FILE__ ); 
}, 10, 2 ); 



?>