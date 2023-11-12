<?php

namespace App\Services\Auth;

use App\Contracts\Abstracts\Services\BaseService;
use Illuminate\Support\Facades\Auth;
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
    public function authenticate(array $credentials): array
    {
        /** @var array $authenticated */
        $authenticated = Auth::attempt($credentials, true);
        return [
            "token" => [
                "access_token" => $authenticated["access_token"],
                "refresh_token" => $authenticated["refresh_token"],
                "type" => "Bearer"
            ],
            "user" => Auth::user()
        ];
    }

    /**
     * @return array
     */
    public function refreshToken(): array
    {
        $refreshedToken = Auth::refreshToken(Auth::user());
        return [
            "token" => [
                "access_token" => $refreshedToken["access_token"],
                "refresh_token" => $refreshedToken["refresh_token"],
                "type" => "Bearer"
            ],
            "user" => Auth::user()
        ];
    }
}
