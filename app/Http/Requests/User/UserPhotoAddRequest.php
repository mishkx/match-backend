<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserPhotoAddRequest",
 *     type="object",
 *     required={
 *          "file",
 *     }
 * )
 */
class UserPhotoAddRequest extends FormRequest
{
    public function rules()
    {
        return [
            /**
             * @OA\Property(
             *      property="file",
             *      type="string",
             *      format="binary",
             * ),
             */
            'file' => ['required', 'image', 'max:' . config('medialibrary.max_file_size')],
        ];
    }
}
