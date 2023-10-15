<?php

namespace App\Http\Controllers\API\V1\Admin\Management;

use App\Http\Controllers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\Management\Roles\RoleResource;
use App\Http\Resources\V1\Admin\Management\Roles\RoleResourceCollection;
use App\Services\Admin\Management\RoleService;

class RoleController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            "index" => "Get all data role paginated successfully",
            "indexAll" => "Get all data role successfully",
            "show" => "Get data role by id successfully",
        ];
    }

    /**
     * @param RoleService $service
     * @return APIResponse
     */
    public function index(RoleService $service):APIResponse
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
     */
    public function show(RoleService $service, string $id)
    {
        $response = $service->getDataBy($id);

        return $this->apiResponse(
            new RoleResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
