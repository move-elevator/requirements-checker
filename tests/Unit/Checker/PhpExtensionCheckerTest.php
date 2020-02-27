<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Checker;

use MoveElevator\RequirementsChecker\Checker\PhpExtensionChecker;
use MoveElevator\RequirementsChecker\Tests\Fixtures\Data\PhpCoreMethodFixture;
use PHPUnit\Framework\TestCase;

class PhpExtensionCheckerTest extends TestCase
{
    public function testNotSuccessfulPhpExtensionCheck(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'extension_loaded' => false,
            ]
        );
        $result = (new PhpExtensionChecker('imagick'))->check();

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('The required PHP extension is not available.', $result->getMessage());
        $this->assertEquals('PHP extension imagick', $result->getName());
    }

    public function testSuccessfulPhpExtensionCheck(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'extension_loaded' => true,
            ]
        );
        $result = (new PhpExtensionChecker('imagick'))->check();

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('requirement fulfilled.', $result->getMessage());
        $this->assertEquals('PHP extension imagick', $result->getName());
    }
}
