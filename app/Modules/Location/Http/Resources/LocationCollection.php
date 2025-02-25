<?php

namespace App\Modules\Location\Http\Resources;
use App\Http\Resources\BaseResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LocationCollection extends BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
}