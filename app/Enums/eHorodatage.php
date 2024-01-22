<?php
namespace App\Enums;

use App\Traits\EnumIterator;

abstract class eHorodatage
{
    use EnumIterator;

    const _ADD = 'ADD';
    const _UPDATE = 'UPDATE';
    const _DELETE = 'DELETE';
}
