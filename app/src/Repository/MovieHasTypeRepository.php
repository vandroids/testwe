<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\MovieHasType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MovieHasTypeRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct($registry, MovieHasType::class);
    }

    public function saveMovieHasType(MovieHasType $movieHasType): void
    {
        $this->em->persist($movieHasType);
        $this->em->flush();
    }

    public function deleteMovieHasType(MovieHasType $movieHasType): void
    {
        $this->em->remove($movieHasType);
        $this->em->flush();
    }
}