<?php

declare(strict_types=1);

namespace App\User\Application\Message\Command;

class ContactMessage
{
    public function __construct(private array $data)
    {
    }

    public function getData(): array
    {
        return $this->data;
    }
}
