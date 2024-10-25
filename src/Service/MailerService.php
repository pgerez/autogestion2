<?php
namespace App\Service;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService {

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function sendEmailToTransport1(string $to, string $subject, string $body): void {
        $email = (new Email())
            ->from('autogestion@msaludsgo.gov.ar')
            ->cc('autogestion@msaludsgo.gov.ar')
            ->to($to)
            ->subject($subject)
            ->text($body);

        // Send using transport named 'smtp1'
        $this->mailer->send($email, 'smtp1');
    }


    public function sendEmailToTransport2(string $to, string $subject, string $body): void {
        $email = (new Email())
            ->from('autogestion@cisb.gob.ar')
            ->cc('autogestion@cisb.gob.ar')
            ->to($to)
            ->subject($subject)
            ->text($body);

        // Send using transport named 'smtp2'
        $this->mailer->send($email, 'smtp2');
    }
    // ... Add more methods for other transports as needed ...
}
