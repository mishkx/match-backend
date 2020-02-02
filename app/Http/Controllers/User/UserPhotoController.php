<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Exceptions\UserPhotosCountExceededException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\IdRequest;
use App\Http\Requests\User\UserPhotoAddRequest;
use App\Http\Resources\MediaResource;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;

class UserPhotoController extends Controller
{
    protected AuthServiceContract $authService;
    protected UserServiceContract $userService;

    public function __construct(AuthServiceContract $authService, UserServiceContract $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     tags={"Профиль"},
     *     operationId="userPhotoAdd",
     *     summary="Добавить фото пользователя",
     *     path="/api/v1/user/photo",
     *     @OA\RequestBody(
     *          description="Запрос с фоторафией",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/UserPhotoAddRequest")
     *          )
     *     ),
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/MediaResource")
     *     ),
     * )
     */
    public function add(UserPhotoAddRequest $request)
    {
        try {
            $file = $request->file('file');
            return new MediaResource($this->userService->storePhoto(
                $this->authService->user(),
                $file->getClientOriginalName(),
                $file->path()
            ));
        } catch (UserPhotosCountExceededException $exception) {
            $code = Response::HTTP_NOT_ACCEPTABLE;
            $message = $exception->getMessage();
        }
        return $this->sendError($code, $message);
    }

    /**
     * @OA\Delete(
     *     tags={"Профиль"},
     *     operationId="userPhotoDelete",
     *     summary="Удалить фото пользователя",
     *     path="/api/v1/user/photo",
     *     @OA\RequestBody(
     *          description="Данные пользователя",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/IdRequest"),
     *     ),
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(@OA\Items(ref="#/components/schemas/MediaResource")),
     *     ),
     * )
     */
    public function delete(IdRequest $request)
    {
        return MediaResource::collection($this->userService->deletePhoto(
            $this->authService->user(),
            $request->get('id'),
        ));
    }
}
