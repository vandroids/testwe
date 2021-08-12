<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\TypeDTO;
use App\Entity\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TypeRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct($registry, Type::class);
    }

    public function createType(TypeDTO $dto): void
    {
        $entity = TypeDTO::createEntity($dto);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function updateType(TypeDTO $dto, ?Type $entity): void
    {
        if (null === $entity) {
            throw new NotFoundHttpException();
        }

        $entity = TypeDTO::modifyEntity($dto, $entity);

        $this->em->persist($entity);
        $this->em->flush();
    }

    public function deleteType(?Type $entity): void
    {
        if (null === $entity) {
            throw new NotFoundHttpException();
        }

        $this->em->remove($entity);
        $this->em->flush();
    }
}