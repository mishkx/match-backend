<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Services\SocialiteContract;
use App\Exceptions\SocialiteAuthException;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Socialite;
use Lang;
use Symfony\Component\HttpFoundation\Response;

class SocialiteController extends Controller
{
    use RedirectsUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    protected SocialiteContract $socialiteService;

    public function __construct(SocialiteContract $socialiteService)
    {
        $this->socialiteService = $socialiteService;
    }

    public function redirectToProvider($provider)
    {
        if (!$this->socialiteService->providerIsAvailable($provider)) {
            return $this->sendError(Response::HTTP_NOT_FOUND);
        }
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        if (!$this->socialiteService->providerIsAvailable($provider)) {
            return $this->sendError(Response::HTTP_NOT_FOUND);
        }
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
