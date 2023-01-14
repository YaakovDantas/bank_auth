<?php

namespace App\Repositories;

use App\Entities\Account;
use App\Entities\User;

class UserRepository extends BaseRepository
{
    protected $account;
    
    public function __construct(User $model, Account $account)
    {
        $this->model = $model;
        $this->account = $account;
    }

    public function create($data)
    {
        $user = $this->model->create([
            'name' => $data['name'],
            'password' => $this->model->encryptPassword($data['password']),
            'is_adm' => isset($data['is_adm']) ? 1 : 0
        ]);

        $this->account->create(['user_id' => $user->id]);

        return $user;
    }
}
