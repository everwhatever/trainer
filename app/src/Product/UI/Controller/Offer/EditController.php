<?php

declare(strict_types=1);

namespace App\Product\UI\Controller\Offer;

use App\Product\Application\Message\Command\CreateOfferMessage;
use App\Product\Domain\Model\Offer;
use App\Product\Infrastructure\Form\CreateOfferType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    public function __construct(private MessageBusInterface $commandBus, private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     */
    #[Route(path: '/offer/edit/{id}', name: 'offer_edit')]
    public function editAction(Request $request, int $id): Response
    {
        $offer = $this->entityManager->getRepository(Offer::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(CreateOfferType::class, $offer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $offer = $form->getData();
            $this->command($form->get('photo')->getData(), $offer);

            return $this->redirectToRoute('offer_display_all');
        }

        return $this->render('product/offer/edit_offer.html.twig', [
            'form' => $form->createView(),
            'offer_id' => $offer->getId(),
        ]);
    }

    private function command(File $photo, Offer $offer): void
    {
        $message = new CreateOfferMessage($photo, $offer);
        $this->commandBus->dispatch($message);
    }
}
