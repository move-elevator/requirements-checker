<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Checker;

use MoveElevator\RequirementsChecker\Checker\SystemDateTimeChecker;
use MoveElevator\RequirementsChecker\Tests\Fixtures\Data\PhpCoreMethodFixture;
use PHPUnit\Framework\TestCase;

class SystemDateTimeCheckerTest extends TestCase
{
    public function testNotReadableDateTimeChecker(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'class_exists' => false,
            ]
        );

        $result = (new SystemDateTimeChecker())->check();

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('The system time could not be read out.', $result->getMessage());
    }

    public function testSuccessfulDateTimeChecker(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'class_exists' => true,
            ]
        );

        $result = (new SystemDateTimeChecker())->check();

        $this->assertTrue($result->isSuccess());
        $this->assertStringContainsString('current system time:', $result->getMessage());
    }
}
