<?php

declare(strict_types=1);

namespace App\Blog\Application\Handler\Query;

use App\Blog\Application\DTO\PostDTO;
use App\Blog\Application\Message\Query\DisplayOnePostQuery;
use App\Blog\Application\Service\DisplayPostInfoFetcher;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DisplayOnePostHandler implements MessageHandlerInterface
{
    private DisplayPostInfoFetcher $infoFetcher;

    public function __construct(DisplayPostInfoFetcher $infoFetcher)
    {
        $this->infoFetcher = $infoFetcher;
    }

    public function __invoke(DisplayOnePostQuery $query): PostDTO
    {
        return $this->infoFetcher->fetch($query->getPostId());
    }
}