<?php

namespace Laravel\VaporUi;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Laravel\VaporUi\Concerns\ConfiguresVaporUi;
use Laravel\VaporUi\Repositories\LogsRepository;

class VaporUiServiceProvider extends ServiceProvider
{
    use ConfiguresVaporUi;

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

            $this->publishes([
                __DIR__.'/../stubs/VaporUiServiceProvider.stub' => app_path('Providers/VaporUiServiceProvider.php'),
            ], 'vapor-ui-provider');
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
        $this->ensureVaporUiIsConfigured();

        $this->commands([
            Console\InstallCommand::class,
            Console\PublishCommand::class,
        ]);

        $this->app->singleton(LogsRepository::class, function () {
            $config = config('vapor-ui');

            $cloudWatchConfig = [
                'region' => $config['region'],
                'version' => 'latest',
            ];

            if ($config['key'] && $config['secret']) {
                $cloudWatchConfig['credentials'] = Arr::only(
                    $config, ['key', 'secret', 'token']
                );
            }

            return new LogsRepository(
                new CloudWatchLogsClient($cloudWatchConfig)
            );
        });
    }
}
