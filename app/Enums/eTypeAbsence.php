<?php
namespace App\Enums;

use App\Traits\EnumIterator;

abstract class eTypeAbsence
{
    use EnumIterator;

    const _AUTORISEE = 'AUTORISEE';
    const _JUSTIFIE = 'JUSTIFIEE';
    const _LEGALE = 'LEGALE';
    const _NON_JUSTIFIEE = 'NON_JUSTIFEE';
}
