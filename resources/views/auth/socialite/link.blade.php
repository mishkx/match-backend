@if(SocialiteService::providerIsAvailable($name))
    <a class="btn btn-primary mb-3" href="{{route('oauth.login', ['provider' => $name])}}" target="_blank">
        {{__('Login with :provider', ['provider' => $title])}}
    </a>
@endif
