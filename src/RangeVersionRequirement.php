<?php

declare(strict_types=1);

namespace ItalyStrap\PlatformRequirementsCheck;

/**
 * @psalm-api
 */
final class RangeVersionRequirement implements RequirementInterface
{
    use WithNameTrait;
    use WithConstraintTrait;

    public const MIN_VERSION = 'min_version';
    public const MAX_VERSION = 'max_version';

    private string $name;
    private string $current_version;

    public function __construct(
        string $name,
        string $current_version,
        string $min_version = '',
        string $max_version = ''
    ) {
        if (empty($name)) {
            throw new \InvalidArgumentException('The $name argument is empty');
        }

        $this->name = $name;
        $this->current_version = $current_version;
        $this->constraint = [
            self::MIN_VERSION => $min_version,
            self::MAX_VERSION => $max_version,
        ];
    }

    public function check(): bool
    {
        return $this->compare(
            (string)$this->get(self::MIN_VERSION, $this->current_version),
            '>='
        )
            && $this->compare(
                (string)$this->get(self::MAX_VERSION, $this->current_version),
                '<='
            );
    }

    public function errorMessage(): string
    {
        return \sprintf(
            'Required version of %1$s needs to be between v%2$s and v%3$s. %1$s currently is running v%4$s.',
            $this->name(),
            (string)$this->get(self::MIN_VERSION, $this->current_version),
            (string)$this->get(self::MAX_VERSION, $this->current_version),
            $this->current_version
        );
    }

    /** @psalm-suppress ArgumentTypeCoercion */
    private function compare(string $version, string $operator): bool
    {
        return (bool)\version_compare(
            \trim(\strtolower($this->current_version)),
            \trim(\strtolower($version)),
            $operator
        );
    }
}
