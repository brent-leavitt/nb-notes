<?php
$course_url = home_url( '/programs/' ); 

$templates = [
    
    //Send receipt to student
    [
        'receiver'  => 'student',       //who is receiving this notification?
        'sender'    => 'system',       //default system generated.
        'builder'   => 'assignment',    //Which builder will be used to finish the construction of this email.
        'html'      => true,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> "Good work! Your assignment has been graded and marked as complete. A copy of the completed assignment is included below for your records. <br> <a href='{$course_url}' style='color:#AC1B5C;'  target='_blank' >Continue Learning ></a>",
            'subject' 	=> 'Assignment Completed',
            'args' 		=> $this->args
        ]
    ],

]; 