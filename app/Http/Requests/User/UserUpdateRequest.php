<?php

namespace App\Http\Requests\User;

use App\Constants\AppConstants;
use App\Constants\UserConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserUpdateRequest",
 *     type="object",
 *     required={
 *          "name",
 *          "bornOn",
 *          "gender",
 *          "preferences",
 *     }
 * )
 */
class UserUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            /**
             * @OA\Property(
             *      property="name",
             *      type="string",
             * ),
             */
            'name' => ['required', 'string', 'max:' . UserConstants::MAX_NAME_LENGTH],

            /**
             * @OA\Property(
             *      property="bornOn",
             *      type="string",
             *      format=DATE_FORMAT,
             * ),
             */
            'bornOn' => [
                'required',
                'date_format:' . AppConstants::DATE_FORMAT,
                'after_or_equal:' . now()->subYears(UserConstants::MAX_AGE),
                'before_or_equal:' . now()->subYears(UserConstants::MIN_AGE),
            ],

            /**
             * @OA\Property(
             *      property="gender",
             *      type="string",
             *      enum={USER_GENDER_MALE, USER_GENDER_FEMALE}
             * ),
             */
            'gender' => ['required', Rule::in([
                UserConstants::GENDER_MALE,
                UserConstants::GENDER_FEMALE,
            ])],

            /**
             * @OA\Property(
             *      property="description",
             *      type="string",
             * ),
             */
            'description' => ['string', 'max:' . UserConstants::MAX_DESCRIPTION_LENGTH],

            /**
             * @OA\Property(
             *      property="preferences",
             *      type="object",
             *      @OA\Property(
             *           property="ageFrom",
             *           type="integer",
             *      ),
             *      @OA\Property(
             *           property="ageTo",
             *           type="integer",
             *      ),
             *      @OA\Property(
             *           property="gender",
             *           type="string",
             *           enum={USER_GENDER_MALE, USER_GENDER_FEMALE}
             *      ),
             *      @OA\Property(
             *           property="maxDistance",
             *           type="integer",
             *      ),
             * ),
             */
            'preferences.ageFrom' => ['required', 'integer', 'min:' . UserConstants::MIN_AGE, 'max:' . UserConstants::MAX_AGE],
            'preferences.ageTo' => ['required', 'integer', 'gte:preferences.ageTo', 'max:' . UserConstants::MAX_AGE],
            'preferences.gender' => ['required', Rule::in([
                UserConstants::GENDER_MALE,
                UserConstants::GENDER_FEMALE,
            ])],
            'preferences.maxDistance' => ['required', 'integer', 'min:' . UserConstants::MIN_DISTANCE, 'max:' . UserConstants::MAX_DISTANCE],
        ];
    }
}
