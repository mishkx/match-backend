<?php

namespace App\Services;

use App\Contracts\Services\AccountContract;
use App\Models\Account\User;
use Auth;

class AccountService implements AccountContract
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function loginUsingId($id, $remember = false)
    {
        return Auth::loginUsingId($id, $remember);
    }

    public function login(User $user)
    {
        return $user ? $this->loginUsingId($user->id) : false;
    }

    public function id()
    {
        return Auth::id();
    }

    public function user()
    {
        return Auth::user();
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
