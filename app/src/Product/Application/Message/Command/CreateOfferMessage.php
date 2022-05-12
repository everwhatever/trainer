<?php

declare(strict_types=1);

namespace App\Product\Application\Message\Command;

use App\Product\Domain\Model\Offer;
use Symfony\Component\HttpFoundation\File\File;

class CreateOfferMessage
{
    private File $photo;

    private Offer $offer;

    public function __construct(File $photo, Offer $offer)
    {
        $this->photo = $photo;
        $this->offer = $offer;
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
