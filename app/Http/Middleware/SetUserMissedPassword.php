<?php

namespace App\Http\Middleware;

use Closure;
use Lang;
use AuthService;

class SetUserMissedPassword
{
    public function handle($request, Closure $next)
    {
        $user = AuthService::user();

        if ($user && !$user->password_is_set) {
            return redirect()
                ->route('password.save')
                ->with('error', Lang::get('Please set password.'));
        }

        return $next($request);
    }
}
