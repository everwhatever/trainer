<?php

declare(strict_types=1);

namespace App\Product\Application\Message\Command;

use App\Product\Domain\Model\Offer;
use Symfony\Component\HttpFoundation\File\File;

class CreateOfferMessage
{
    public function __construct(public readonly File $photo, public readonly Offer $offer)
    {
    }
}
