<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Type;
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
        $type = new Type();
        $type->setName($request->request->get('name'));
        $this->typeRepository->saveType($type);

        return View::create($type, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Get("/{typeId}", requirements={"typeId" = "\d+"})
     * @param int $typeId
     * @return View
     */
    public function getType(int $typeId): View
    {
        $type = $this->typeRepository->find($typeId);

        return View::create($type, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/all")
     * @return View
     */
    public function getTypes(): View
    {
        $types = $this->typeRepository->findAll();

        return View::create($types, Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/{typeId}", requirements={"typeId" = "\d+"})
     * @param int $typeId
     * @param Request $request
     * @return View
     */
    public function putType(int $typeId, Request $request): View
    {
        $type = $this->typeRepository->find($typeId);
        if ($type) {
            $type->setName($request->get('name'));
            $this->typeRepository->saveType($type);
        }

        return View::create($type, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete("/{typeId}", requirements={"typeId" = "\d+"})
     * @param int $typeId
     * @return View
     */
    public function deleteType(int $typeId): View
    {
        $type = $this->typeRepository->find($typeId);
        if ($type) {
            $this->typeRepository->deleteType($type);
        }

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}