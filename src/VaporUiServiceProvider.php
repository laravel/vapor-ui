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
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
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

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        $this->publishes([
            __DIR__.'/../config/vapor-ui.php' => config_path('vapor-ui.php'),
        ], 'vapor-ui-config');
    }
}