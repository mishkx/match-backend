<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\ChoiceContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\ChosenUserResource;
use OpenApi\Annotations as OA;

class ChoiceController extends Controller
{
    protected AuthServiceContract $authService;
    protected ChoiceContract $choiceService;

    public function __construct(AuthServiceContract $authService, ChoiceContract $choiceService)
    {
        $this->authService = $authService;
        $this->choiceService = $choiceService;
    }

    /**
     * @OA\Post(
     *     tags={"Выбор"},
     *     operationId="choiceLike",
     *     summary="Лайк пользователя",
     *     path="/api/v1/choice/{id}/like",
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *     ),
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/ChosenUserResource")
     *     ),
     * )
     */
    public function like($id)
    {
        return new ChosenUserResource($this->choiceService->makeChoiceLike($this->authService->user(), $id));
    }

    /**
     * @OA\Post(
     *     tags={"Выбор"},
     *     operationId="choiceDisike",
     *     summary="Дизлайк пользователя",
     *     path="/api/v1/choice/{id}/dislike",
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *     ),
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/ChosenUserResource")
     *     ),
     * )
     */
    public function dislike($id)
    {
        return new ChosenUserResource($this->choiceService->makeChoiceDislike($this->authService->user(), $id));
    }
}
