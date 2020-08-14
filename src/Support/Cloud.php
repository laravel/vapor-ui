<?php

namespace Laravel\VaporUi\Support;

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
     * Gets the ssm path from the cloud environment.
     *
     * @return string
     */
    public static function ssmPath()
    {
        $ssmPath = $_ENV['VAPOR_SSM_PATH'] ?? '';

        return $ssmPath;
    }

    /**
     * Checks if the app is running in the vanity url.
     *
     * @return bool
     */
    public static function runningInVanityUrl()
    {
        return 'https://'.request()->getHttpHost() === ($_ENV['APP_VANITY_URL'] ?? null);
    }
}
