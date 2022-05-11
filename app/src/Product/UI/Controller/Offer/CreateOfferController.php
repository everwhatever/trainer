<?php

declare(strict_types=1);

namespace App\Product\UI\Controller\Offer;

use App\Product\Infrastructure\Form\CreateOfferType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateOfferController extends AbstractController
{
    public function createAction(Request $request): Response
    {
        $form = $this->createForm(CreateOfferType::class);
        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()){
//
//        }

        return $this->render('product/offer/create_offer.html.twig', [
            'form' => $form->createView()
        ]);
    }
}