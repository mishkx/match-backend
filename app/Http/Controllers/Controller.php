<?php

namespace App\Http\Controllers;

use App\Http\Resources\ErrorResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendError($code, $message = null, $exception = null)
    {
        $response = [
            'message' => $message ?? Response::$statusTexts[$code],
        ];
        if (config('app.debug')) {
            $response['exception'] = $exception;
        }
        if (request()->ajax()) {
            return response()->json(new ErrorResource($response), $code);
        }
        return abort($code, $message);
    }
}
