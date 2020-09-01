<?php

namespace Laravel\VaporUi\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RuntimeException;

class EnsureUpToDateAssets
{
    /**
     * Ensures assets are up to date.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (! app()->runningInConsole()) {
            $publishedPath = public_path('vendor/vapor-ui/mix-manifest.json');

            if (! File::exists($publishedPath)) {
                throw new RuntimeException('The Vapor UI assets are not published. Please run: `php artisan vapor-ui:install.');
            }

            if (File::get($publishedPath) !== File::get(__DIR__.'/../../../public/mix-manifest.json')) {
                throw new RuntimeException('The published Vapor UI assets are not up-to-date with the installed version.  Please run: `php artisan vapor-ui:publish`.');
            }
        }

        return $next($request);
    }
}
