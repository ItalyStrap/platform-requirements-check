<?php

declare(strict_types=1);

namespace ItalyStrap\PlatformRequirementsCheck\Tests\Unit;

use ItalyStrap\PlatformRequirementsCheck\Requirements;
use ItalyStrap\PlatformRequirementsCheck\Tests\UnitTestCase;

class RequirementsTest extends UnitTestCase
{
    private function makeInstance(): Requirements
    {
        return new Requirements(
            $this->makeRequirement(),
            $this->makeRequirement(),
        );
    }

    // tests
    public function testSomeFeature()
    {
        $sut = $this->makeInstance();
    }

    public function testShouldReturnTrueIfAllRequirementsAreMet(): void
    {
        $this->requirement
            ->check()
            ->willReturn(true)
            ->shouldBeCalledTimes(2);

        $sut = $this->makeInstance();
        $this->assertTrue($sut->check());
    }

    public function testShouldReturnFalseIfAnyRequirementIsNotMet(): void
    {
        $this->requirement
            ->check()
            ->willReturn(true, false);

        $this->requirement
            ->errorMessage()
            ->willReturn('Error message')
            ->shouldBeCalledOnce();

        $sut = $this->makeInstance();
        $this->assertFalse($sut->check());
        $this->assertSame(['Error message'], $sut->errorMessages());
    }
}
