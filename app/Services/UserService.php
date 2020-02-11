<?php

namespace App\Services;

use App\Constants\UserConstants;
use App\Contracts\Services\UserServiceContract;
use App\Exceptions\UserPhotosCountExceededException;
use App\Models\Account\Preference;
use App\Models\Account\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Lang;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\Models\Media;

class UserService implements UserServiceContract
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function query()
    {
        return $this->model;
    }

    public function baseDataQuery(int $id)
    {
        return $this->query()
            ->where('id', $id)
            ->with([
                'preference',
                'media',
            ]);
    }

    public function getById(int $id)
    {
        return $this->query()->find($id);
    }

    public function getByEmail(string $email)
    {
        return $this->query()->where('email', $email)->first();
    }

    public function wasActiveRecently(int $id): bool
    {
        $user = $this->getById($id);
        if (!$user || !$state = $user->state) {
            return false;
        }
        return $state->updated_at->greaterThan(now()->subDay());
    }

    public function create(array $data)
    {
        return $this->query()->create($data);
    }

    public function retrieve(int $id)
    {
        return $this->baseDataQuery($id)->first();
    }

    public function store(int $id, array $requestData)
    {
        $requestData = collect($requestData);
        $requestPreferences = collect($requestData->get('preferences'));

        $user = $this->baseDataQuery($id)->first();
        $preference = $user->preference ?: new Preference();

        $user->update([
            'name' => $requestData->get('name'),
            'gender' => $requestData->get('gender'),
            'born_on' => $requestData->get('bornOn'),
            'description' => $requestData->get('description'),
        ]);

        $user->preference()->save($preference->fill([
            'gender' => $requestPreferences->get('gender'),
            'age_from' => $requestPreferences->get('ageFrom'),
            'age_to' => $requestPreferences->get('ageTo'),
            'max_distance' => $requestPreferences->get('maxDistance'),
        ]));

        return $user;
    }

    public function storePhoto(User $user, string $name, string $path)
    {
        if ($user->media()->count() >= UserConstants::MEDIA_COLLECTION_PHOTOS_ITEMS) {
            throw new UserPhotosCountExceededException(Lang::get("You can't add more than :count photos.", [
                'count' => UserConstants::MEDIA_COLLECTION_PHOTOS_ITEMS,
            ]));
        }

        $image = Image::load($path);

        $filename = Str::random() . '.' . UserConstants::MEDIA_COLLECTION_PHOTOS_FORMAT;

        $width = $image->getWidth();
        $height = $image->getHeight();
        $dimensionSize = max($width, $height);

        if ($dimensionSize > UserConstants::MEDIA_COLLECTION_PHOTOS_WIDTH) {
            $dimensionSize = UserConstants::MEDIA_COLLECTION_PHOTOS_WIDTH;
            $image->width($dimensionSize);
        }

        $image
            ->format(UserConstants::MEDIA_COLLECTION_PHOTOS_FORMAT)
            ->crop(Manipulations::CROP_CENTER, $dimensionSize, $dimensionSize)
            ->optimize()
            ->save();

        return $user->addMedia($path)
            ->usingName($name)
            ->usingFileName($filename)
            ->toMediaCollection(UserConstants::MEDIA_COLLECTION_PHOTOS);
    }

    public function deletePhoto(User $user, int $fileId)
    {
        $user->deleteMedia($fileId);
        return $user->getMedia(UserConstants::MEDIA_COLLECTION_PHOTOS)
            ->reject(function (Media $item) use ($fileId) {
                return $item->id === $fileId;
            });
    }

    // todo
    public function orderPhotos(User $user, array $fileIds, int $startOrder = 1)
    {
        $user->getMedia();

        collect($fileIds)->each(function ($fileId) use ($user, &$startOrder) {
            $model = $user->media()->find($fileId);
            if ($model) {
                $model->update([
                    'order_column' => $startOrder++,
                ]);
            }
        });
    }
}
