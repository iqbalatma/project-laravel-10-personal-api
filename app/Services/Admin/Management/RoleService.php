<?php

namespace App\Services\Admin\Management;
use App\Contracts\Abstracts\Services\BaseService;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleService extends BaseService
{
    protected $repository;

    public function __construct()
    {
        // $this->repository
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllDataPaginated():LengthAwarePaginator
    {
        return RoleRepository::getAllDataPaginated();
    }

    /**
     * @param string $id
     * @return Role
     */
    public function getDataBy(string $id)
    {
        return RoleRepository::getSingleData(["id" =>$id]);
    }
}
