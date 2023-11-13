<?php

namespace App\Services;
use App\Contracts\Abstracts\Services\BaseService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isFalse;

class ProfileService extends BaseService
{
    protected $repository;

    public function __construct()
    {
        // $this->repository
    }


    /**
     * @return User
     */
    public function getCurrentUserData():User
    {
        return Auth::user();
    }


    /**
     * @param array $requestedData
     * @return User
     */
    public function updateCurrentUserData(array $requestedData):User
    {
        DB::beginTransaction();
        $user = Auth::user();
        $user->fill($requestedData)->save();
        if (isset($requestedData["profile"])){
            $user->profile->fill($requestedData["profile"])->save();
        }
        DB::commit();
        return $user;
    }
}
