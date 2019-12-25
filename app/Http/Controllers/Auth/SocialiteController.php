<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\SocialiteContract;
use App\Exceptions\SocialiteAuthException;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Socialite;
use Lang;

class SocialiteController extends Controller
{
    use RedirectsUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    protected $socialiteService;

    public function __construct(SocialiteContract $socialiteService)
    {
        $this->socialiteService = $socialiteService;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            if ($this->socialiteService->auth($provider)) {
                return redirect()->to($this->redirectPath());
            }
        } catch (SocialiteAuthException $exception) {
            return redirect()
                ->route('login')
                ->with('error', Lang::get('Unable to authenticate. Please try again.'));
        }
    }
}
