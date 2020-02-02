<?php

namespace App\Http\Requests\Chat;

use App\Constants\AppConstants;
use App\Constants\ChatConstants;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ChatSingleRequest",
 *     type="object"
 * )
 */
class ChatSingleRequest extends FormRequest
{
    public function rules()
    {
        return [
            /**
             * @OA\Property(
             *      property="fromMessageId",
             *      type="integer",
             * ),
             */
            'fromMessageId' => ['integer'],
        ];
    }
}
