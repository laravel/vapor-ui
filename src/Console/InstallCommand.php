<?php

namespace Laravel\VaporUi\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vapor-ui:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Vapor Ui resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Vapor Ui Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'vapor-ui-provider']);

        $this->comment('Publishing Vapor Ui Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'vapor-ui-assets']);

        $this->registerVaporUiServiceProvider();

        $this->info('Vapor Ui scaffolding installed successfully.');
    }

    /**
     * Register the Vapor Ui service provider in the application configuration file.
     *
     * @return void
     */
    protected function registerVaporUiServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->laravel->getNamespace());

        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace.'\\Providers\\VaporUiServiceProvider::class')) {
            return;
        }

        $lineEndingCount = [
            "\r\n" => substr_count($appConfig, "\r\n"),
            "\r" => substr_count($appConfig, "\r"),
            "\n" => substr_count($appConfig, "\n"),
        ];

        $eol = array_keys($lineEndingCount, max($lineEndingCount))[0];

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\RouteServiceProvider::class,".$eol,
            "{$namespace}\\Providers\RouteServiceProvider::class,".$eol."        {$namespace}\Providers\VaporUiServiceProvider::class,".$eol,
            $appConfig
        ));

        file_put_contents(app_path('Providers/VaporUiServiceProvider.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/VaporUiServiceProvider.php'))
        ));
    }
}
