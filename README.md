# Platform Requirements Check

[![Build status](https://github.com/ItalyStrap/platform-requirements-check/actions/workflows/test.yml/badge.svg)](https://github.com/ItalyStrap/platform-requirements-check/actions/workflows/test.yml?query=workflow%3Atest)
[![Latest Stable Version](https://img.shields.io/packagist/v/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
[![Total Downloads](https://img.shields.io/packagist/dt/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
[![License](https://img.shields.io/packagist/l/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
![PHP from Packagist](https://img.shields.io/packagist/php-v/italystrap/platform-requirements-check)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FItalyStrap%2Fcache%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/ItalyStrap/platform-requirements-check/master)

Check the platform requirements for your application

## Table Of Contents

* [Installation](#installation)
* [Basic Usage](#basic-usage)
* [Advanced Usage](#advanced-usage)
* [Contributing](#contributing)
* [License](#license)

## Installation

The best way to use this package is through Composer:

```CMD
composer require italystrap/platform-requirements-check
```
This package adheres to the [SemVer](http://semver.org/) specification and will be fully backward compatible between minor versions.

## Basic Usage

```php
<?php
// ... Main plugin file
/**
 * Plugin Name:       YOUR PLUGIN NAME
 * Plugin URI:        YOUR PLUGIN SITE
 * Description:       YOUR PLUGIN DESCRIPTION
 * Version:           1.0.0
 * Requires at least: 5.3
 * Requires PHP:      8.0.29
 * Author:            YOUR NAME
 * Author URI:        YOUR SITE
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       YOUR TEXT DOMAIN
 * Domain Path:       /languages
 */
 
 // ... Do yout stuff
 ```
 
 ```php
// ...bootstrap.php
require __DIR__ . '/vendor/italystrap/platform-requirements-check/autoload.php';

$requirementsList = [
    new \ItalyStrap\PlatformRequirementsCheck\RangeVersionRequirement(
        'PHP',
        \PHP_VERSION,
        (string)$plugin_data['RequiresPHP'],
        '8.0.29'
    ),
    new \ItalyStrap\PlatformRequirementsCheck\RangeVersionRequirement(
        'WP',
        $GLOBALS['wp_version'],
        (string)$plugin_data['RequiresWP'],
        '6.2'
    ),
];

$requirements = (new \ItalyStrap\PlatformRequirementsCheck\Requirements(...$requirementsList));

    $requirementsAreFullFilled = $requirements->check();

    if (!$requirementsAreFullFilled) {
        \add_action(
            'admin_notices',
            static function () use ($requirements): void {
                ?>
                <div class="notice notice-error">
                    <?php foreach ($requirements->errorMessages() as $message): ?>
                        <p><?php \esc_html_e($message); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php
            }
        );
    }

```

## Advanced Usage

Coming soon...

## Contributing

All feedback / bug reports / pull requests are welcome.

## License

Copyright (c) 2019 Enea Overclokk, ItalyStrap

This code is licensed under the [MIT](LICENSE).