# Feefo

[![Build Status](https://img.shields.io/travis/BlueBayTravel/Feefo.svg?style=flat-square)](https://travis-ci.org/BlueBayTravel/Feefo)
[![StyleCI](https://styleci.io/repos/49071201/shield)](https://styleci.io/repos/49071201)

Laravel 5 wrapper for the [Feefo](https://www.feefo.com/documentation/feefo_integration.pdf#page=37) API.

```php
// Fetch reviews
Feefo::fetch()
```

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
composer require bluebaytravel/feefo
```

Add the service provider to `config/app.php` in the `providers` array.

```php
BlueBayTravel\Feefo\FeefoServiceProvider::class
```

If you want you can use the [facade](http://laravel.com/docs/facades). Add the reference in `config/app.php` to your aliases array.

```php
'Feefo' => BlueBayTravel\Feefo\Facades\Feefo::class
```

## Configuration

Feefo requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
php artisan vendor:publish
```

This will create a `config/feefo.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

## Testing

When running PHPUnit locally, you'll need to create a copy of `phpunit.xml.dist` as `phpunit.xml`, afterwards you'll need to modify both the `FEEFO_LOGON` and `FEEFO_PASSWORD` environment settings within the configuration.

# License

[MIT](/LICENSE)
