<?php

namespace App\Modules\Game\Http\Resources;
use App\Http\Resources\BaseResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GameCollection extends BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
}