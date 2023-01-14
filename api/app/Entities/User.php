<?php

namespace App\Entities;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'password',
        'is_adm'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public static function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function checkPassword($password)
    {
        return password_verify($password, $this->password);
    }
}
