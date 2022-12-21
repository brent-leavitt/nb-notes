<?php 
Namespace Nb_Notes\App\Func;
//use ; 

/**
 * Setting up hooks to be executed by triggers
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Clss/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 

/**
 * Creates action hook for trainer reassignment 
 *
 *  REFERENCE: do_action( 'profile_update', int $user_id, WP_User $old_user_data, array $userdata )
 *  // Fires immediately after an existing user is updated.
 * 
 * @since     1.0.0
 * @param     int       $post_id 
 * @param     object    $post
 * @param     bool      $update
 * @return    void
 */

function add_student_trainer_update_listener( $user_id, $old_user_data, $userdata )
{
    //If new trainer is different than old trainer. 
    $old_trainer = $old_user_data->data[ 'student_trainer' ]; 
    $new_trainer = $userdata[ 'student_trainer' ]; 
   
    //if no change, abort.
    if( strcmp( $old_trainer, $new_trainer ) == 0 ) return;

    do_action( 'nb_trainer_reassignment', $user_id, $old_trainer, $new_trainer, $userdata ); 
}

add_action( 'profile_update', 'Nb_Notes\App\Func\add_student_trainer_update_listener', 10, 3 ); 


/**
 * Creates action hook for new student trainer assignment
 *
 * REFERENCE:  do_action( 'user_register', int $user_id, array $userdata )
 * //  Fires immediately after a new user is registered.
 *
 * @since     1.0.0
 * @param     int       $post_id 
 * @param     object    $post
 * @param     bool      $update
 * @return    void
 */

function add_trainer_new_student_listener( $user_id, $userdata )
{
   //if no trainer has been assigned, abort.
    if( empty( $trainer = $userdata->data[ 'student_trainer' ] ) ) return;

    do_action( 'nb_trainer_new_student', $user_id, $trainer, $userdata ); 
}

add_action( 'user_register', 'Nb_Notes\App\Func\add_trainer_new_student_listener', 10, 2 ); 

?>