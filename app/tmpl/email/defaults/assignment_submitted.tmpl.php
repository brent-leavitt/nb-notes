<?php

$templates = [
    
    //Send receipt to student
    [
        'receiver'  => 'student',       //who is receiving this notification?
        'sender'    => 'system',       //default system generated.
        'builder'   => 'assignment',    //Which builder will be used to finish the construction of this email.
        'html'      => false,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'You have submitted an assignment. Your trainer will now review your assignment. You will be notified once it has been graded.',
            'subject' 	=> 'Assignment Submitted',
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
            'content' 	=> 'A student has submitted an assignment which is ready to be graded.',
            'subject' 	=> 'Assignment Ready',
            'args' 		=> $this->args

        ]
    ],
]; 