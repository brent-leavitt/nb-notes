<?php 
Namespace Nb_Notes\App\Func;
//use ; 

/**
 * Functions that help us select a particular user or person from the database. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 

/**
 * Find the Trainer ID from the student's ID. 
 *
 * @since     1.0.0
 * @param     int    $sid   //student ID
 * @return    int    $tid   //trainer ID
 */

 function get_assigned_trainer_id_from_student_id( int $sid ): int
 {

    $student_trainer = get_usermeta( $sid, 'student_trainer', true );
    return ( !empty( $student_trainer ) )? $student_trainer : 0 ; 

 }

?>