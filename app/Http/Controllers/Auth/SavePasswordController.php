<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\AccountContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SavePasswordRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RedirectsUsers;

class SavePasswordController extends Controller
{
    use RedirectsUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    protected $accountService;

    public function __construct(AccountContract $accountService)
    {
        $this->accountService = $accountService;
    }

    public function showForm()
    {
        return view('auth.passwords.save');
    }

    public function savePassword(SavePasswordRequest $request)
    {
        $this->accountService->updatePassword($request->get('password'));
        return redirect($this->redirectPath());
    }
}
