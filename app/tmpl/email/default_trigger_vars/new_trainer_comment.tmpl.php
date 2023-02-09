<?php

$templates = [
    
    //Send receipt to student
    [
        'receiver'  => 'student',       //who is receiving this notification?
        'sender'    => 'trainer',       //default system generated.
        'builder'   => 'comment',       //Which builder will be used to finish the construction of this email.
        'html'      => true,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> 'A new comment has been posted on the following assignment.',
            'subject' 	=> 'New Assignment Comment',
            'args' 		=> $this->args

        ]
    ],
   
]; 