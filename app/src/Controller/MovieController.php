<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/movie")
 */
class MovieController extends AbstractFOSRestController
{
    private MovieRepository $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * @Rest\Post("/")
     * @param Request $request
     * @return View
     */
    public function createMovie(Request $request): View
    {
        $movie = new Movie();
        $movie->setTitle($request->request->get('title'));
        $movie->setDuration($request->request->get('duration'));
        $this->movieRepository->saveMovie($movie);

        return View::create($movie, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/{movieId}", requirements={"movieId" = "\d+"})
     * @param int $movieId
     * @return View
     */
    public function getMovie(int $movieId): View
    {
        $movie = $this->movieRepository->find($movieId);

        return View::create($movie, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/all")
     * @return View
     */
    public function getMovies(): View
    {
        $movies = $this->movieRepository->findAll();

        return View::create($movies, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/{movieId}", requirements={"movieId" = "\d+"})
     * @param int $movieId
     * @param Request $request
     * @return View
     */
    public function putMovie(int $movieId, Request $request): View
    {
        $movie = $this->movieRepository->find($movieId);
        if ($movie) {
            $movie->setTitle($request->request->get('title'));
            $movie->setDuration($request->request->get('duration'));
            $this->movieRepository->saveMovie($movie);
        }

        return View::create($movie, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/{movieId}", requirements={"movieId" = "\d+"})
     * @param int $movieId
     * @return View
     */
    public function deleteMovie(int $movieId): View
    {
        $movie = $this->movieRepository->find($movieId);
        if ($movie) {
            $this->movieRepository->deleteMovie($movie);
        }

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}