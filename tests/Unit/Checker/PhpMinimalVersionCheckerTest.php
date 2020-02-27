<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Checker;

use MoveElevator\RequirementsChecker\Checker\PhpMinimalVersionChecker;
use MoveElevator\RequirementsChecker\Tests\Fixtures\Data\PhpCoreMethodFixture;
use PHPUnit\Framework\TestCase;

class PhpMinimalVersionCheckerTest extends TestCase
{
    /**
     * @dataProvider provideWrongMinimalVersions
     *
     * @param string $minimalVersion
     */
    public function testNotSuccessfulPhpVersionCheck($minimalVersion): void
    {
        $currentPhpVersion = '5.3.0';
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'phpversion' => $currentPhpVersion,
            ]
        );

        $result = (new PhpMinimalVersionChecker($minimalVersion))->check();

        $this->assertFalse($result->isSuccess());
        $this->assertEquals(
            'The PHP version does not meet the requirement: ' . $minimalVersion . ' vs ' . $currentPhpVersion,
            $result->getMessage()
        );
        $this->assertEquals('Php Minimal Version Checker', $result->getName());
    }

    /**
     * @return array
     */
    public function provideWrongMinimalVersions(): array
    {
        return [
            ['5.3.1'],
            ['5.5.11'],
            ['5.6.11'],
            ['7.1.1'],
        ];
    }

    /**
     * @dataProvider provideCorrectMinimalVersions
     *
     * @param string $minimalVersion
     */
    public function testSuccessfulPhpVersionCheck($minimalVersion): void
    {
        $currentPhpVersion = '7.0.0';
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'phpversion' => $currentPhpVersion,
            ]
        );

        $result = (new PhpMinimalVersionChecker($minimalVersion))->check();

        $this->assertTrue($result->isSuccess());
        $this->assertEquals(
            'Requirement(' . $minimalVersion . ') fulfilled: ' . $currentPhpVersion,
            $result->getMessage()
        );

        $this->assertEquals('Php Minimal Version Checker', $result->getName());
    }

    /**
     * @return array
     */
    public function provideCorrectMinimalVersions(): array
    {
        return [
            ['5.3.0'],
            ['5.5.11'],
            ['5.6.11'],
            ['7.0.0'],
        ];
    }
}
