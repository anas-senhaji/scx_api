<?php

namespace App\Modules\Dci\Http\Resources;
use App\Http\Resources\BaseResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DciCollection extends BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
}