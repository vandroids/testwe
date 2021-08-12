<?php

namespace App\Controller;

use App\Entity\MovieHasPeople;
use App\Repository\MovieHasPeopleRepository;
use App\Repository\MovieRepository;
use App\Repository\PeopleRepository;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;


/**
 * @Route("/api/movie_has_people")
 */
class MovieHasPeopleController extends AbstractFOSRestController
{
    private MovieRepository $movieRepository;
    private PeopleRepository $peopleRepository;
    private MovieHasPeopleRepository $movieHasPeopleRepository;

    public function __construct(
        MovieHasPeopleRepository $movieHasPeopleRepository,
        MovieRepository $movieRepository,
        PeopleRepository $peopleRepository
    )
    {
        $this->movieHasPeopleRepository = $movieHasPeopleRepository;
        $this->movieRepository = $movieRepository;
        $this->peopleRepository = $peopleRepository;
    }

    /**
     * @Rest\Post("/")
     * @param Request $request
     * @return View
     */
    public function createMovieHasPeople(Request $request): View
    {
        $movieHasPeople = new MovieHasPeople();

        $data = $request->toArray();
        $movieId = $data['movie'];
        $peopleId = $data['people'];
        $role = $data['role'];
        $significance = $data['significance'];

        $movie = $this->movieRepository->findOneBy(['id' => $movieId]);
        $people = $this->peopleRepository->findOneBy(['id' => $peopleId]);

        $movieHasPeople->setMovie($movie);
        $movieHasPeople->setPeople($people);
        $movieHasPeople->setRole($role);
        $movieHasPeople->setSignificance($significance);

        $this->movieHasPeopleRepository->saveMovieHasPeople($movieHasPeople);

        return View::create($movieHasPeople, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/")
     * @return View
     */
    public function getMovieHasPeople(Request $request): View
    {
        $data = $request->toArray();
        $movieId = $data['movie'];
        $peopleId = $data['people'];

        /**
         * @todo duplicate code
         */
        $movie = $this->movieRepository->findOneBy(['id' => $movieId]);
        $people = $this->peopleRepository->findOneBy(['id' => $peopleId]);
        $movieHasPeople = $this->movieHasPeopleRepository->findOneBy(['movie' => $movie, 'people' => $people]);

        return View::create($movieHasPeople, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("")
     * @param Request $request
     * @return View
     */
    public function putMovieHasPeople(Request $request): View
    {
        $data = $request->toArray();
        $movieId = $data['movie'] ?? null;
        $peopleId = $data['people'] ?? null;
        $role = $data['role'] ?? null;
        $significance = $data['significance'] ?? null;

        /**
         * @todo duplicate code
         */
        $movie = $this->movieRepository->findOneBy(['id' => $movieId]);
        $people = $this->peopleRepository->findOneBy(['id' => $peopleId]);
        $movieHasPeople = $this->movieHasPeopleRepository->findOneBy(['movie' => $movie, 'people' => $people]);

        if ($movieHasPeople) {
            $movieHasPeople->setRole($role);
            $movieHasPeople->setSignificance($significance);
            $this->movieHasPeopleRepository->saveMovieHasPeople($movieHasPeople);
        }

        return View::create($movieHasPeople, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/")
     * @param Request $request
     * @return View
     */
    public function deleteMovieHasPeople(Request $request): View
    {
        $data = $request->toArray();
        $movieId = $data['movie'];
        $peopleId = $data['people'];

        /**
         * @todo duplicate code
         */
        $movie = $this->movieRepository->findOneBy(['id' => $movieId]);
        $people = $this->peopleRepository->findOneBy(['id' => $peopleId]);
        $movieHasPeople = $this->movieHasPeopleRepository->findOneBy(['movie' => $movie, 'people' => $people]);

        if ($movieHasPeople) {
            $this->movieHasPeopleRepository->deleteMovieHasPeople($movieHasPeople);
        }

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}