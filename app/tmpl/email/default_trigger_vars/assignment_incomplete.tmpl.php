<?php

$templates = [
    
    //Send receipt to student
    [
        'receiver'  => 'student',       //who is receiving this notification?
        'sender'    => 'trainer',       //sent by the trainer, kind of
        'builder'   => 'assignment',       //Which builder will be used to finish the construction of this email.
        'html'      => true,           //Is this sent in HTML format (true) or plain text (false)
        'params'    => [
            'content' 	=> "You're making progress! Your assignment has been reviewed and needs additional work. Please revisit the assignment and review the trainer's comments for further instructions on how to complete this assignment." ,
            'subject' 	=> 'Assignment Incomplete',
            'args' 		=> $this->args

        ]
    ]
]; 