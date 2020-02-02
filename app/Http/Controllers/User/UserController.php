<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    protected AuthServiceContract $authService;
    protected UserServiceContract $userService;

    public function __construct(AuthServiceContract $authService, UserServiceContract $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     tags={"Профиль"},
     *     operationId="userData",
     *     summary="Получить данные пользователя",
     *     path="/api/v1/user",
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     ),
     * )
     */
    public function data()
    {
        return new UserResource($this->userService->retrieve($this->authService->id()));
    }

    /**
     * @OA\Put(
     *     tags={"Профиль"},
     *     operationId="userUpdate",
     *     summary="Сохранить данные пользователя",
     *     path="/api/v1/user",
     *     @OA\RequestBody(
     *          description="Данные пользователя",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserUpdateRequest")
     *     ),
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/UserResource")
     *     ),
     * )
     */
    public function update(UserUpdateRequest $request)
    {
        return new UserResource($this->userService->store($this->authService->id(), $request->input()));
    }
}
