<?php

$templates = [
    
    //Send receipt to student
    [
        'receiver'  => 'student',       //who is receiving this notification?
        'sender'    => 'system',       //default system generated.
        'builder'   => '',    //Which builder will be used to finish the construction of this email.
        'html'      => true,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> '',
            'subject' 	=> '',
            'args' 		=> $this->args

        ]
    ],
    //Send receipt to trainer
    [
        'receiver'  => 'trainer',       //Who is receiving this notification? 
        'sender'    => 'system',       //default system generated.
        'builder'   => '',    //Which builder will be used to finish the construction of this email.
        'html'      => false,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> '',
            'subject' 	=> '',
            'args' 		=> $this->args

        ]
    ],
]; 