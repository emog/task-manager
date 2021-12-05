<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class TaskResourceCollection extends ResourceCollection
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return Collection
     */
    public function toArray($request)
    {
        return $this->collection;
    }
}
