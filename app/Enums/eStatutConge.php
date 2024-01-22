<?php
namespace App\Enums;

use App\Traits\EnumIterator;

abstract class eStatutConge
{
    use EnumIterator;

    const _EN_ATTENTE = 'EN_ATTENTE';
    const _APPROUVE = 'APPROUVE';
    const _REJETE = 'REJETE';
}
