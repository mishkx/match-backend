<?php

namespace App\Services;

use App\Contracts\Services\AccountContract;
use App\Models\Account\User;
use Auth;
use Hash;
use Illuminate\Auth\Events\Registered;

class AccountService implements AccountContract
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
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

    public function register($name, $email, $password)
    {
        $user = $this->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        event(new Registered($user));
        return $user;
    }

    public function registerAndLogin($name, $email, $password, $remember = false)
    {
        $user = $this->register($name, $email, $password);
        $this->login($user, $remember);
        return $user;
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
