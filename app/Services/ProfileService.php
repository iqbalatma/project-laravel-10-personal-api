<?php

namespace App\Services;

use App\Contracts\Abstracts\Services\BaseService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class ProfileService extends BaseService
{
    /**
     * @return User
     */
    public function getCurrentUserData(): User
    {
        return Auth::user();
    }


    /**
     * @param array $requestedData
     * @return User
     */
    public function updateCurrentUserData(array $requestedData): User
    {
        DB::beginTransaction();
        $user = Auth::user();
        $user->fill($requestedData)->save();
        if (isset($requestedData["profile"])) {
            $user->profile->fill($requestedData["profile"])->save();
        }
        DB::commit();
        return $user;
    }


    /**
     * @param array $requestedData
     * @return User
     */
    public function updatePasswordCurrentUser(array $requestedData): User
    {
        DB::beginTransaction();
        $user = Auth::user();
        if (Hash::check($requestedData["old_password"], $user->password)){
            $user->password = $requestedData["new_password"];
            $user->save();
        }else{
            throw new UnauthorizedException("Your old password is invalid");
        }
        DB::commit();

        return $user;
    }
}
