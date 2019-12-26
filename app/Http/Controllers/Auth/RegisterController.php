<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\AccountContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use RedirectsUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
    protected $accountService;

    public function __construct(AccountContract $accountService)
    {
        $this->middleware('guest');
        $this->accountService = $accountService;
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $this->accountService->registerAndLogin(
            $request->get('name'),
            $request->get('email'),
            $request->get('password'),
            $request->get('remember'),
        );
        return redirect($this->redirectPath());
    }
}
