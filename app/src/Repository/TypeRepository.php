<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class TypeRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct($registry, Type::class);
    }

    public function saveType(Type $type): void
    {
        $this->em->persist($type);
        $this->em->flush();
    }

    public function deleteType(Type $type): void
    {
        $this->em->remove($type);
        $this->em->flush();
    }
}