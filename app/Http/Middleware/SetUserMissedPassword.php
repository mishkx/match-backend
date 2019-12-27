<?php

namespace App\Http\Middleware;

use AccountService;
use Closure;
use Lang;

class SetUserMissedPassword
{
    public function handle($request, Closure $next)
    {
        $user = AccountService::user();

        if ($user && !$user->password_is_set) {
            return redirect()
                ->route('password.save')
                ->with('error', Lang::get('Please set password.'));
        }

        return $next($request);
    }
}
