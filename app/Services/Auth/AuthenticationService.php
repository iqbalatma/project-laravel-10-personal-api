<?php

namespace App\Services\Auth;
use App\Contracts\Abstracts\Services\BaseService;
use Iqbalatma\LaravelJwtAuth\Services\JWTService;
use Throwable;

class AuthenticationService extends BaseService
{
    protected $repository;

    public function __construct()
    {
        // $this->repository
    }

    /**
     * @param array $credentials
     * @return array
     * @throws Throwable
     */
    public function authenticate(array $credentials):array
    {
        $jwtService = new JWTService();
        return [
          "access_token" => $jwtService->invokeAccessToken($credentials),
          "refresh_token" => $jwtService->invokeRefreshToken()
        ];
    }
}
