<?php

namespace App\Services\Admin\Management;
use App\Contracts\Abstracts\Services\BaseService;
use App\Repositories\PermissionRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Iqbalatma\LaravelJwtAuthentication\Exceptions\InvalidTokenException;

class PermissionService extends BaseService
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
        return PermissionRepository::getAllDataPaginated();
    }
}
