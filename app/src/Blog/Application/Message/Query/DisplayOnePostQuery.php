<?php

declare(strict_types=1);

namespace App\Blog\Application\Message\Query;

class DisplayOnePostQuery
{
    public function __construct(public readonly int $postId)
    {
    }
}
