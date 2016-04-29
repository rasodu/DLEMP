<?php

require __DIR__.'/../vendor/autoload.php';

//start setup mail config
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp';
$mail->Port= 25;
//end setup mail config

//start setup mail
$mail->setFrom('from@example.com', 'From user');
$mail->addAddress('to@example.net', 'To User');
$mail->Subject = 'Test mail subject line';
$mail->Body = 'This is <b>test</b> message: '.time();
//end setup mail

//start send actual email
$mail->smtpConnect(
    [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ]
);
if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
//end send actual email
