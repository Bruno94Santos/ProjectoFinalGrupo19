<?php

$recipient = $email; //recipient 
$email = "projectofinalgrupo19@gmail.com"; //senders e-mail adress 

if ((filter_var($email, FILTER_VALIDATE_EMAIL))) {

    $Name = "Musin Team"; //senders name

    $mail_body = "Hello ({$_POST['name']}), \r\n";
    $mail_body .= "You have just booked a ticket with the following code:" . $code . "\r\n";
    $mail_body .= "Enjoy the event! \r\n";
    $mail_body .= "Best regards, \r\n";
    $mail_body .= "Musin Team \r\n";


    $subject = "Event booking"; //subject
    $header = "From: " . $Name . " <" . $email . ">\r\n"; //optional headerfields

    mail($recipient, $subject, $mail_body, $header); //mail command :)

} else {
    print "You've entered an invalid email address!";
}
?>