<p align="center">
    <a href="https://github.com/laravel/vapor-ui/actions"><img src="https://github.com/laravel/vapor-ui/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/vapor-ui"><img src="https://poser.pugx.org/laravel/vapor-ui/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/vapor-ui"><img src="https://poser.pugx.org/laravel/vapor-ui/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/vapor-ui"><img src="https://poser.pugx.org/laravel/vapor-ui/license.svg" alt="License"></a>
</p>

## Introduction

Vapor UI provides a beautiful dashboard to monitor your Laravel serverless infrastructure. It gives you easy access to a variety of metrics across all of your AWS resources.

<a name="installation"></a>
## Installation

You may use Composer to install Vapor UI into your Laravel project:

```bash
composer require laravel/vapor-ui
```

After installing Vapor UI, publish its assets using the `vapor-ui:install` Artisan command:

```bash
php artisan vapor-ui:install
```

Then, you should configure the [dashboard authorization](#dashboard-authorization) using the `gate` method in your `app/Providers/VaporUIServiceProvider.php` file.

Next, re-deploy your Laravel Vapor project using the Vapor CLI:

```bash
vapor deploy
```

Finally, visit the Vapor UI dashboard through the vanity URL:

```
https://your-vanity-url.com/vapor-ui
```

<a name="local-environment"></a>
### Local Environment

If for some reason you can't access your application through the vanity URL, you may use Vapor UI in your local environment. First, you must set the following environment variables:

```
AWS_ACCESS_KEY_ID=
AWS_DEFAULT_REGION=
AWS_SECRET_ACCESS_KEY=
VAPOR_ENVIRONMENT=
VAPOR_PROJECT=
```

<a name="dashboard-authorization"></a>
### Dashboard Authorization

Vapor UI exposes a dashboard at `/vapor-ui`. By default, you will only be able to access this dashboard in the `local` environment. Within your `app/Providers/VaporUIServiceProvider.php` file, there is a `gate` method. This authorization gate controls access to Vapor UI in **non-local** environments. You are free to modify this gate as needed to restrict access to your Vapor UI dashboard:

```php
/**
 * Register the Vapor UI gate.
 *
 * This gate determines who can access Vapor UI through the vanity URL.
 *
 * @return void
 */
protected function gate()
{
    Gate::define('viewVaporUI', function ($user) {
        return in_array($user->email, [
            'taylor@laravel.com',
        ]);
    });
}
```

<a name="upgrading-vapor-ui"></a>
## Upgrading Vapor UI

When upgrading to a new version of Vapor UI, you should re-publish Vapor UI's assets:

```bash
php artisan vapor-ui:publish
```

To keep the assets up-to-date and avoid issues in future updates, you may add the `vapor-ui:publish` command to the `post-update-cmd` scripts in your application's `composer.json` file:

```json
    {
        "scripts": {
            "post-update-cmd": [
                "@php artisan vapor-ui:publish --ansi"
            ]
        }
    }
```

## Contributing

Thank you for considering contributing to Vapor UI! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

Please review [our security policy](https://github.com/laravel/vapor-ui/security/policy) on how to report security vulnerabilities.

## License

Laravel Vapor UI is open-sourced software licensed under the [MIT license](LICENSE.md).
