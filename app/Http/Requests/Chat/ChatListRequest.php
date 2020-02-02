<?php

namespace App\Http\Requests\Chat;

use App\Constants\AppConstants;
use App\Constants\ChatConstants;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ChatListRequest",
 *     type="object",
 * )
 */
class ChatListRequest extends FormRequest
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
            'fromId' => ['integer'],
        ];
    }
}
