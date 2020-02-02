<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\AuthServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SavePasswordRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RedirectsUsers;

class SavePasswordController extends Controller
{
    use RedirectsUsers;

    protected string $redirectTo = RouteServiceProvider::HOME;

    protected AuthServiceContract $authService;

    public function __construct(AuthServiceContract $authService)
    {
        $this->authService = $authService;
    }

    public function showForm()
    {
        return view('auth.passwords.save');
    }

    public function savePassword(SavePasswordRequest $request)
    {
        $this->authService->updatePassword($request->get('password'));
        return redirect($this->redirectPath());
    }
}
