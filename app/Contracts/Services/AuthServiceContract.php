<?php

namespace App\Contracts\Services;

use App\Models\Account\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;

interface AuthServiceContract
{
    /**
     * @return Guard|StatefulGuard
     */
    public function guard();

    public function id();

    /**
     * @return User
     */
    public function user();

    public function loginUsingId(int $id, $remember = false);

    public function login(User $user, $remember = false);

    public function register(string $name, string $email, string $password, $passwordIsSet = false);

    public function registerAndLogin(string $name, string $email, string $password, $remember = false);

    public function registerWithoutPassword(string $name, string $email);

    // todo
    public function update(array $data);

    public function updatePassword(string $password);
}
