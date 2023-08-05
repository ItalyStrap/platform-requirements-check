<?php

declare(strict_types=1);

return static function (string $class): void {
    $prefix = 'ItalyStrap\\PlatformRequirementsCheck\\';
    $base_dir = __DIR__ . '/src/';
    $len = \strlen($prefix);

    if (\strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = \substr($class, $len);
    $file = $base_dir . \str_replace('\\', '/', $relative_class) . '.php';
    /** @psalm-suppress UnresolvableInclude */
    require $file;
};
