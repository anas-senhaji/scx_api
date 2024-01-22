<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait HasUuid
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Uuid::uuid4();
        });
    }
}
