<?php

namespace App\Http\Requests\Match;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="MatchesCollectionRequest",
 *     type="object",
 * )
 */
class MatchesCollectionRequest extends FormRequest
{
    public function rules()
    {
        return [
            /**
             * @OA\Property(
             *      property="fromId",
             *      type="integer",
             * ),
             */
            'fromId' => ['integer']
        ];
    }
}
