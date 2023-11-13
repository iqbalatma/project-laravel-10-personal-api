<?php

namespace App\Services\Master;
use App\Contracts\Abstracts\Services\BaseService;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Facades\Cache;

class PermissionService extends BaseService
{
    /**
     * @return array
     */
    public function getAllData():array
    {
        Cache::forget(config("cache.prefix_key.permission_all"));
        return Cache::rememberForever(config("cache.prefix_key.permission_all"), function (){
            return PermissionRepository::getAllData(columns: ["id", "name"])->toArray();
        });
    }
}
