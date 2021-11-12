<?php

namespace Laravel\VaporUi;

use Aws\CloudWatch\CloudWatchClient;
use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Aws\Sqs\SqsClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\VaporUi\Concerns\ConfiguresVaporUi;

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
        Route::middlewareGroup('vapor-ui', config('vapor-ui.middleware', []));

        $this->registerRoutes();
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'vapor-ui');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/vapor-ui.php' => config_path('vapor-ui.php'),
            ], 'vapor-ui-config');

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/vapor-ui'),
            ], 'vapor-ui-assets');

            $this->publishes([
                __DIR__.'/../stubs/VaporUiServiceProvider.stub' => app_path('Providers/VaporUiServiceProvider.php'),
            ], 'vapor-ui-provider');

            $this->commands([
                Console\InstallCommand::class,
                Console\PublishCommand::class,
            ]);
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
        $this->mergeConfigFrom(__DIR__.'/../config/runtime.php', 'vapor-ui');

        $this->ensureVaporUiIsConfigured();

        $this->registerClients();
    }

    /**
     * Binds an implementation of the CloudWatch Client.
     *
     * @return void
     */
    public function registerClients()
    {
        collect([CloudWatchClient::class, CloudWatchLogsClient::class, SqsClient::class])->each(function ($client) {
            $this->app->singleton($client, function () use ($client) {
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

                return new $client($cloudWatchConfig);
            });
        });
    }

    /**
     * Register the Vapor UI routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'domain' => config('vapor-ui.domain', null),
            'prefix' => config('vapor-ui.path', 'vapor-ui'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }
}
