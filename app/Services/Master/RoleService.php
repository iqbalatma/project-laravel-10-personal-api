<?php

namespace App\Services\Master;
use App\Contracts\Abstracts\Services\BaseService;
use App\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\Collection;

class RoleService extends BaseService
{
    protected $repository;

    public function __construct()
    {
        // $this->repository
    }


    /**
     * @return Collection
     */
    public function getAllData():Collection
    {
        return RoleRepository::getAllData();
    }
}
