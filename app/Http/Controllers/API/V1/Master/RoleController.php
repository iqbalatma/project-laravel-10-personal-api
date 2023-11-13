<?php

namespace App\Http\Controllers\API\V1\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Master\RoleResourceCollection;
use App\Services\Master\RoleService;
use Iqbalatma\LaravelUtils\APIResponse;

class RoleController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            "__invoke" => "Get all data role successfully",
        ];
    }

    /**
     * @param RoleService $service
     * @return APIResponse
     */
    public function __invoke(RoleService $service):APIResponse
    {
        $response = $service->getAllData();

        return new APIResponse(
            new RoleResourceCollection($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
