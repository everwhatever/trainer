<?php

namespace App\Shared\UI\Controller;

use App\Product\Domain\Model\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private string $shortPhotoDir;

    public function __construct(EntityManagerInterface $entityManager, string $shortPhotoDir)
    {
        $this->entityManager = $entityManager;
        $this->shortPhotoDir = $shortPhotoDir;
    }

    #[Route(path: '/', name: 'homepage')]
    public function indexAction() : Response
    {
        $offers = $this->entityManager->getRepository(Offer::class)->findAll();
        return $this->render('shared/homepage.html.twig',[
            'offers' => $offers,
            'photo_dir' => $this->shortPhotoDir
        ]);
    }
}
