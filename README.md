# Platform Requirements Check

[![Build status](https://github.com/ItalyStrap/platform-requirements-check/actions/workflows/qa.yml/badge.svg)](https://github.com/ItalyStrap/platform-requirements-check/actions/workflows/qa.yml?query=workflow%3Aqa)
[![Latest Stable Version](https://img.shields.io/packagist/v/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
[![Total Downloads](https://img.shields.io/packagist/dt/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
[![License](https://img.shields.io/packagist/l/italystrap/platform-requirements-check.svg)](https://packagist.org/packages/italystrap/platform-requirements-check)
![PHP from Packagist](https://img.shields.io/packagist/php-v/italystrap/platform-requirements-check)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FItalyStrap%2Fcache%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/ItalyStrap/platform-requirements-check/master)

**Platform Requirements Check** is a PHP library that allows you to check system requirements for your PHP project or plugin. The library provides a simple interface that can be used to define and check system requirements like minimum and maximum PHP versions, PHP extensions, and any other specific project requirements.

This library support PHP 7.4 or higher.
If you need to support PHP <7.4 you can use the original [Minimum Requirement](https://github.com/overclokk/minimum-requirements) library where this is forked from.

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

The first important thing to do is to require the autoloader file included in this package before the Composer autoloader:

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/italystrap/platform-requirements-check/autoload.php';
```

This file will register a PSR-4 autoloader for the `ItalyStrap\PlatformRequirementsCheck` namespace.
You need to require it before everything else because this library can't rely on the Composer autoloader since the Composer autoloader itself is loaded to late in the application bootstrap process, so you need to perform PlatformRequirementsCheck before all and if all requirements are met then you can load the Composer autoloader.

The library provides a `RequirementInterface` interface which you can use to define your system requirements. Implement this interface to define a new requirement.

```php
<?php
use ItalyStrap\PlatformRequirementsCheck\RequirementInterface;

class MyRequirement implements RequirementInterface
{
    // implement the interface methods
}
```

I don't know your project so I don't know all the cases you need to add your own requirement, in any case maybe using an anonymous class could be a good idea if you need only a single requirement.

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/italystrap/platform-requirements-check/autoload.php';

use ItalyStrap\PlatformRequirementsCheck\RequirementInterface;

$requirement = new class implements RequirementInterface
{
    // implement the interface methods
}

if (!$requirement->check()) {
    echo $requirement->errorMessage();
}
```

The library also provides two traits, `WithNameTrait` and `WithConstraintTrait`, which can be used to simplify the creation of new requirement classes.

Additionally, there's a `Requirements` class that can be used to group together and check a set of requirements.

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/italystrap/platform-requirements-check/autoload.php';

use ItalyStrap\PlatformRequirementsCheck\Requirements;
use ItalyStrap\PlatformRequirementsCheck\RangeVersionRequirement;

$requirements = new Requirements(
    new RangeVersionRequirement(
    'PHP', // Give the name of the requirement, the name can be anything you want as a string
    PHP_VERSION, // The current version to check against
    '7.4', // The minimum version you need, this is optional
    '8.0' // The maximum version you need, this is optional
    ),
    // add other requirements...
);

if (!$requirements->check()) {
    // not all requirements are met, handle this case
    foreach ($requirements->errorMessages() as $errorMessage) {
        echo $errorMessage;
    }
}
```

`RangeVersionRequirement` is a concrete class that implements `RequirementInterface`. This class checks if the current version of a certain component (e.g., PHP, Theme or plugin) is within a version range. Use `RangeVersionRequirement` to define a version range-based requirement.

Because the min and max versions are optional, if you omit one of them the one you omitted will be replaced with the current version of the component you are checking.

Let's see an example:

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/italystrap/platform-requirements-check/autoload.php';

use ItalyStrap\PlatformRequirementsCheck\RangeVersionRequirement;

$current_version = '7.4';

$requirement = new RangeVersionRequirement('PHP', $current_version, '', '8.0');

$requirement->check(); // Is true because the current version is 7.4, the min version is empty so will be replaced with 7.4 and the max version is 8.0, so 7.4 >= 7.4 and 7.4 <= 8.0

#######################################

$current_version = '8.0';

$requirement = new RangeVersionRequirement('PHP', $current_version, '7.4', '');

$requirement->check(); // Is true because the current version is 8.0, the min version is 7.4 and the max version is empty so will be replaced with 8.0, so 8.0 >= 7.4 and 8.0 <= 8.0

#######################################

$current_version = '7.3';

$requirement = new RangeVersionRequirement('PHP', $current_version, '7.4', '8.0');

$requirement->check(); // Is false because the current version is 7.3, the min version is 7.4 and the max version is 8.0, so 7.3 >= 7.4 and 7.3 <= 8.0 is false
```

You get the point.

Now, one last thing, if you need for example to check for maximum PHP version to be less than 8.1 but greater than 8.0 because right now the operator used for checking the maximum version is `'<='` you can do by appending `PHP_INT_MAX` to the max version like `'8.0.' . PHP_INT_MAX`, so any version less than 8.1 but max than 8.0 will be valid, yes I know, it's a little bit hacky but if you do not like this just create your own requirement class, and you're done.

If `$requirement->check()` is false then you can get the error message with `$requirement->errorMessage()` and print it if you need to.

```php
<?php
use ItalyStrap\PlatformRequirementsCheck\RangeVersionRequirement;

$requirement = new RangeVersionRequirement('PHP', PHP_VERSION, '7.4', '8.0');

if (!$requirement->check()) {
    echo $requirement->errorMessage();
}
```

For the basic usage, that's all you need to know, I think.

## Advanced Usage

If you want to use this library in your WordPress plugin, you can use it like this:

```php
<?php

declare(strict_types=1);

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
 
You could check in the main file or like me create a `bootstrap.php` file to do all the rest of the stuff.

 ```php
<?php

declare(strict_types=1);

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

// If you need you can also call `\register_activation_hook()` here to deactivate the plugin if the requirements are not met as soon as user try to activate the plugin.

// This will show the error messages in the admin area
// Remember to always escape any output before printing it
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

If the requirements are not met, you can choose to deactivate the plugin or theme, or you can choose to show an error message to the user and let them decide what to do, you have the power.

Right now I decided to not include the check for required plugins like the original package does, if I have some time in the future I could do it.

## Contributing

All feedback / bug reports / pull requests are welcome.

## License

Copyright (c) 2019 Enea Overclokk, ItalyStrap

This code is licensed under the [MIT](LICENSE).