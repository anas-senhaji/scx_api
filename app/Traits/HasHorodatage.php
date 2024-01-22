<?php

namespace App\Traits;
use App\Enums\eHorodatage;
use App\Models\Horodatage;

trait HasHorodatage
{
    
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootHasHorodatage()
    {
        static::created(function($model){
            Horodatage::saveAction($model, eHorodatage::_ADD);
        });
        static::updated(function($model){
            Horodatage::saveAction($model, eHorodatage::_UPDATE);
        });
        static::deleted(function($model){
            Horodatage::saveAction($model, eHorodatage::_DELETE);
        });
    }
}
