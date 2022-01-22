<?php

namespace App\Http\Middleware;

use App\MyAppConstants;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {

        if(env('VUE_APP_ENV') != MyAppConstants::VUE_APP_ENV){
            $this->authenticate($request, $guards);
        }

        return $next($request);

    }
}
