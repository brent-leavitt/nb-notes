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
 
//Create comment listeners, because there is no code anywhere else to pick up on it...? 

/**
 *  Title: asmt_comments
 *	
 *	Description: Messaging actions on comments submitted for assignments
 * 	
 *	Probably should NOT be in this file.
 *
 *	Returns 
 */	
 

 function asmt_comments( $comment_id, $comment_obj )
 {	
	if( strcmp( get_post_type( $comment_obj->comment_post_ID ), 'assignment' ) == 0 )
    {
		//setup parameters
        $commenter_id = $comment_obj->user_id; 

        $post_id = $comment_obj->comment_post_ID; 
        $post = get_post( $post_id );
        $student_id = $post->post_author; 
        
       //check to see if student has an assigned trainer
        $trainer_id = ( metadata_exists( 'user', $student_id, 'student_trainer' ) ) ? 
                            get_user_meta( $student_id, 'student_trainer', true ): 
                            0; 

        //If comment comes from student, send a notice to the trainer                   
        if( intval( $commenter_id ) === intval( $student_id )   ) 
        {
            if( !empty( $trainer_id ) )
            {
                do_action( 'nb_new_student_comment', $trainer_id, $student_id, $comment_obj ); 
            }
            return;
        }
        else
        {
            //If comment comes from someone other than student, send a notice to the student
             do_action( 'nb_new_trainer_comment', $student_id, $trainer_id, $commenter_id, $comment_obj );
        }  
	}
}
add_action( 'wp_insert_comment', 'Nb_Notes\App\Func\asmt_comments', 10, 2 );


function new_student_registration( $membership_id, $data )
{   
   
    //Check if new registration has a 'student' role assigned to them.
    $user_id = $data->get_user_id(); 
    $user = get_user_by( 'id', $user_id ); 
    //error_log( 'Prepping for the nb_new_student_registration log to be fired, here is user info:'. var_export( $user, true ) ); 

    if( in_array( 'student', (array) $user->roles ) ) {
        do_action( 'nb_new_student_registration', $membership_id, $data ); 
        //error_log( 'The nb_new_student_registration log should have been fired.'.__METHOD__ ); 

    }
          
    
}
add_action( 'rcp_membership_post_activate', 'Nb_Notes\App\Func\new_student_registration', 10 , 2 );  

?>