<div class="filament-hidden">

![Filament One Time Operations](https://raw.githubusercontent.com/jeffersongoncalves/filament-one-time-operations/master/art/jeffersongoncalves-filament-one-time-operations.png)

</div>

# Filament One Time Operations

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/filament-one-time-operations.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-one-time-operations)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/filament-one-time-operations/fix-php-code-style-issues.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/filament-one-time-operations/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/filament-one-time-operations.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/filament-one-time-operations)

This is a Laravel Filament package that provides a One Time Operations functionality for web applications. The package is based on the `timokoerber/laravel-one-time-operations` library, which is used as a dependency to implement this Filament plugin.

### Key Features
- Integration with the Laravel Filament framework
- Admin interface for managing operations that need to be executed only once
- Easy implementation through a configurable plugin
- Logging and tracking of executed one-time operations in the system

### How It Works
The package provides a plugin for Filament that can be easily integrated into your admin panel. It uses the foundation of the `timokoerber/laravel-one-time-operations` library and extends it to work seamlessly with the Filament ecosystem.
This solution is ideal for:
- Data migrations that need to be executed only once
- System updates that should not be repeated
- Maintenance scripts that require controlled execution
- Critical operations that need execution tracking

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/filament-one-time-operations
```

## Usage

Publish config file.

```bash
php artisan vendor:publish --tag=filament-one-time-operations-config
```

Add in AdminPanelProvider.php

```php
use JeffersonGoncalves\Filament\OneTimeOperations\OneTimeOperationsPlugin;

->plugins([
    OneTimeOperationsPlugin::make(),
])
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jèfferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
