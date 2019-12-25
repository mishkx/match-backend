<?php

namespace App\Contracts\Services;

interface AccountContract
{
    public function loginUsingId($id, $remember = false);

    public function id();

    public function user();

    public function getByEmail($email);

    public function create($data);
}
