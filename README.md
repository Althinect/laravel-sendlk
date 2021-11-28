# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/althinect/laravel-sendlk.svg?style=flat-square)](https://packagist.org/packages/althinect/laravel-sendlk)
[![Total Downloads](https://img.shields.io/packagist/dt/althinect/laravel-sendlk.svg?style=flat-square)](https://packagist.org/packages/althinect/laravel-sendlk)
![GitHub Actions](https://github.com/althinect/laravel-sendlk/actions/workflows/main.yml/badge.svg)

This is a package for integrating Send.lk (https://send.lk) with a Laravel application. The packages supports custom configurations for credentials 
and logs for all sent messages. Moreover, these message logs can be pruned with a command which can be set up with scheduler for scheduled pruning. 

NOTE - This package is designed to be used for internal purposes of Althinect. However, you're free to use or modify the codebase. That being said, use at your
own discretion as the package might have breaking changes in the future.

## Installation

You can install the package via composer:

```bash
composer require althinect/laravel-sendlk
```

After installation. Run:

```bash
php artisan vendor:publish --provider="Althinect\LaravelSendlk\LaravelSendlkServiceProvider" --tag=config
```

## Usage

```php
LaravelSendlkFacade::send(['0000000000'], 'This is a test message');
```
The ```send``` method will accept two parameters. The first parameter is an array with the phone numbers to the send the message to. The second parameter is the message
to send. If the first parameter is not an array the package will throw an error. 

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email udamsliyanage@gmail.com instead of using the issue tracker.

## Credits

-   [Udam Liyanage](https://github.com/althinect)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
