<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AppServiceContract;
use OpenApi\Annotations as OA;

class AppController extends Controller
{
    protected AppServiceContract $appService;

    public function __construct(AppServiceContract $appService)
    {
        $this->appService = $appService;
    }

    /**
     * @return array
     *
     * @OA\Get(
     *     tags={"Конфигурация"},
     *     operationId="appConfig",
     *     summary="Получение конфигурации приложения",
     *     path="/api/v1/app/config",
     *     @OA\Response(
     *          description="Успешный ответ",
     *          response=200,
     *          @OA\JsonContent(type="object"),
     *     ),
     * )
     */
    public function config()
    {
        return $this->appService->config();
    }

    public function root()
    {
        return view('root');
    }
}
