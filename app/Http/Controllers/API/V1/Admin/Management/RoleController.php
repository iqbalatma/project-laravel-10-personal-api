<?php

namespace App\Http\Controllers\API\V1\Admin\Management;

use App\Http\Controllers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Management\Roles\StoreRoleRequest;
use App\Http\Requests\V1\Admin\Management\Roles\UpdateRoleRequest;
use App\Http\Resources\V1\Admin\Management\Roles\RoleResource;
use App\Http\Resources\V1\Admin\Management\Roles\RoleResourceCollection;
use App\Services\Admin\Management\RoleService;
use App\Services\GeneralReplacement\ReplacementService;
use Iqbalatma\LaravelServiceRepo\Exceptions\EmptyDataException;

class RoleController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            "index" => "Get all data role paginated successfully",
            "indexAll" => "Get all data role successfully",
            "show" => "Get data role by id successfully",
            "store" => "Add new data role successfully",
            "update" => "Update data role by id successfully",
        ];
    }

    /**
     * @param RoleService $service
     * @return APIResponse
     */
    public function index(RoleService $service): APIResponse
    {
        $response = $service->getAllDataPaginated();

        return $this->apiResponse(
            new RoleResourceCollection($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @param RoleService $service
     * @param string $id
     * @return APIResponse
     * @throws EmptyDataException
     */
    public function show(RoleService $service, string $id): APIResponse
    {
        $response = $service->getDataBy($id);

        return $this->apiResponse(
            new RoleResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }


    /**
     * @param RoleService $service
     * @param StoreRoleRequest $request
     * @return APIResponse
     */
    public function store(RoleService $service, StoreRoleRequest $request): APIResponse
    {
        $response = $service->addNewData($request->validated());

        return $this->apiResponse(
            new RoleResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @param RoleService $service
     * @param UpdateRoleRequest $request
     * @param string $id
     * @return APIResponse
     * @throws EmptyDataException
     */
    public function update(RoleService $service, UpdateRoleRequest $request, string $id):APIResponse
    {
        $response = $service->updateDataById($id, $request->validated());

        return $this->apiResponse(
            new RoleResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
