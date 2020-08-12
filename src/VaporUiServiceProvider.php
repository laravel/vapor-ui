<?php

namespace Laravel\VaporUi;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Illuminate\Support\ServiceProvider;
use Laravel\VaporUi\Repositories\LogsRepository;

class VaporUiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'vapor-ui');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/vapor-ui'),
            ], 'vapor-ui-assets');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/vapor-ui.php', 'vapor-ui');

        $this->app->singleton(LogsRepository::class, function () {
            $client = new CloudWatchLogsClient([
                'region' => config('vapor-ui.region'),
                'version' => 'latest',
                'credentials' => [
                    'key' => config('vapor-ui.credentials.key'),
                    'secret' => config('vapor-ui.credentials.secret'),
                    'token' => $_ENV['AWS_SESSION_TOKEN'] ?? null,
                ],
            ]);

            return new LogsRepository($client);
        });
    }
}
