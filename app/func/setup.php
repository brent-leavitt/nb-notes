<?php 
Namespace Nb_Notes\App\Func;
use Doula_Course\App\Clss\Post_Types; 


/**
 * Setup of CPTs and other foundational elements in the plugin. Note dependency on Doula_Course Post Types class. 
 *
 * @since      1.0.0
 * @package    Nb_Notes
 * @subpackage Nb_Notes/App/Func/
 * @author     Brent Leavitt <brent@trainingdoulias.com>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
 
 
/**
 * Let's register the Notifications CPT 
 *
 * @since     1.0.0
 * @return    void
 */
function register_notifications()
{
	$note_args = [
		'post_type' => 'notification', 	//
		'description' => 'Templated notifications used to communicate with the students.', 		//
		'hierarchical' => false,		//
		'exclude_from_search' => false, 	//
		'show_in_menu' => true,	//
		'menu_pos' => 54,			//
		'menu_icon' => 'buddicons-pm',	//
		'supports' => array( 'title', 'editor', 'revisions', 'excerpt', 'author' ),		//
		'has_archive' => true,		//
	];

    $type = new Post_Types( $note_args );
    $results[] = register_post_type( $type->get_name(), $type->get_args() );		
}

add_action( 'init', 'Nb_Notes\App\Func\register_notifications' ); 


/**
 * Let's now setup the admin metaboxes that are available for the Notificiation CPT
 *
 * @since     1.0.0
 * @return    void
 */

function admin_meta_boxes(){
	global $post;

	//For our Notification Template CPT editor. 
	if( strcmp( get_post_type( $post ), 'notification' ) == 0 ) {
		
		//Remove default metaboxes 
		remove_meta_box('pageparentdiv', 'notification', 'side');
		remove_meta_box('commentstatusdiv', 'notification', 'normal');
		remove_meta_box('postcustom', 'notification', 'normal');
		
		//Remove third-party metaboxes
		//remove_meta_box('_kad_classic_meta_control', 'notification', 'side');
		
		//Add additional metaboxes
		add_meta_box( 'note-details-div', __( 'Notification Details' ), 'Nb_Notes\App\Func\note_details_callback' , 'notification', 'side', 'default' );	
	}
}

if( is_admin() )
	add_action( 'add_meta_boxes', 'Nb_Notes\App\Func\admin_meta_boxes' );


/**
 * fires a notification to be processed
 *
 * @since     1.0.0
 * @param     object    $post     //
 * @return    void    
 */
function note_details_callback( $post ){
	
    //Assign a trigger.
	echo __('A trigger may be set to connect to this notificaiton.', 'nb-notes'); 
	echo build_triggers_dropdown( $post->ID );
    
    //display available shortcodes from trigger, maybe?  

    //Assign a template.
    
    //Maybe assign output format: HTML or Plain or is this determined by the assigned template? Could be. 

}
	

/**
 * Builds the triggeres dropdown menu from the Notification Details metabox in the Notification Temlpates CPT. 
 *
 * @since     1.0.0
 * @param     int       $post_id        //
 * @return    string    
 */
	 
function build_triggers_dropdown( int $post_id = 0 ) {	
	
    //Load and Link Triggers from Options Table in database. 
    $triggers = get_option( 'nb_notes_trigger_templates' ); 

    $assigned_trigger = search_for_post_in_triggers( $post_id, $triggers ); 

	$output = '<p><select name="nb_notes_trigger_templates" id="nb_notes_trigger_templates">';
			
    //If there is no course ID then the default message should be displayed. 
    $output .= '<option value=""> -- trigger not set -- </option>';
        
    foreach( array_keys( $triggers ) as $trigger )
    {
        $output .= '<option value="'.$trigger.'"';
        $output .= ( strcmp( $trigger, $assigned_trigger ) == 0 )? ' selected' : '';
        $output .= '>'.  str_replace( '_', ' ', $trigger ) .'</option>'; 		
    } 

	$output .= '</select></p>';	
	
	//Display other templates assigned to the trigger. 
	if( !empty( $assigned_trigger ) && !empty( $assigned_templates = $triggers[ $assigned_trigger ] ) )
    {
        $output1 = ''; 
        foreach( $assigned_templates as $tmpl_id )
        {
           if( $tmpl_id !== $post_id )
           {
                $tmpl = get_post( $tmpl_id );
                $output1 .= "<li><a href='/wp-admin/post.php?action=edit&post=". $tmpl->ID."'> $tmpl->post_title </a></li>"; 
           }
           
        }
        if( !empty( $output1 ) )
            $output .= "<p>The following template(s) are already assigned to this trigger:</p><ul>". $output1 ."</ul>";
    }
	
	return $output;
}	



/**
 * Saves the trigger assigned from the Notification Details metabox in the Notification Temlpates CPT. 
 *
 * @since     1.0.0
 * @param     int       $post_id        //
 * @return    void 
 */
	 

function save_assigned_template_to_trigger( $post_id ) {			
	global $post;
	
    //Check user permissions
    if ( !current_user_can( 'edit_post',  $post_id ) ) return false;

	// Make sure that it is set.
	if ( ! isset( $_POST['nb_notes_trigger_templates'] ) ) return;
	
	//Load what is needed to assess whether a new trigger assignment has been made.  
	$triggers = get_option( 'nb_notes_trigger_templates' );
	$submitted_trigger =  $_POST['nb_notes_trigger_templates'] ?? '';
	
    $assigned_trigger = search_for_post_in_triggers( $post_id, $triggers ); 

    $update = false; 

    //Different cases: 
    //If assigned trigger is empty, and submitted trigger is not empty, Make assignment
    if( empty( $assigned_trigger ) && !empty( $submitted_trigger ) )
    {
        //Add Trigger
        $triggers = add_template_to_trigger( $post_id, $submitted_trigger, $triggers );
        $update = true;
    }
    //else if assigned trigger is not empty, and submitted trigger is empty, remove assignment
    elseif( !empty( $assigned_trigger ) && empty( $submitted_trigger ) )
    {   
        //Remove Trigger
        $triggers = remove_template_from_trigger( $post_id, $triggers ); 
        $update = true;
    }
    //else if submitted trigger is not empty, and a new assignment is made, remove from old trigger and assign to new trigger.
    elseif( !empty( $submitted_trigger ) && ( strcmp( $assigned_trigger, $submitted_trigger ) !== 0 )  )
    {
        //Remove, then add Trigger. 
        $triggers = remove_template_from_trigger( $post_id, $triggers ); 
        $triggers = add_template_to_trigger( $post_id, $submitted_trigger, $triggers );
        $update = true;
    }
            
	if( $update )
		update_option( 'nb_notes_trigger_templates', $triggers ); 	

}

add_action( 'save_post', 'Nb_Notes\App\Func\save_assigned_template_to_trigger' );



/**
 * Searches for a post within the triggers. 
 *
 * @since     1.0.0
 * @param     int       $post_id        //
 * @param     array     $triggers       //nested array of triggers and their post_ids
 * @return    string||bool   
 */
	


function search_for_post_in_triggers( $post_id, $triggers )
{

    foreach( $triggers as $trigger => $search_arr )
    {
        if( in_array( $post_id, $search_arr ) )
        {
            return $trigger;
        }
    }

    return false; 
}


/**
 * Adds a notification template ID to an assigned trigger. 
 *
 * @since     1.0.0
 * @param     int       $post_id        //ID of the notification template
 * @param     string    $target         //the target triggger to be updated. 
 * @param     array     $triggers       //nested array of triggers and their post_ids
 * @return    array   
 */ 
 
 function add_template_to_trigger( $post_id, $target, $triggers )
 {
     
     if( !in_array( $post_id, $triggers[ $target ] ) )
         $triggers[ $target ][] = $post_id;
 
     return $triggers; 
 }


/**
 * Removes notification template ID within a trigger. 
 *
 * @since     1.0.0
 * @param     int       $post_id        //
 * @param     array     $triggers       //nested array of triggers and their post_ids
 * @return    array   
 */
	
 function remove_template_from_trigger( $post_id, $triggers )
 {
 
    foreach( $triggers as $trigger => $trig_arr  )
     {
        foreach( array_keys( $trig_arr, $post_id, true ) as $key )
        {
             unset( $triggers[ $trigger ][ $key ] );
        }
     }
     
     return $triggers; 
 }
 
?>