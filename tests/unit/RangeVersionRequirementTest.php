<?php

declare(strict_types=1);

namespace ItalyStrap\PlatformRequirementsCheck\Tests\Unit;

use ItalyStrap\PlatformRequirementsCheck\RequirementInterface;
use ItalyStrap\PlatformRequirementsCheck\Tests\RangeVersionRequirementCommonTrait;
use ItalyStrap\PlatformRequirementsCheck\Tests\UnitTestCase;
use ItalyStrap\PlatformRequirementsCheck\RangeVersionRequirement;

class RangeVersionRequirementTest extends UnitTestCase
{
    use RangeVersionRequirementCommonTrait;

    private function makeInstance(): RequirementInterface
    {
        return new RangeVersionRequirement(
            $this->name,
            $this->version,
            $this->min_version,
            $this->max_version
        );
    }
}
