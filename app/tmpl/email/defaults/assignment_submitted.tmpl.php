<?php

$templates = [
    
    //Send receipt to student
    [
        'receiver'  => 'student',       //who is receiving this notification?
        'sender'    => 0,               //0 = system generated.
        'builder'   => 'assignment',    //Which builder will be used to finish the construction of this email.
        'html'      => false,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'The assignment has been submitted.',
            'subject' 	=> 'Assignment Submitted',
            'args' 		=> $this->args

        ]
    ],
    //Send receipt to trainer
    [
        'receiver'  => 'trainer',       //Who is receiving this notification? 
        'sender'    => 0,               //0  = system generated.
        'builder'   => 'assignment',    //Which builder will be used to finish the construction of this email.
        'html'      => false,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'A student has submitted an assignment which is ready to be graded.',
            'subject' 	=> 'Assignment Ready',
            'args' 		=> $this->args

        ]
    ],
]; 