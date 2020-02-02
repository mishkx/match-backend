<?php

namespace App\Services;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Models\Account\User;
use Auth;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class AuthService implements AuthServiceContract
{
    protected UserServiceContract $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    protected static function hashPassword(string $password): string
    {
        return Hash::make($password);
    }

    public function guard()
    {
        return Auth::guard();
    }

    public function id()
    {
        return $this->guard()->id();
    }

    public function user()
    {
        return $this->guard()->user();
    }

    public function loginUsingId(int $id, $remember = false)
    {
        return $this->guard()->loginUsingId($id, $remember);
    }

    public function login(User $user, $remember = false)
    {
        return $user ? $this->loginUsingId($user->id, $remember) : false;
    }

    public function register(string $name, string $email, string $password, $passwordIsSet = false)
    {
        $user = $this->userService->create([
            'name' => $name,
            'email' => $email,
            'password' => self::hashPassword($password),
            'password_is_set' => $passwordIsSet,
        ]);
        event(new Registered($user));
        return $user;
    }

    public function registerAndLogin(string $name, string $email, string $password, $remember = false)
    {
        $user = $this->register($name, $email, $password, true);
        $this->login($user, $remember);
        return $user;
    }

    public function registerWithoutPassword(string $name, string $email)
    {
        return $this->register($name, $email, Str::random(), false);
    }

    public function update(array $data)
    {
        return $this->user()->update($data);
    }

    public function updatePassword(string $password)
    {
        return $this->update([
            'password' => self::hashPassword($password),
            'password_is_set' => true,
        ]);
    }
}
