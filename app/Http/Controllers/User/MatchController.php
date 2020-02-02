<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\MatchContract;
use App\Exceptions\MatchUserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Match\MatchesCollectionRequest;
use App\Http\Resources\IdResource;
use App\Http\Resources\User\ChosenUserResource;
use App\Http\Resources\User\MatchesCollectionItemResource;
use Symfony\Component\HttpFoundation\Response;

class MatchController extends Controller
{
    protected AuthServiceContract $authService;
    protected MatchContract $matchService;

    public function __construct(AuthServiceContract $authService, MatchContract $matchService)
    {
        $this->authService = $authService;
        $this->matchService = $matchService;
    }

    /**
     * @OA\Get(
     *     tags={"Совпадения"},
     *     operationId="matchesCollection",
     *     summary="Получить список совпадений",
     *     path="/api/v1/matches",
     *     @OA\RequestBody(
     *          description="Запрос для получения списка совпадений",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/MatchesCollectionRequest")
     *     ),
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(@OA\Items(ref="#/components/schemas/MatchesCollectionItemResource"))
     *     ),
     * )
     */
    public function collection(MatchesCollectionRequest $request)
    {
        return MatchesCollectionItemResource::collection($this->matchService->getItems(
            $this->authService->user(),
            $request->get('fromId')
        ));
    }

    /**
     * @OA\Get(
     *     tags={"Совпадения"},
     *     operationId="matchesSingle",
     *     summary="Получить совпавшего пользователя",
     *     path="/api/v1/matches/{id}",
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
    public function single($id)
    {
        try {
            return new ChosenUserResource($this->matchService->getUserInfo($this->authService->user(), $id));
        } catch (MatchUserNotFoundException $exception) {
            $code = Response::HTTP_NOT_FOUND;
            $message = $exception->getMessage();
            $exception = $exception->getTraceAsString();
        }
        return $this->sendError($code, $message, $exception);
    }

    /**
     * @OA\Delete(
     *     tags={"Совпадения"},
     *     operationId="matchesSingleDelete",
     *     summary="Удалить совпавшего пользователя",
     *     path="/api/v1/matches/{id}",
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
     *          @OA\JsonContent(ref="#/components/schemas/IdResource"),
     *     ),
     * )
     */
    public function delete($id)
    {
        return new IdResource($this->matchService->delete($this->authService->user(), $id));
    }
}
