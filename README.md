<p align="center">
    <a href="https://github.com/laravel/vapor-ui/actions"><img src="https://github.com/laravel/vapor-ui/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/vapor-ui"><img src="https://poser.pugx.org/laravel/vapor-ui/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/vapor-ui"><img src="https://poser.pugx.org/laravel/vapor-ui/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/vapor-ui"><img src="https://poser.pugx.org/laravel/vapor-ui/license.svg" alt="License"></a>
</p>

## Introduction

Vapor Ui provides a beautiful dashboard to monitor your Laravel serverless infrastructure. It gives you easy access to a variety of metrics from across all your AWS resources.

<a name="installation"></a>
## Installation

You may use Composer to install Vapor Ui into your Laravel project:
```bash
composer config repositories.vapor-ui vcs https://github.com/laravel/vapor-ui
composer require laravel/vapor-ui --dev
```

After installing Vapor Ui, publish its assets using the `vapor-ui:install` Artisan command:
```bash
php artisan vapor-ui:install
```

Next, re-deploy your project using Vapor CLI:
```bash
vapor deploy
```

Finally, visit the Vapor Ui dashboard thought the vanity URL:
```
https://your-vanity-url.com/vapor-ui
```

**Warning**: Did your project got first deployed with Vapor before the XX/XX/2020? You may have to perform these additional steps: 

1. Edit the `laravel-vapor-role-policy` here: [console.aws.amazon.com/iam/home](https://console.aws.amazon.com/iam/home#/roles/laravel-vapor-role$jsonEditor?policyName=laravel-vapor-role-policy&step=edit)
2. Head over to CloudWatch Logs > Actions > Read
3. Next, select `FilterLogEvents`
4. Finally, click in `Review the policy` and `Save changes`

<a name="local-environment"></a>
### Local Environment

If for some reason, you can't access your application thought the vanity URL, you may want to use Vapor Ui in your local environment. And, for that, you need to set the following environment variables:
```
VAPOR_PROJECT=
VAPOR_ENVIRONMENT=
AWS_REGION=
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
```

<a name="dashboard-authorization"></a>
### Dashboard Authorization

Vapor Ui exposes a dashboard at `/vapor-ui`. You will only be able to access this dashboard in the `local` environment or the thought the vanity URL. Within your `app/Providers/VaporUiServiceProvider.php` file, there is a `gate` method. This authorization gate controls access to Vapor Ui thought the **vanity URL**. You are free to modify this gate as needed to restrict access to your Vapor Ui dashboard:
```php
/**
 * Register the Vapor Ui gate.
 *
 * This gate determines who can access Vapor Ui thought the vanity URL.
 *
 * @return void
 */
protected function gate()
{
    Gate::define('viewVaporUi', function ($user) {
        return in_array($user->email, [
            'taylor@laravel.com',
        ]);
    });
}
```

<a name="upgrading-vapor-ui"></a>
## Upgrading Vapor Ui

When upgrading to a new version of Vapor Ui, you should re-publish Vapor Ui's assets:
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

Thank you for considering contributing to Vapor Ui! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

Please review [our security policy](https://github.com/laravel/vapor-ui/security/policy) on how to report security vulnerabilities.

## License

Laravel Vapor Ui is open-sourced software licensed under the [MIT license](LICENSE.md).
