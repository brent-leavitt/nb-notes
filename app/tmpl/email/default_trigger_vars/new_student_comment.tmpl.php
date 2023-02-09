<?php

$templates = [
    
    //Send receipt to trainer
    [
        'receiver'  => 'trainer',       //who is receiving this notification?
        'sender'    => 'student',       //default system generated.
        'builder'   => 'comment',       //Which builder will be used to finish the construction of this email.
        'html'      => false,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'A new student comment has been posted on the following assignment.',
            'subject' 	=> 'New Reply from Student',
            'args' 		=> $this->args

        ]
    ],
   
]; 