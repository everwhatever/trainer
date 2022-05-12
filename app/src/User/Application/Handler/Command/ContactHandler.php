<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\User\Application\Message\Command\ContactMessage;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;
use const PHP_EOL;

class ContactHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function __invoke(ContactMessage $message)
    {
        $data = $message->getData();
        $message = (new Email())
            ->from($data['email'])
            ->to('koszykarz.kuba@gmail.com')
            ->subject($data['subject'])
            ->text('Od : (' . $data['email'] . ') ' . $data['name'] . PHP_EOL .
                $data['content'],
                'text/plain');
        $this->mailer->send($message);
    }
}