<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\UserServiceContract;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Symfony\Component\HttpFoundation\Response;

class LoginAsController extends Controller
{
    use RedirectsUsers;

    protected string $redirectTo = RouteServiceProvider::HOME;
    protected UserServiceContract $userService;

    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
    }

    public function loginAs($id)
    {
        if (!config('options.faker')) {
            return $this->sendError(Response::HTTP_NOT_FOUND);
        }
        $user = $this->userService->getById($id);
        if (!$user) {
            return $this->sendError(Response::HTTP_NOT_FOUND);
        }
        $this->userService->login($user);
        return redirect()->to($this->redirectPath());
    }
}
