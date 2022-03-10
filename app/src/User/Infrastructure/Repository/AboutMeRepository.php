<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Repository;

use App\User\Domain\Model\AboutMe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AboutMe|null find($id, $lockMode = null, $lockVersion = null)
 * @method AboutMe|null findOneBy(array $criteria, array $orderBy = null)
 * @method AboutMe[]    findAll()
 * @method AboutMe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AboutMeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutMe::class);
    }
}
