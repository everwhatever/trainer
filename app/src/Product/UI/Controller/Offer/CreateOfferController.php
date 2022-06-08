<?php

declare(strict_types=1);

namespace App\Product\UI\Controller\Offer;

use App\Product\Application\Message\Command\CreateOfferMessage;
use App\Product\Domain\Model\Offer;
use App\Product\Infrastructure\Form\CreateOfferType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class CreateOfferController extends AbstractController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    #[Route(path: '/offer/create', name: 'offer_create')]
    public function createAction(Request $request) : Response
    {
        $form = $this->createForm(CreateOfferType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->command($form->get('photo')->getData(), $form->getData());

            return $this->redirectToRoute('homepage');
        }
        return $this->render('product/offer/create_offer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function command(File $photo, Offer $offer)
    {
        $message = new CreateOfferMessage($photo, $offer);
        $this->commandBus->dispatch($message);
    }
}
