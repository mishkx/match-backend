<?php

namespace App\Http\Requests\Match;

use App\Constants\ModelTable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="MatchUserRequest",
 *     type="object",
 *     required={
 *          "id",
 *     }
 * )
 */
class MatchUserRequest extends FormRequest
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
//            'id' => ['required']
        ];
    }
}
