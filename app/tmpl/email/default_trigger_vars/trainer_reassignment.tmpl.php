<?php

$templates = [
    
    //Send receipt to student
    [
        'receiver'  => 'student',       //who is receiving this notification?
        'sender'    => 'admin',         //default system generated.
        'builder'   => 'reassignment',  //Which builder will be used to finish the construction of this email.
        'html'      => true,            //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'Your account has been assigned a new trainer. Your new trainer will be your primary point of contact moving forward. Details of the change are as follows:', //(incomplete)
            'subject' 	=> 'Trainer Reassignment',
            'args' 		=> $this->args

        ]
    ],
    //Send receipt to trainer
    [
        'receiver'  => 'trainer',       //Who is receiving this notification? 
        'sender'    => 'admin',         //default system generated.
        'builder'   => 'reassignment',  //Which builder will be used to finish the construction of this email.
        'html'      => false,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'The following student has be reassigned to a new trainer:',
            'subject' 	=> 'Student Reassigned',
            'args' 		=> $this->args

        ]
    ],
]; 