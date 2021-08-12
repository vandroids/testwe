<?php

declare(strict_types=1);

namespace App\DBAL;

class SignificanceType extends EnumType
{
    protected string $name = 'significance';
    protected array $values = [
        'principal',
        'secondaire'
    ];
}