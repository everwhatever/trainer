<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\User\Application\Message\Command\ContactMessage;
use const PHP_EOL;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class ContactHandler implements MessageHandlerInterface
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(ContactMessage $message)
    {
        $data = $message->data;
        $message = (new Email())
            ->from($data['email'])
            ->to('koszykarz.kuba@gmail.com')
            ->subject($data['subject'])
            ->text('Od : ('.$data['email'].') '.$data['name'].PHP_EOL.
                $data['content'],
                'text/plain');
        $this->mailer->send($message);
    }
}
