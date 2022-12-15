<?php

namespace App\service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendMail(
        $to = "ahmanydanbaibe@gmail.com",
        $content,
        $subject = "modification du mot de passe"
    ):void{
        $email = (new Email())
            ->from('cryptogroupe1@gmail.com')
            ->to('to')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text($content);


        $this->mailer->send($email);
    }

}