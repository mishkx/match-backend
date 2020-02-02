<?php

namespace App\Http\Resources\User;

use App\Presenters\UserPresenter;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ChosenUserResource",
 *     allOf={
 *          @OA\Schema(ref="#/components/schemas/RecommendedUserResource"),
 *          @OA\Schema(
 *              type="object",
 *              @OA\Property(
 *                   property="isMatched",
 *                   type="boolean",
 *              ),
 *              @OA\Property(
 *                   property="matchedAt",
 *                   type="string",
 *                   format=DATETIME_FORMAT,
 *                   nullable=true,
 *              ),
 *          ),
 *     },
 * )
 */
class ChosenUserResource extends RecommendedUserResource
{
    public function toArray($request)
    {
        $presenter = new UserPresenter($this->resource);

        return array_merge(parent::toArray($request), [
            'isMatched' => $presenter->getIsMatched(),
            'matchedAt' => $presenter->getMatchedAt(),
        ]);
    }
}
