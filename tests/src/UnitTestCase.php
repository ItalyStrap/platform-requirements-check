<?php

declare(strict_types=1);

namespace ItalyStrap\PlatformRequirementsCheck\Tests;

use Codeception\Test\Unit;
use ItalyStrap\PlatformRequirementsCheck\RequirementInterface;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

class UnitTestCase extends Unit
{
    use ProphecyTrait;

    protected \UnitTester $tester;
    protected string $name;
    protected string $version;
    protected string $min_version = '';
    protected string $max_version = '';

    protected ObjectProphecy $requirement;

    protected function makeRequirement(): RequirementInterface
    {
        return $this->requirement->reveal();
    }

    // phpcs:ignore -- Method from Codeception
    protected function _before()
    {
        $this->name = 'Test';
        $this->version = \implode('.', [
            \random_int(1, 9),
            \random_int(1, 9),
            \random_int(1, 9),
        ]);

        $this->requirement = $this->prophesize(RequirementInterface::class);
    }

    // phpcs:ignore -- Method from Codeception
    protected function _after()
    {
        unset($this->name, $this->version);
        $this->min_version = '';
        $this->max_version = '';
    }
}
