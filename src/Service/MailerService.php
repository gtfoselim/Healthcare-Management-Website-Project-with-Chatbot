<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class MailerService
{

    private $mailer;


    public function __construct(MailerInterface $mailer)
    {

        $this->mailer = $mailer;
    }

    public function sendEmail($to, $nom, $idevent): void
    {

        $email = (new Email())
            ->from('emna.chelly@esprit.tn')
            ->to($to)
            ->subject('Visita')
            ->text($nom . '  Votre Participation est bien validé ! dans l evenement ' . $idevent);

        $this->mailer->send($email);

        // ...
    }
}
