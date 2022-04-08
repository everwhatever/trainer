<?php

declare(strict_types=1);

namespace App\User\Application\Message\Command;

class ContactMessage
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }
}