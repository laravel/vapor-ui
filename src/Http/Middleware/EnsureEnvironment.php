<?php

namespace Laravel\VaporUi\Http\Middleware;

use Closure;

class EnsureEnvironment
{
    /**
     * The list of needed environment variables.
     *
     * @var array
     */
    protected $configs = [
        'project',
        'environment',
        'region',
        'credentials.key',
        'credentials.secret',
    ];

    /**
     * Ensures environment variables are properly configured.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $message = 'Unable to detect [vapor-ui.%s].';

        collect($this->configs)->each(function ($name) use ($message) {
            return abort_if(empty(config("vapor-ui.$name")), 500, sprintf($message, $name));
        });

        return $next($request);
    }
}
