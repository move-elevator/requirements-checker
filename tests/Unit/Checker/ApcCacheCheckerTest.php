<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Checker;

use MoveElevator\RequirementsChecker\Checker\ApcCacheChecker;
use MoveElevator\RequirementsChecker\Tests\Fixtures\Data\PhpCoreMethodFixture;
use PHPUnit\Framework\TestCase;

class ApcCacheCheckerTest extends TestCase
{
    public function testNotSuccessfulApcCacheCheck(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'extension_loaded' => [true, false],
                'ini_get' => true,
                'phpversion' => '1.0.0',
            ]
        );
        $result = (new ApcCacheChecker())->check();

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('requirement fulfilled.', $result->getMessage());
        $this->assertEquals('APC available in version', $result->getName());
    }

    public function testNotSuccessfulApcuCacheCheck(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'extension_loaded' => [false, true],
                'ini_get' => true,
                'phpversion' => '',
            ]
        );
        $result = (new ApcCacheChecker())->check();

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('requirement fulfilled.', $result->getMessage());
        $this->assertEquals('APCU available in version', $result->getName());
    }

    public function testNotSuccessful(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'extension_loaded' => false,
                'ini_get' => true,
                'phpversion' => '',
            ]
        );
        $result = (new ApcCacheChecker())->check();

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('The required PHP module is not available.', $result->getMessage());
        $this->assertEquals('APCU available in version', $result->getName());
    }
}
