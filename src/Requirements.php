<?php

declare(strict_types=1);

namespace ItalyStrap\PlatformRequirementsCheck;

/**
 * @psalm-api
 */
final class Requirements
{
    /**
     * @var array<array-key, RequirementInterface>
     */
    private array $requirements;

    /**
     * @var array<array-key, string>
     */
    private array $errorMessages = [];

    public function __construct(
        RequirementInterface ...$requirements
    ) {
        $this->requirements = $requirements;
    }

    public function check(): bool
    {
        $this->errorMessages = [];
        foreach ($this->requirements as $requirement) {
            if ($requirement->check()) {
                continue;
            }

            $this->errorMessages[] = $requirement->errorMessage();
        }

        return empty($this->errorMessages);
    }

    public function errorMessages(): array
    {
        return $this->errorMessages;
    }
}
