<?php

namespace AppBundle\Utilities;

class EmailServiceClass
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($subject, $to, $body)
    {

        dump($to);

        $msg = \Swift_Message::newInstance();

        $msg->setSubject($subject);
        $msg->setFrom('splintermastercloud@gmail.com');
        $msg->setTo($to);
        $msg->setBody($body);
        $msg->setContentType('text/html');
        $msg->setCharset('utf-8');

        dump($this->mailer->send($msg));

        dump($msg);
        exit;


    }
}