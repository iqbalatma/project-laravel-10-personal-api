<?php

namespace App\Services\Admin\Management;
use App\Contracts\Abstracts\Services\BaseService;
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
}
