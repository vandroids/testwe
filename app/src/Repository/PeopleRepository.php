<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\People;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class PeopleRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct($registry, People::class);
    }

    public function savePeople(People $people): void
    {
        $this->em->persist($people);
        $this->em->flush();
    }

    public function deletePeople(People $people): void
    {
        $this->em->remove($people);
        $this->em->flush();
    }
}