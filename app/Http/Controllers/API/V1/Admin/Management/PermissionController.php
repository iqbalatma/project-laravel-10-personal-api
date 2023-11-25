<?php

namespace App\Http\Controllers\API\V1\Admin\Management;

use App\Http\Controllers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\Management\Permissions\PermissionResourceCollection;
use App\Services\Admin\Management\PermissionService;

class PermissionController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            "index" => "Get all data permission paginated successfully"
        ];
    }

    /**
     * @param PermissionService $service
     * @return APIResponse
     */
    public function index(PermissionService $service):APIResponse
    {
        $response = $service->getAllDataPaginated();

        return new APIResponse(
            new PermissionResourceCollection($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
