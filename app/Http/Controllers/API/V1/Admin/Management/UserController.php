<?php

namespace App\Http\Controllers\API\V1\Admin\Management;

use App\Http\Controllers\APIResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Admin\Management\Users\UserResource;
use App\Http\Resources\V1\Admin\Management\Users\UserResourceCollection;
use App\Models\User;
use App\Services\Admin\Management\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            "index" => "Get all data paginated successfully"
        ];
    }

    /**
     * @param UserService $service
     * @return APIResponse
     */
    public function index(UserService $service): APIResponse
    {
        $response = $service->getAllDataPaginated();
        return $this->apiResponse(
            new UserResourceCollection($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
