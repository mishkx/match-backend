<?php

namespace App\Services;

use App\Contracts\Services\SocialiteContract;
use App\Exceptions\SocialiteAuthException;
use App\Models\Account\SocialAccount;
use Socialite;
use Exception;
use AuthService;
use UserService;

class SocialiteService implements SocialiteContract
{
    protected $model;

    public function __construct(SocialAccount $socialAccount)
    {
        $this->model = $socialAccount;
    }

    public function getProviderUser($provider)
    {
        return Socialite::driver($provider)->user();
    }

    public function getSocialAccount($provider, $providerUserId)
    {
        return $this->model->firstOrCreate([
            'provider' => $provider,
            'provider_user_id' => $providerUserId,
        ]);
    }

    public function getOrCreateUser($provider)
    {
        $providerUser = $this->getProviderUser($provider);
        $socialAccount = $this->getSocialAccount($provider, $providerUser->getId());

        if ($socialAccount->user) {
            return $socialAccount->user;
        }

        $user = UserService::getByEmail($providerUser->getEmail());

        if (!$user) {
            $user = AuthService::registerWithoutPassword(
                $providerUser->getName(),
                $providerUser->getEmail()
            );
        }

        $socialAccount->user()->associate($user);
        $socialAccount->save();

        return $user;
    }

    public function auth($provider)
    {
        try {
            return AuthService::login($this->getOrCreateUser($provider));
        } catch (Exception $exception) {
            throw new SocialiteAuthException($exception);
        }
    }
}
