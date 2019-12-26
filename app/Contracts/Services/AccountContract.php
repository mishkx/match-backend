<?php

namespace App\Contracts\Services;

use App\Models\Account\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;

interface AccountContract
{
    public function id();

    /**
     * @return User
     */
    public function user();

    /**
     * @return Guard|StatefulGuard
     */
    public function guard();

    public function loginUsingId($id, $remember = false);

    public function login(User $user, $remember = false);

    public function register($name, $email, $password);

    public function registerAndLogin($name, $email, $password, $remember = false);

    public function getByEmail($email);

    public function create($data);
}
