<?php

namespace Laravel\VaporUi\Support;

use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Parser;

class Cloud
{
    /**
     * Guesses the environment from the cloud environment.
     *
     * @return string
     */
    public static function environment()
    {
        if (empty($ssmPath = static::ssmPath())) {
            return '';
        }

        $parts = explode('-', $ssmPath);

        return array_pop($parts);
    }

    /**
     * Guesses the project from the cloud environment.
     *
     * @return string
     */
    public static function project()
    {
        if (empty($ssmPath = static::ssmPath())) {
            return '';
        }

        $parts = explode('-', ltrim($ssmPath, '/'));
        array_pop($parts);

        return implode('-', $parts);
    }

    /**
     * Get the queue names to monitor.
     *
     * @return array
     */
    public static function queues()
    {
        return array_merge(self::guessQueues(), config('vapor-ui.queues', []));
    }

    /**
     * Guess the queues for the cloud environment.
     *
     * @return array
     */
    public static function guessQueues()
    {
        $prefix = config('vapor-ui.queue.prefix');

        if (empty($prefix)) {
            return [];
        }

        $vapor = (new Parser)->parse(file_get_contents(base_path('vapor.yml')));

        $environment = config('vapor-ui.environment');

        $queues = Arr::get(
            $vapor,
            "environments.$environment.queues",
            [config('vapor-ui.queue.name')]
        );

        return collect($queues)->map(function ($queue) use ($prefix) {
            return str_replace("$prefix/", '', $queue);
        })->unique()->values()->all();
    }

    /**
     * Gets the ssm path from the cloud environment.
     *
     * @return string
     */
    public static function ssmPath()
    {
        $ssmPath = $_ENV['VAPOR_SSM_PATH'] ?? '';

        return $ssmPath;
    }
}
