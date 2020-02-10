<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->getPreferredLanguage(config('options.locales'));
        app()->setLocale($locale);
        return $next($request);
    }
}
