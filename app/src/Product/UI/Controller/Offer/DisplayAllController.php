<?php

declare(strict_types=1);

namespace App\Product\UI\Controller\Offer;

use App\Product\Domain\Model\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayAllController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private string $shortPhotoDir;

    public function __construct(EntityManagerInterface $entityManager, string $shortPhotoDir)
    {
        $this->entityManager = $entityManager;
        $this->shortPhotoDir = $shortPhotoDir;
    }

    #[Route(path: '/offer/display', name: 'offer_display_all')]
    public function displayAction() : Response
    {
        $offers = $this->entityManager->getRepository(Offer::class)->findAll();
        return $this->render('product/offer/display_all.html.twig', [
            'offers' => $offers,
            'photo_dir' => $this->shortPhotoDir
        ]);
    }
}
