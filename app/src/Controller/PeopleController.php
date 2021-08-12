<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\People;
use App\Repository\PeopleRepository;
use DateTime;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/people")
 */
class PeopleController extends AbstractFOSRestController
{
    private PeopleRepository $peopleRepository;

    public function __construct(PeopleRepository $peopleRepository)
    {
        $this->peopleRepository = $peopleRepository;
    }

    /**
     * @Rest\Post("/")
     * @param Request $request
     * @return View
     */
    public function createPeople(Request $request): View
    {
        $people = new People();
        $people->setFirstname($request->request->get('firstname'));
        $people->setLastname($request->request->get('lastname'));
        $people->setDateOfBirth(new DateTime($request->request->get('date')));
        $people->setNationality($request->request->get('nationality'));
        $this->peopleRepository->savePeople($people);

        return View::create($people, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/{peopleId}", requirements={"peopleId" = "\d+"})
     * @param int $peopleId
     * @return View
     */
    public function getPeople(int $peopleId): View
    {
        $people = $this->peopleRepository->find($peopleId);

        return View::create($people, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/all")
     * @return View
     */
    public function getPeoples(): View
    {
        $peoples = $this->peopleRepository->findAll();

        return View::create($peoples, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/{peopleId}", requirements={"peopleId" = "\d+"})
     * @param int $peopleId
     * @param Request $request
     * @return View
     */
    public function putPeople(int $peopleId, Request $request): View
    {
        $people = $this->peopleRepository->find($peopleId);
        if ($people) {
            $people->setName($request->get('name'));
            $this->peopleRepository->savePeople($people);
        }

        return View::create($people, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/{peopleId}", requirements={"peopleId" = "\d+"})
     * @param int $peopleId
     * @return View
     */
    public function deletePeople(int $peopleId): View
    {
        $people = $this->peopleRepository->find($peopleId);
        if ($people) {
            $this->peopleRepository->deletePeople($people);
        }

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}