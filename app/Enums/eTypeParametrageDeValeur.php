<?php
namespace App\Enums;

use App\Traits\EnumIterator;

abstract class eTypeParametrageDeValeur
{
    use EnumIterator;

    const _JOURS_AVANT_DEMANDE_CONGE = 'JOURS_AVANT_DEMANDE_CONGE';
    const _JOURS_AJOUTES_PAR_MOIS = 'JOURS_AJOUTES_PAR_MOIS';
    const _HEURES_TRAVAILLEES_PAR_JOUR = 'HEURES_TRAVAILLEES_PAR_JOUR';
}
