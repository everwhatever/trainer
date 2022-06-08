<?php

namespace App\User\UI\Controller;

use App\User\Domain\Model\User;
use App\User\Infrastructure\Form\EditUserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
     * @throws Exception
     */
    #[Route(path: '/user/{id}/profile', name: 'user_profile')]
    public function displayUserProfileAction(int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        if ($this->getUser() !== $user && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw new Exception('No access!');
        }

        return $this->render('user/profile/user_profile.html.twig', [
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'address' => $user->getAddress(),
            'phone_number' => $user->getPhoneNumber(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route(path: '/user/all', name: 'all_users_profiles')]
    public function displayAllUsersProfilesAction(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        if (!in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw new Exception('No access!');
        }

        return $this->render('user/profile/all_users_profiles.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route(path: '/user/{id}/profile/edit', name: 'user_profile_edit')]
    public function editUserProfileAction(Request $request, int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        if ($this->getUser() !== $user && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw new Exception('No access!');
        }
        $form = $this->createForm(EditUserProfileType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
        }

        return $this->render('user/profile/user_profile_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route(path: '/user/{id}/profile/delete', name: 'user_profile_delete')]
    public function deleteUser(int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        if ($this->getUser() !== $user && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            throw new Exception('No access!');
        }
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('homepage');
    }
}
