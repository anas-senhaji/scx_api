<?php

namespace App\Modules\Role\Http\Resources;

use App\Http\Resources\BaseResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
}
