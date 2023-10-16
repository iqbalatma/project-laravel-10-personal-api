<?php

namespace App\Services\Admin\Management;
use App\Contracts\Abstracts\Services\BaseService;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;

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
     * @throws EmptyDataException
     */
    public function getDataBy(string $id): Role
    {
        $role = RoleRepository::getSingleData(["id" =>$id]);
        if (!$role){
            throw new EmptyDataException();
        }
        return $role;
    }

    /**
     * @param array $requestedData
     * @return Role
     */
    public function addNewData(array $requestedData):Role
    {
        return RoleRepository::addNewData($requestedData);
    }
}
