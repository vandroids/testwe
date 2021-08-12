<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class MovieRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct($registry, Movie::class);
    }

    public function saveMovie(Movie $movie): void
    {
        $this->em->persist($movie);
        $this->em->flush();
    }

    public function deleteMovie(Movie $movie): void
    {
        $this->em->remove($movie);
        $this->em->flush();
    }
}