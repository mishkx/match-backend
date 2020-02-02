<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\AuthServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RedirectsUsers;

class RegisterController extends Controller
{
    use RedirectsUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    protected AuthServiceContract $authService;

    public function __construct(AuthServiceContract $authService)
    {
        $this->middleware('guest');
        $this->authService = $authService;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $this->authService->registerAndLogin(
            $request->get('name'),
            $request->get('email'),
            $request->get('password'),
            $request->get('remember'),
        );
        return redirect($this->redirectPath());
    }
}
