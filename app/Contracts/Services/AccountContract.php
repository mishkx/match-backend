<?php

namespace App\Contracts\Services;

use App\Models\Account\User;

interface AccountContract
{
    public function loginUsingId($id, $remember = false);

    public function id();

    /**
     * @return User
     */
    public function user();

    public function getByEmail($email);

    public function create($data);
}
