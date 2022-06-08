<?php

declare(strict_types=1);

namespace App\Product\UI\Controller\Offer;

use App\Product\Domain\Model\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayOneController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private string $shortPhotoDir;

    public function __construct(EntityManagerInterface $entityManager, string $shortPhotoDir)
    {
        $this->entityManager = $entityManager;
        $this->shortPhotoDir = $shortPhotoDir;
    }

    /**
     * @Route("/offer/display/{id}", name="display_one_offer")
     */
    public function displayAction(int $id): Response
    {
        /** @var Offer $offer */
        $offer = $this->entityManager->getRepository(Offer::class)->findOneBy(['id' => $id]);

        return $this->render('product/offer/display_one.html.twig', [
            'name' => $offer->getName(),
            'description' => $offer->getDescription(),
            'duration' => $offer->getDuration(),
            'price' => $offer->getPrice(),
            'photo_dir' => $this->shortPhotoDir . $offer->getPhotoFilename()
        ]);
    }
}