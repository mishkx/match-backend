<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="IdRequest",
 *     type="object",
 *     required={
 *          "id",
 *     }
 * )
 */
class IdRequest extends FormRequest
{
    public function rules()
    {
        return [
            /**
             * @OA\Property(
             *      property="id",
             *      type="integer",
             * ),
             */
            'id' => ['required', 'integer'],
        ];
    }
}
