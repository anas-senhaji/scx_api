<?php

namespace App\Modules\Collaborateur\Http\Resources;

use App\Http\Resources\BaseResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CollaborateurCollection extends BaseResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

}
