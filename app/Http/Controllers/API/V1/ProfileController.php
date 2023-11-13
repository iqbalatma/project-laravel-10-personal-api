<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Profiles\UpdatePasswordRequest;
use App\Http\Requests\V1\Profiles\UpdateProfileRequest;
use App\Http\Resources\V1\Profiles\ProfileResource;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Iqbalatma\LaravelUtils\APIResponse;

class ProfileController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            "show" => "Get current user profile successfully",
            "update" => "Update current user profile successfully",
            "updatePassword" => "Update current user password successfully",
        ];
    }

    /**
     * @param ProfileService $service
     * @return APIResponse
     */
    public function show(ProfileService $service): APIResponse
    {
        $response = $service->getCurrentUserData();

        return new APIResponse(
            new ProfileResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @param ProfileService $service
     * @param UpdateProfileRequest $request
     * @return APIResponse
     */
    public function update(ProfileService $service, UpdateProfileRequest $request): APIResponse
    {
        $response = $service->updateCurrentUserData($request->validated());

        return new APIResponse(
            new ProfileResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }

    /**
     * @param ProfileService $service
     * @param UpdatePasswordRequest $request
     * @return APIResponse
     */
    public function updatePassword(ProfileService $service, UpdatePasswordRequest $request):APIResponse
    {
        $response = $service->updatePasswordCurrentUser($request->validated());

        return new APIResponse(
            new ProfileResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );
    }
}
