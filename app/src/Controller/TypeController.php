<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\TypeDTO;
use App\Repository\TypeRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api/types")
 */
class TypeController extends AbstractFOSRestController
{
    private TypeRepository $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    /**
     * @Rest\Post("/")
     * @param Request $request
     * @return View
     */
    public function createType(Request $request): View
    {
        $dto = TypeDTO::createFromRequest($request);

        $this->typeRepository->createType($dto);

        return View::create($dto, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/{typeId}", requirements={"typeId" = "\d+"})
     * @param int $typeId
     * @return View
     */
    public function getType(int $typeId): View
    {
        $entity = $this->typeRepository->find($typeId);
        $dto = TypeDTO::createFromEntity($entity);

        return View::create($dto, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/all")
     * @return View
     */
    public function getTypes(): View
    {
        $entities = $this->typeRepository->findAll();
        $dtos = TypeDTO::createFromEntityCollection($entities);

        return View::create($dtos, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/{typeId}", requirements={"typeId" = "\d+"})
     * @param int $typeId
     * @param Request $request
     * @return View
     */
    public function putType(int $typeId, Request $request): View
    {
        $entity = $this->typeRepository->find($typeId);
        $dto = TypeDTO::createFromRequest($request);

        $this->typeRepository->updateType($dto, $entity);

        return View::create($dto, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/{typeId}", requirements={"typeId" = "\d+"})
     * @param int $typeId
     * @return View
     */
    public function deleteType(int $typeId): View
    {
        $entity = $this->typeRepository->find($typeId);

        $this->typeRepository->deleteType($entity);

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}