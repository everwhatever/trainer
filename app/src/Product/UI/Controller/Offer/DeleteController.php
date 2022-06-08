<?php

declare(strict_types=1);

namespace App\Product\UI\Controller\Offer;

use App\Product\Domain\Model\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route(path: '/offer/delete/{id}', name: 'offer_delete')]
    public function deleteAction(int $id) : Response
    {
        $offer = $this->entityManager->getRepository(Offer::class)->findOneBy(['id' => $id]);
        $this->entityManager->remove($offer);
        $this->entityManager->flush();
        return $this->redirectToRoute('offer_display_all');
    }
}
