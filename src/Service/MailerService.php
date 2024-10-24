<?php
namespace App\Service;

use App\Service\Mailer\Autogestion;
use App\Service\Mailer\Cisbanda;
use Symfony\Component\Mime\Email;

class MailerService
{
    private $autogestion;
    private $cisbanda;

    public function __construct(Autogestion $autogestion, Cisbanda $cisbanda)
    {
    $this->autogestion = $autogestion;
    $this->cisbanda = $cisbanda;
    }

    public function sendAutogestionEmail()
    {
        $email = (new Email())
        ->from('marketing@example.com')
        ->to('customer@example.com')
        ->subject('Marketing Email')
        ->text('Marketing message');

        $this->autogestion->send($email);
    }

    public function sendCisbandaEmail()
    {
        $email = (new Email())
        ->from('noreply@example.com')
        ->to('user@example.com')
        ->subject('Transactional Email')
        ->text('Order confirmation');

        $this->cisbanda->send($email);
    }
}
