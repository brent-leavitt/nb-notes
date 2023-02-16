<?php

//New Trainer Assignment

$templates = [
    
    //Send receipt to student
    [
        'receiver'  => 'student',       //who is receiving this notification?
        'sender'    => 'system',       //default system generated.
        'builder'   => 'trainer',    //Which builder will be used to finish the construction of this email.
        'html'      => true,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'Welcome! You have been assigned a trainer.',
            'subject' 	=> 'Your Doula Trainer',
            'args' 		=> $this->args

        ]
    ],
    //Send receipt to trainer
    [
        'receiver'  => 'trainer',       //Who is receiving this notification? 
        'sender'    => 'system',       //default system generated.
        'builder'   => 'trainer',    //Which builder will be used to finish the construction of this email.
        'html'      => false,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'Congrats! A new student has registered and been assigned to you. Details are below:',
            'subject' 	=> 'New Doula Student',
            'args' 		=> $this->args

        ]
    ],
]; 