<?php
//New Student Registration

$templates = [
    
    //Send receipt to student
    [
        'receiver'  => 'student',       //who is receiving this notification?
        'sender'    => 'system',       //default system generated.
        'builder'   => 'registration',              //Which builder will be used to finish the construction of this email.
        'html'      => true,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'Welcome to New Beginnings! Thank you for your registration. Please continue reading for further instruction on how to get started with your training.', // (CONTENT PENDING)
            'subject' 	=> 'New Student Registration',
            'args' 		=> $this->args

        ]
    ]
]; 