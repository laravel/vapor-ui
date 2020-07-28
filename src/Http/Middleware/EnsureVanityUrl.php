<?php

namespace Laravel\VaporUi\Http\Middleware;

use Closure;

class EnsureVanityUrl
{
    /**
     * Ensures requests are made thought the vanity URL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // ..

        return $next($request);
    }
}
