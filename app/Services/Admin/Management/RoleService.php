<?php

namespace App\Services\Admin\Management;

use App\Contracts\Abstracts\Services\BaseService;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;

/**
 * @method  Role getServiceEntity()
 */
class RoleService extends BaseService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = new RoleRepository();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllDataPaginated(): LengthAwarePaginator
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
        $this->checkData($id);
        return $this->getServiceEntity();
    }

    /**
     * @param array $requestedData
     * @return Role
     */
    public function addNewData(array $requestedData): Role
    {
        $requestedData["is_mutable"] = true;
        DB::beginTransaction();
        /** @var Role $role */
        $role = RoleRepository::addNewData($requestedData);
        $this->syncRolePermission($requestedData, $role);
        DB::commit();

        return $role;
    }


    /**
     * @param string $id
     * @param array $requestedData
     * @return Role
     * @throws EmptyDataException
     */
    public function updateDataById(string $id, array $requestedData): Role
    {
        $this->checkData($id);
        DB::beginTransaction();
        $role = $this->getServiceEntity();

        if ($role->is_mutable) {
            $role->fill($requestedData)->save();
        }

        $this->syncRolePermission($requestedData, $role);
        DB::commit();

        return $role;
    }


    /**
     * @param array $requestedData
     * @param Role $role
     * @return void
     */
    private function syncRolePermission(array &$requestedData, Role $role): void
    {
        if (isset($requestedData["permission_ids"])) {
            $role->permissions()->sync($requestedData["permission_ids"]);
        }
    }
}
