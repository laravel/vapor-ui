<?php

namespace Laravel\VaporUi\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\VaporUi\Support\Cloud;

class EnsureUserIsAuthorized
{
    /**
     * Ensures the user is authorized to visit Vapor Ui Dashboard.
     *
     * @param  Request  $request
     * @param Closure $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $allowed = app()->environment('local')
            || app()->environment('testing')
            || (Cloud::runningInVanityUrl() && Gate::allows('viewVaporUi', [$request->user()]));

        abort_unless($allowed, 403);

        return $next($request);
    }
}
