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

    public function createUser(string $email, string $plainPassword): User
    {
        //TODO: hash
//        $password = $this->passwordHasher->hashPassword($plainPassword);
//        $user = User::create($email, $password);
    }
}