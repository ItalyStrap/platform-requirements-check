<?php

declare(strict_types=1);

namespace ItalyStrap\PlatformRequirementsCheck;

interface RequirementInterface
{
    public function name(): string;

    /**
     * @return bool
     */
    public function check(): bool;

    /**
     * @return string
     */
    public function errorMessage(): string;
}
