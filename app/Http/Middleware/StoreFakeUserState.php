<?php

namespace App\Http\Middleware;

use App\Models\Account\State;
use AuthService;
use Closure;
use Illuminate\Http\Request;

class StoreFakeUserState
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
        $user = AuthService::user();

        $fakeState = factory(State::class)->make();
        $location = $fakeState->location;
        $ipAddress = $fakeState->ip_address;

        $state = $user->state ?: new State();

        $user->state()->save($state->fill([
            'session_id' => $request->session()->getId(),
            'location' => $location,
            'ip_address' => $ipAddress,
            'is_accurate' => true,
        ]));

        return $next($request);
    }
}
