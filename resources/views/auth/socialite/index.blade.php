<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        <div class="d-flex flex-column">
            @include('auth.socialite.link', ['name' => 'vkontakte', 'title' => 'VK'])
            @include('auth.socialite.link', ['name' => 'facebook', 'title' => 'Facebook'])
            @include('auth.socialite.link', ['name' => 'google', 'title' => 'Google'])
        </div>
    </div>
</div>
