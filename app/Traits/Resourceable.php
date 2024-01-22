<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait Resourceable
{
    protected $resourceClass;

    public function newCollection(array $models = [])
    {
        return new ResourceCollection($models, $this->resourceClass);
    }

    public function toArray($request)
    {
        $resource = $this->resourceClass;
        $collection = $resource::collection($this->collection);
        return $collection->toArray($request);
    }

    public function paginator($paginator)
    {
        $this->resourceClass = $this->resourceClass ?? $this->resource;

        $this->collection = $paginator->getCollection();
        $paginatedCollection = $paginator->setCollection($this->collection);
        $resource = $this->resourceClass;
        $resourceCollection = $resource::collection($paginatedCollection);

        $pagination = $paginator->toArray();
        $data = Arr::except($pagination, ['data']);
        $data['data'] = $resourceCollection;

        return $data;
    }
}
