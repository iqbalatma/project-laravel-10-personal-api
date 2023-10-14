<?php

namespace App\Services\Admin\Management;
use App\Contracts\Abstracts\Services\BaseService;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService extends BaseService
{
    protected $repository;

    public function __construct()
    {
         $this->repository = new UserRepository();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllDataPaginated():LengthAwarePaginator
    {
        return $this->repository->getAllDataPaginated();
    }
}
