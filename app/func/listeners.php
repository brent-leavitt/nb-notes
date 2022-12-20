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
 * Creates action hooks for the different assignment CPT statuses except for draft status. 
 *
 * @since     1.0.0
 * @param     int       $post_id 
 * @param     object    $post
 * @param     bool      $update
 * @return    void
 */

function add_assignment_listeners( $post_id, $post, $update )
{
    //Only dealing with assignment CPTs. 
    if( strcmp( $post->post_type, 'assignment' ) !== 0  ) return; 
    
    //Don't run the do_action when post status is still in draft state. 
    if( strcmp( $post->post_status, 'draft' ) !== 0  )
        do_action( "nb_assignment_{$post->post_status}", $post_id, $post );

} 

add_action( 'save_post_assignment', 'Nb_Notes\App\Func\add_assignment_listeners', 10, 3 ); 

/*
    do_action( 'profile_update', int $user_id, WP_User $old_user_data, array $userdata )

        Fires immediately after an existing user is updated.

    do_action( 'user_register', int $user_id, array $userdata )

        Fires immediately after a new user is registered.
*/ 

/**
 * Creates action hooks for user profile updates. 
 *
 * @since     1.0.0
 * @param     int       $post_id 
 * @param     object    $post
 * @param     bool      $update
 * @return    void
 */

function add_student_update_listeners( $user_id, $old_user_data, $userdata )
{
    //STOPPED HERE.

}


add_action( 'profile_update', 'Nb_Notes\App\Func\add_student_update_listeners', 10, 3 ); 

?>