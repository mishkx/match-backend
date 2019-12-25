<?php

namespace App\Services;

use App\Contracts\Services\SocialiteContract;
use App\Exceptions\SocialiteAuthException;
use App\Models\Account\SocialAccount;
use Socialite;
use Exception;
use AccountService;

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

        $user = AccountService::getByEmail($providerUser->getEmail());

        if (!$user) {
            $user = AccountService::create([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
                'password' => md5(rand()),
            ]);
        }

        $socialAccount->user()->associate($user);
        $socialAccount->save();

        return $user;
    }

    public function auth($provider)
    {
        try {
            return AccountService::login($this->getOrCreateUser($provider));
        } catch (Exception $exception) {
            throw new SocialiteAuthException($exception);
        }
    }
}