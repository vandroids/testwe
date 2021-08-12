<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\MovieHasType;
use App\Repository\MovieHasTypeRepository;
use App\Repository\MovieRepository;
use App\Repository\TypeRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/movie_has_type")
 */
class MovieHasTypeController extends AbstractFOSRestController
{
    private MovieRepository $movieRepository;
    private TypeRepository $typeRepository;
    private MovieHasTypeRepository $movieHasTypeRepository;

    public function __construct(
        MovieHasTypeRepository $movieHasTypeRepository,
        MovieRepository $movieRepository,
        TypeRepository $typeRepository
    )
    {
        $this->movieHasTypeRepository = $movieHasTypeRepository;
        $this->movieRepository = $movieRepository;
        $this->typeRepository = $typeRepository;
    }

    /**
     * @Rest\Post("/")
     * @param Request $request
     * @return View
     */
    public function createMovieHasType(Request $request): View
    {
        $movieHasType = new MovieHasType();

        $data = $request->toArray();
        $movieId = $data['movie'];
        $typeId = $data['type'];

        $movie = $this->movieRepository->findOneBy(['id' => $movieId]);
        $type = $this->typeRepository->findOneBy(['id' => $typeId]);

        $movieHasType->setMovie($movie);
        $movieHasType->setType($type);

        $this->movieHasTypeRepository->saveMovieHasType($movieHasType);

        return View::create($movie, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("")
     * @param Request $request
     * @return View
     */
    public function getMovieHasType(Request $request): View
    {
        $data = $request->toArray();
        $movieId = $data['movie'];
        $typeId = $data['type'];

        /**
         * @todo duplicate code
         */
        $movie = $this->movieRepository->findOneBy(['id' => $movieId]);
        $type = $this->typeRepository->findOneBy(['id' => $typeId]);
        $movieHasType = $this->movieHasTypeRepository->findOneBy(['movie' => $movie, 'type' => $type]);

        return View::create($movieHasType, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("")
     * @param Request $request
     * @return View
     */
    public function putMovieHasType(Request $request): View
    {
        $data = $request->toArray();
        $movieId = $data['movie'] ?? null;
        $typeId = $data['type'] ?? null;
        $newMovieId = $data['movie'] ?? null;
        $newTypeId = $data['type'] ?? null;

        $newMovie = $this->movieRepository->findOneBy(['id' => $newMovieId]);
        $newType = $this->typeRepository->findOneBy(['id' => $newTypeId]);

        /**
         * @todo duplicate code
         */
        $movie = $this->movieRepository->findOneBy(['id' => $movieId]);
        $type = $this->typeRepository->findOneBy(['id' => $typeId]);
        $movieHasType = $this->movieHasTypeRepository->findOneBy(['movie' => $movie, 'type' => $type]);

        if ($movieHasType) {
            $movieHasType->setType($newType);
            $movieHasType->setMovie($newMovie);
            $this->movieHasTypeRepository->saveMovieHasType($movieHasType);
        }

        return View::create($movieHasType, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("")
     * @param Request $request
     * @return View
     */
    public function deleteMovieHasType(Request $request): View
    {
        $data = $request->toArray();
        $movieId = $data['movie'] ?? null;
        $typeId = $data['type'] ?? null;

        /**
         * @todo duplicate code
         */
        $movie = $this->movieRepository->findOneBy(['id' => $movieId]);
        $type = $this->typeRepository->findOneBy(['id' => $typeId]);
        $movieHasType = $this->movieHasTypeRepository->findOneBy(['movie' => $movie, 'type' => $type]);

        if ($movieHasType) {
            $this->movieHasTypeRepository->deleteMovieHasType($movieHasType);
        }

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}