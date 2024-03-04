<?php
namespace App\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MyEmail
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $recipient, string $subject, array $context): void
    {
        $email = (new TemplatedEmail())
            ->from('your_email@example.com')
            ->to($recipient)
            ->subject($subject)
            ->htmlTemplate('email.html.twig') // Customize the template path
            ->context(['subject' => $subject] + $context);

        $this->mailer->send($email);
    }
}
