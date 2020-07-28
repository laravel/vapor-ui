<?php

namespace Laravel\VaporUi;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Illuminate\Support\Facades\Route;
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

        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'vapor-ui'
        );
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
                    'secret' => config('vapor-ui.credentials.secret')
                ],
            ]);

            return new LogsRepository($client);
        });
    }
}
