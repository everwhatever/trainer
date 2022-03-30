<?php

declare(strict_types=1);

namespace App\Tests\User\Domain\Service;

use App\User\Domain\Model\AboutMe;
use App\User\Domain\Service\AboutMeCreatorService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AboutMeCreatorServiceTest extends KernelTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
        $this->truncateEntities();
    }
    
    public function testItSavesAboutMeWithProperValues()
    {
        $container = static::getContainer();
        $aboutMe = new AboutMe();
        $aboutMe->setTitle('Test');
        $aboutMe->setDescription('Test_desc');
        $aboutMe->setisActive(true);

        $photoFile = $this->createMock(UploadedFile::class);
        $photoFile->method('getClientOriginalName')->willReturn('zdj');
        $photoFile->method('guessExtension')->willReturn('jpeg');

        $creator = $container->get(AboutMeCreatorService::class);
        $creator->create($photoFile, $aboutMe);

        $em = $this->getEntityManager();
        $aboutMeRepo = $em->getRepository(AboutMe::class);

        $count = (int) $aboutMeRepo
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $this->assertSame(1, $count);

        $title = $aboutMeRepo->createQueryBuilder('s')
            ->select('s.title')
            ->getQuery()
            ->getResult()[0]['title'];
        $this->assertSame('Test', $title);

        $description = $aboutMeRepo->createQueryBuilder('s')
            ->select('s.description')
            ->getQuery()
            ->getResult()[0]['description'];
        $this->assertSame('Test_desc', $description);
    }

    private function truncateEntities(): void
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    private function getEntityManager(): EntityManagerInterface
    {
        $container = static::getContainer();

        return $container->get(EntityManagerInterface::class);
    }
}
