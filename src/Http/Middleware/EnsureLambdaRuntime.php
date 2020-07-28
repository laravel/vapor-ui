<?php

namespace Laravel\VaporUi\Http\Middleware;

use Closure;

class EnsureLambdaRuntime
{
    /**
     * The configs that need to exist so we can ensure
     * that we have an environment that looks like Lambda Runtime.
     * 
     * @var array
     */
    protected $configs = [
        'project-env',
        'project-name',
        'region',
        'credentials.key',
        'credentials.secret'
    ];

    /**
     * Ensures requests are made using an environment
     * that looks like Lambda Runtime.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $message = app()->isLocal()
            ? "Vapor UI it's only available through the vanity URL."
            : 'You are not authorized to perform this action.xs';

        collect($this->configs)->each(function ($name) use ($message) {
            return abort_if(empty(config("vapor-ui.$name")), 403, $message);
        });

        return $next($request);
    }
}
