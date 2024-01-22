<?php
namespace App\Enums;

use App\Traits\EnumIterator;

abstract class eTypeContrat
{
    use EnumIterator;

    const _CDI = 'CDI';
    const _CDD = 'CDD';
    const _STAGE = 'STAGE';
}
