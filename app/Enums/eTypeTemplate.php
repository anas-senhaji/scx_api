<?php
namespace App\Enums;

use App\Traits\EnumIterator;

abstract class eTypeTemplate
{
    use EnumIterator;

    const _CONTRAT = 'CONTRAT';
    const _ATTESTATION_TRAVAIL = 'ATTESTATION_TRAVAIL';
    const _ATTESTATION_SALAIRE = 'ATTESTATION_SALAIRE';
}
