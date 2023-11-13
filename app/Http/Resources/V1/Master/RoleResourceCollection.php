<?php

namespace App\Http\Resources\V1\Master;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->resource->map(function (Role $item){
            return [
                "id" => $item->id,
                "name" => $item->name,
            ];
        })->toArray();
    }
}
