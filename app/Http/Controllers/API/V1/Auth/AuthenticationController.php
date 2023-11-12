<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\AuthenticateRequest;
use App\Http\Resources\V1\Auth\AuthenticateResource;
use App\Services\Auth\AuthenticationService;
use Iqbalatma\LaravelUtils\APIResponse;
use Throwable;

class AuthenticationController extends Controller
{
    protected array $responseMessages;

    public function __construct()
    {
        $this->responseMessages = [
            "authenticate" => "Authenticate user successfully"
        ];
    }


    /**
     * @param AuthenticationService $service
     * @param AuthenticateRequest $request
     * @return APIResponse
     * @throws Throwable
     */
    public function authenticate(AuthenticationService $service, AuthenticateRequest $request):APIResponse
    {
        $response = $service->authenticate($request->validated());

        return new APIResponse(
            new AuthenticateResource($response),
            $this->getResponseMessage(__FUNCTION__)
        );

    }
}
