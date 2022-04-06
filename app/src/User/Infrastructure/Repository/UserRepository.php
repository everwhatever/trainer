<?php

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Model\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the profile's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function getUserInfo(array $userIds, array $selectedFields): array
    {
        $qb = $this->createQueryBuilder('u');

        $qb->select('u.id');

        foreach ($selectedFields as $select) {
            $qb->addSelect('u.' . $select);
        }

        $qb
            ->andWhere('u.id IN (:userIds)')
            ->setParameter('userIds', $userIds, PDO::PARAM_INT);

        $result = $qb->getQuery()->getResult();

        if ($result) {
            return $result[0];
        }

        return [];
    }
}
