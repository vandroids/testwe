<?php

namespace App\DBAL;

class SignificanceType extends EnumType
{
    protected string $name = 'significance';
    protected array $values = [
        'principal',
        'secondaire'
    ];
}