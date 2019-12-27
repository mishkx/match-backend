<?php

namespace App\Services;

use App\Contracts\Services\AccountContract;
use App\Models\Account\User;
use Auth;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;

class AccountService implements AccountContract
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    protected static function hashPassword($password)
    {
        return Hash::make($password);
    }

    public function id()
    {
        return $this->guard()->id();
    }

    public function user()
    {
        return $this->guard()->user();
    }

    public function guard()
    {
        return Auth::guard();
    }

    public function loginUsingId($id, $remember = false)
    {
        return $this->guard()->loginUsingId($id, $remember);
    }

    public function login(User $user, $remember = false)
    {
        return $user ? $this->loginUsingId($user->id, $remember) : false;
    }

    public function register($name, $email, $password, $passwordIsSet = false)
    {
        $user = $this->create([
            'name' => $name,
            'email' => $email,
            'password' => self::hashPassword($password),
            'password_is_set' => $passwordIsSet,
        ]);
        event(new Registered($user));
        return $user;
    }

    public function registerAndLogin($name, $email, $password, $remember = false)
    {
        $user = $this->register($name, $email, $password, true);
        $this->login($user, $remember);
        return $user;
    }

    public function registerWithoutPassword($name, $email)
    {
        return $this->register($name, $email, Str::random(), false);
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($data)
    {
        return $this->user()->update($data);
    }

    public function updatePassword($password)
    {
        return $this->update([
            'password' => self::hashPassword($password),
            'password_is_set' => true,
        ]);
    }
}
