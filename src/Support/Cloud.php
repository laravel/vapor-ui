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

        /**
         * Here we pop the last part from the ssm path
         * string, and we keep the last part is the
         * environment of the project.
         */
        $parts = explode('-', $ssmPath);
        $environment = array_pop($parts);

        return $environment;
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

        /**
         * Here we pop the last part from the ssm path
         * string, and we keep the rest assuming that
         * is the project name.
         */
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
     * Checks if the app is running under the vanity url.
     *
     * @return bool
     */
    public static function runningInVanityUrl()
    {
        return 'https://'.request()->getHttpHost() === ($_ENV['APP_VANITY_URL'] ?? null);
    }
}
