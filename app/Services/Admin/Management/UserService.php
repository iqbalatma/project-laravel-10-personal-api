<?php

namespace App\Services\Admin\Management;
use App\Contracts\Abstracts\Services\BaseService;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends BaseService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAllDataPaginated():LengthAwarePaginator
    {
        return UserRepository::getAllDataPaginated();
    }
}
