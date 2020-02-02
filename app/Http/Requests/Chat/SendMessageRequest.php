<?php

namespace App\Http\Requests\Chat;

use App\Constants\AppConstants;
use App\Constants\ChatConstants;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SendMessageRequest",
 *     type="object",
 *     required={
 *          "userId",
 *          "content",
 *          "token",
 *          "sentAt",
 *     },
 * )
 */
class SendMessageRequest extends FormRequest
{
    public function rules()
    {
        return [
            /**
             * @OA\Property(
             *      property="content",
             *      type="string",
             * ),
             */
            'content' => ['required', 'string', 'max:' . ChatConstants::MAX_MESSAGE_CONTENT_LENGTH],

            /**
             * @OA\Property(
             *      property="token",
             *      type="string",
             * ),
             */
            'token' => ['required', 'string', 'max:' . ChatConstants::MAX_MESSAGE_TOKEN_LENGTH],

            /**
             * @OA\Property(
             *      property="sentAt",
             *      type="string",
             *      format=DATETIME_FORMAT,
             * ),
             */
            'sentAt' => ['required', 'string', 'date_format:' . AppConstants::DATETIME_FORMAT],
        ];
    }
}
