<?php

namespace App\Http\Middleware;

use App\Objects\Enums\SessionKeys;
use Closure;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->session()->has(SessionKeys::USER_INFO)) {
            return redirect(route('showHomePage'));
        }

        return $next($request);
    }
}
