<?php

$templates = [
    
    //Send receipt to student
    [
        'receiver'  => 'student',       //who is receiving this notification?
        'sender'    => 'system',       //default system generated.
        'builder'   => 'assignment',    //Which builder will be used to finish the construction of this email.
        'html'      => true,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'Your assignment has been resubmitted. Your trainer will again review your assignment and you will be notified once it has been graded.',
            'subject' 	=> 'Assignment Resubmitted',
            'args' 		=> $this->args

        ]
    ],
    //Send receipt to trainer
    [
        'receiver'  => 'trainer',       //Who is receiving this notification? 
        'sender'    => 'system',       //default system generated.
        'builder'   => 'assignment',    //Which builder will be used to finish the construction of this email.
        'html'      => false,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'A student has resubmitted an assignment which is again ready to be graded.',
            'subject' 	=> 'Assignment Resubmitted',
            'args' 		=> $this->args

        ]
    ],
]; 