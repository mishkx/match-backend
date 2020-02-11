<?php

namespace App\Contracts\Services;

use Laravel\Socialite\Contracts\User;

interface SocialiteContract
{
    /**
     * @param string $provider
     * @return User
     */
    public function getProviderUser($provider);

    public function getAvailableProviders();

    public function providerIsAvailable($provider);

    public function getSocialAccount($provider, $providerUserId);

    public function getOrCreateUser($provider);

    public function auth($provider);
}
