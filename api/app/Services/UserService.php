<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        $this->NotFoundMessage = "Account not found!";
        $this->repository = $repository;
    }
}
