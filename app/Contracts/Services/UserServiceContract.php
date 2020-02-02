<?php

namespace App\Contracts\Services;

use App\Models\Account\User;
use Illuminate\Database\Eloquent\Builder;

interface UserServiceContract
{
    public function query();

    /**
     * @param int $id
     * @return Builder|User
     */
    public function baseDataQuery(int $id);

    public function getById(int $id);

    public function getByEmail(string $email);

    public function create(array $data);

    public function retrieve(int $id);

    public function store(int $id, array $requestData);

    public function storePhoto(User $user, string $name, string $path);

    public function deletePhoto(User $user, int $fileId);

    public function orderPhotos(User $user, array $fileIds, int $startOrder = 1);
}
