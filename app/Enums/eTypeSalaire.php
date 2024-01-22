<?php
namespace App\Enums;

use App\Traits\EnumIterator;

abstract class eTypeSalaire
{
    use EnumIterator;

    const _SALAIRE = 'SALAIRE';
    const _PRIME = 'PRIME';
}
