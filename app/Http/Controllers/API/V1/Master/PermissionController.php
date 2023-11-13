<?php

namespace App\Http\Controllers\API\V1\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Master\PermissionResourceCollection;
use App\Services\Master\PermissionService;
use Iqbalatma\LaravelUtils\APIResponse;

class PermissionController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            "__invoke" => "Get all data permission successfully",
        ];
    }

    /**
     * @param PermissionService $service
     * @return APIResponse
     */
    public function __invoke(PermissionService $service):APIResponse
    {
        $response = $service->getAllData();

        return new APIResponse(
            new PermissionResourceCollection($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
