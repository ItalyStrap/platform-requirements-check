<?php

declare(strict_types=1);

namespace ItalyStrap\PlatformRequirementsCheck;

trait WithConstraintTrait
{
    private array $constraint;

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    private function get(string $key, $default = null)
    {
        return $this->constraint[$key] ?: $default;
    }
}
