<?php

declare(strict_types=1);

namespace ItalyStrap\PlatformRequirementsCheck;

trait WithNameTrait
{
    public function name(): string
    {
        return $this->name;
    }
}
