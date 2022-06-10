<?php

declare(strict_types=1);

namespace App\Product\Application\Message\Command;

use App\Product\Domain\Model\Offer;
use Symfony\Component\HttpFoundation\File\File;

class CreateOfferMessage
{
    public function __construct(private readonly File $photo, private readonly Offer $offer)
    {
    }

    public function getPhoto(): File
    {
        return $this->photo;
    }

    public function getOffer(): Offer
    {
        return $this->offer;
    }
}
