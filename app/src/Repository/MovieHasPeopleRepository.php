<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MovieHasPeople;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MovieHasPeopleRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct($registry, MovieHasPeople::class);
    }

    public function saveMovieHasPeople(MovieHasPeople $movieHasType): void
    {
        $this->em->persist($movieHasType);
        $this->em->flush();
    }

    public function deleteMovieHasPeople(MovieHasPeople $movieHasType): void
    {
        $this->em->remove($movieHasType);
        $this->em->flush();
    }
}