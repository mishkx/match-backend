<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\AuthServiceContract;
use App\Contracts\Services\ChatContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatListRequest;
use App\Http\Requests\Chat\ChatSingleRequest;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Http\Resources\Chat\ChatSentMessageResource;
use App\Http\Resources\Chat\ChatThreadResource;

class ChatController extends Controller
{
    protected AuthServiceContract $authService;
    protected ChatContract $chatService;

    public function __construct(AuthServiceContract $authService, ChatContract $chatService)
    {
        $this->authService = $authService;
        $this->chatService = $chatService;
    }

    /**
     * @OA\Get(
     *     tags={"Чат"},
     *     operationId="chatsCollection",
     *     summary="Получить список чатов",
     *     path="/api/v1/chats",
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(@OA\Items(ref="#/components/schemas/ChatThreadResource"))
     *     ),
     * )
     */
    public function collection(ChatListRequest $request)
    {
        return ChatThreadResource::collection($this->chatService->paginateThreads(
            $this->authService->user(),
            $request->get('fromId')
        ));
    }

    /**
     * @OA\Get(
     *     tags={"Чат"},
     *     operationId="chatsSingle",
     *     summary="Получить чат",
     *     path="/api/v1/chats/{id}",
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *     ),
     *     @OA\RequestBody(
     *          description="Запрос для получения списка сообщений",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ChatSingleRequest")
     *     ),
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/ChosenUserResource")
     *     ),
     * )
     */
    public function single(ChatSingleRequest $request, $id)
    {
        return new ChatThreadResource($this->chatService->paginateMessages(
            $this->authService->user(),
            $id,
            $request->get('fromMessageId')
        ));
    }

    /**
     * @OA\Post(
     *     tags={"Чат"},
     *     operationId="chatsMessageSeng",
     *     summary="Отправить сообщение",
     *     path="/api/v1/chats/{id}/message",
     *     @OA\Parameter(
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *     ),
     *     @OA\RequestBody(
     *          description="Данные сообения",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SendMessageRequest")
     *     ),
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(ref="#/components/schemas/ChatSentMessageResource")
     *     ),
     * )
     */
    public function sendMessage(SendMessageRequest $request, $id)
    {
        return new ChatSentMessageResource($this->chatService->createMessage(
            $this->authService->id(),
            $id,
            $request->get('content'),
            $request->get('token'),
            $request->get('sentAt')
        ));
    }
}
