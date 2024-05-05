<?php

namespace App\Service;

use Symfony\Component\Mime\Address;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

class MailService
{
    public function __construct()
    {
    }

    public function sendMail(string $subject, string $to, string $htmlTemplate, ?ResetPasswordToken $token)
    {
        return (new TemplatedEmail())
            ->from(new Address('alban.voiriot@gmail.com', 'Trick Site'))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($htmlTemplate)
            ->context([
                'resetToken' => $token,
            ])
        ;
    }

}