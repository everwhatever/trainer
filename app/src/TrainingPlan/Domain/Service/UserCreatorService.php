<?php

namespace App\TrainingPlan\Domain\Service;

use App\TrainingPlan\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreatorService
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function createUser(string $email, string $plainPassword, string $role): User
    {
        $user = new User($email);
        $password = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($password);
        $user->setRole($role);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}