<?php

declare(strict_types=1);

namespace ItalyStrap\PlatformRequirementsCheck\Tests;

use ItalyStrap\PlatformRequirementsCheck\RangeVersionRequirement;

trait RangeVersionRequirementCommonTrait
{
    public function testInstanceOk()
    {
        $sut = $this->makeInstance();
    }

    public static function constraintProvider(): iterable
    {
        yield '4.0.0-beta.8 | 3.0 <= 4.0.0-beta.8 <= 4.0.0 | Expectation: true' => [
            'Actual version' => '4.0.0-beta.8',
            RangeVersionRequirement::MIN_VERSION => '3',
            RangeVersionRequirement::MAX_VERSION => '4.0.0',
            true,
        ];

        yield '4.0.0-beta.8 | 4.0.0-beta.8 < 5.0 (min) | Expectation: false' => [
            'Actual version' => '4.0.0-beta.8',
            RangeVersionRequirement::MIN_VERSION => '5.0',
            RangeVersionRequirement::MAX_VERSION => '7.0',
            false,
        ];

        yield '8.0.0-beta.1 | 7.0 (max) < 8.0.0-beta.1 | Expectation: false' => [
            'Actual version' => '8.0.0-beta.1',
            RangeVersionRequirement::MIN_VERSION => '5.0',
            RangeVersionRequirement::MAX_VERSION => '7.0',
            false,
        ];

        yield '8.0.25 | 8.0.25 = 8.0.25 (min) = 8.0.25 (max) | Expectation: true' => [
            '8.0.25',
            RangeVersionRequirement::MIN_VERSION => '8.0.25',
            RangeVersionRequirement::MAX_VERSION => '8.0.25',
            true,
        ];

        yield '8.0.26 | 8.0.25 (min) <= 8.0.25 (max) <= 8.0.26 | Expectation: false' => [
            '8.0.26',
            RangeVersionRequirement::MIN_VERSION => '8.0.25',
            RangeVersionRequirement::MAX_VERSION => '8.0.25',
            false,
        ];

        yield '8.0.24 | 8.0.24 <= 8.0.25 (min) <= 8.0.25 (max) | Expectation: false' => [
            '8.0.24',
            RangeVersionRequirement::MIN_VERSION => '8.0.25',
            RangeVersionRequirement::MAX_VERSION => '8.0.25',
            false,
        ];

        // Pay attention to this test, if you invert the min and max version
        // the check will fail, in this example the min version is equal to the
        // actual version, but the max version is less than the actual version
        // the comparison will pass for the min version and will not pass for the
        // max version, so the check will fail.
        // actual version '>=' min version && actual version '<=' max version
        yield '8.0.24 | 8.0.24 <= 8.0.24 (min) <= 8.0.23 (max) | Expectation: false' => [
            '8.0.24',
            RangeVersionRequirement::MIN_VERSION => '8.0.24',
            RangeVersionRequirement::MAX_VERSION => '8.0.23',
            false,
        ];

        yield 'Actual 8.0.24 | 8.0.24 = "to-actual" (min) <= 8.0.24 (max) | Expectation: false' => [
            '8.0.24',
            RangeVersionRequirement::MIN_VERSION => '',
            RangeVersionRequirement::MAX_VERSION => '8.0.25',
            true,
        ];

        yield 'Actual 8.0.24 | 8.0.24 = 8.0.24 (min) <= "to-actual" (max) | Expectation: false' => [
            '8.0.24',
            RangeVersionRequirement::MIN_VERSION => '8.0.24',
            RangeVersionRequirement::MAX_VERSION => '',
            true,
        ];

        yield 'Actual 8.0.24 | 8.0.24 = "to-actual" (min) <= "to-actual" (max) | Expectation: false' => [
            '8.0.24',
            RangeVersionRequirement::MIN_VERSION => '',
            RangeVersionRequirement::MAX_VERSION => '',
            true,
        ];
    }

    /**
     * @dataProvider constraintProvider
     */
    public function testCompareVersion(string $actual, string $min, string $max, bool $expected)
    {
        $this->version = $actual;
        $this->min_version = $min;
        $this->max_version = $max;
        $sut = $this->makeInstance();
        $this->assertSame($expected, $sut->check(), 'Version is not compatible');
    }
}
