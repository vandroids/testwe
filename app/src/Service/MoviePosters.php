<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;

class MoviePosters
{
    protected const BATCH_SIZE = 50;

    protected XRapidAPI $api;
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, XRapidAPI $api)
    {
        $this->em = $em;
        $this->api = $api;
    }

    public function populate()
    {
        $movies = $this
            ->em
            ->getRepository(Movie::class)
            ->getMoviesWithoutPosterQuery(XRapidAPI::RATE_LIMIT_PER_RUN);

        $count = 0;

        foreach ($movies->toIterable() as $movie) {
            $poster = $this->api->getMovieImage($movie->getTitle());
            if (null === $poster) {
                continue;
            }

            $movie->setPoster($poster);
            if ((++$count % self::BATCH_SIZE) === 0) {
                $this->em->flush();
                $this->em->clear();
            }
        }

        $this->em->flush();

        return $count;
    }
}