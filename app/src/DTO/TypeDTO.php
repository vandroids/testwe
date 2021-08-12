<?php
declare(strict_types=1);

namespace App\DTO;

use App\Entity\Type;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class TypeDTO
{
    public string $name;

    protected function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function createFromRequest(Request $request): TypeDTO
    {
        $name = (string)($request->toArray()['name'] ?? null);
        static::validate($name);

        return new static($name);
    }

    public static function createFromEntity(Type $type): TypeDTO
    {
        $name = $type->getName();
        static::validate($name);

        return new static($name);
    }

    public static function createFromEntityCollection(Iterable $entities): array
    {
        $dtos = [];

        foreach ($entities as $entity) {
            $dtos[] = static::createFromEntity($entity);
        }

        return $dtos;
    }

    public static function createEntity(TypeDTO $dto): Type
    {
        return static::fromDTO($dto);
    }

    public static function modifyEntity(TypeDTO $dto, Type $entity): Type
    {
        return static::fromDTO($dto, $entity);
    }

    protected static function fromDTO(TypeDTO $dto, ?Type $entity = null): Type
    {
        if (!$entity) {
            $entity = new Type();
        }
        $entity->setName($dto->name);

        return $entity;
    }

    protected static function validate($name)
    {
        if (empty($name)) {
            throw new BadRequestException('Invalid data');
        }
    }
}