# Platform Requirements Check

[![Build status](https://github.com/ItalyStrap/platform-requirements-check/actions/workflows/qa.yml/badge.svg)](https://github.com/ItalyStrap/platform-requirements-check/actions/workflows/qa.yml?query=workflow%3Aqa)
[![Latest Stable Version](https://img.shields.io/packagist/v/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
[![Total Downloads](https://img.shields.io/packagist/dt/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
[![License](https://img.shields.io/packagist/l/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
![PHP from Packagist](https://img.shields.io/packagist/php-v/italystrap/platform-requirements-check)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FItalyStrap%2Fcache%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/ItalyStrap/platform-requirements-check/master)

**Platform Requirements Check** is a PHP library that allows you to check system requirements for your PHP project or plugin. The library provides a simple interface that can be used to define and check system requirements like minimum and maximum PHP versions, PHP extensions, and any other specific project requirements.

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

The library provides a `RequirementInterface` interface which you can use to define your system requirements. Implement this interface to define a new requirement.

```php
<?php
use ItalyStrap\PlatformRequirementsCheck\RequirementInterface;

class MyRequirement implements RequirementInterface
{
    // implement the interface methods
}
```

The library also provides two traits, `WithNameTrait` and `WithConstraintTrait`, which can be used to simplify the creation of new requirement classes.

Additionally, there's a `Requirements` class that can be used to group together and check a set of requirements.

```php
<?php
use ItalyStrap\PlatformRequirementsCheck\Requirements;
use ItalyStrap\PlatformRequirementsCheck\RangeVersionRequirement;

$requirements = new Requirements(
    new RangeVersionRequirement('PHP', PHP_VERSION, '7.4', '8.0'),
    // add other requirements...
);

if (!$requirements->check()) {
    // not all requirements are met, handle this case
    foreach ($requirements->errorMessages() as $errorMessage) {
        echo $errorMessage;
    }
}
```

`RangeVersionRequirement` is a concrete class that implements `RequirementInterface`. This class checks if the current version of a certain component (e.g., PHP or a PHP extension) is within a version range. Use `RangeVersionRequirement` to define a version range-based requirement.

```php
<?php
use ItalyStrap\PlatformRequirementsCheck\RangeVersionRequirement;

$requirement = new RangeVersionRequirement('PHP', PHP_VERSION, '7.4', '8.0');

if (!$requirement->check()) {
    echo $requirement->errorMessage();
}
```

## Advanced Usage

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

The rest coming soon...

## Contributing

All feedback / bug reports / pull requests are welcome.

## License

Copyright (c) 2019 Enea Overclokk, ItalyStrap

This code is licensed under the [MIT](LICENSE).