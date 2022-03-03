<?php

namespace App\TrainingPlan\UI\Controller;

use App\TrainingPlan\Domain\Model\User;
use App\TrainingPlan\Infrastructure\Form\EditUserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/user/{id}/profile", name="user_profile")
     */
    public function displayUserProfileAction(int $id): Response
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        return $this->render('training_plan/user/user_profile.html.twig', [
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'address' => $user->getAddress(),
            'phone_number' => $user->getPhoneNumber()
        ]);
    }

    /**
     * @Route("/user/{id}/profile/edit", name="user_profile_edit")
     */
    public function editUserProfileAction(Request $request, int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(EditUserProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
        }

        return $this->render('training_plan/user/user_profile_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/{id}/profile/delete", name="user_profile_delete")
     */
    public function deleteUser(int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('homepage');
    }

}