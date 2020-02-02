<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\RecommendationContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\RecommendedUserResource;

class RecommendationController extends Controller
{
    protected AuthServiceContract $authService;
    protected RecommendationContract $recommendationService;

    public function __construct(AuthServiceContract $authService, RecommendationContract $recommendationService)
    {
        $this->authService = $authService;
        $this->recommendationService = $recommendationService;
    }

    /**
     * @OA\Get(
     *     tags={"Рекомендации"},
     *     operationId="recommendationCollection",
     *     summary="Получить список рекомендаций",
     *     path="/api/v1/recommendations",
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(@OA\Items(ref="#/components/schemas/RecommendedUserResource"))
     *     ),
     * )
     */
    public function collection()
    {
        return RecommendedUserResource::collection($this->recommendationService->getItems($this->authService->user()));
    }
}
