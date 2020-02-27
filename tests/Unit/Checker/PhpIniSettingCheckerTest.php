<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Checker;

use MoveElevator\RequirementsChecker\Checker\PhpIniSettingChecker;
use MoveElevator\RequirementsChecker\Tests\Fixtures\Data\PhpCoreMethodFixture;
use PHPUnit\Framework\TestCase;

class PhpIniSettingCheckerTest extends TestCase
{
    public function testNotSuccessfulPhpIniSettingCheck(): void
    {
        $settingValue = true;
        $settingKey = 'phar.readonly';
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'ini_get' => !$settingValue,
            ]
        );

        $iniSettingCheck = [$settingKey => 1];
        $result = (new PhpIniSettingChecker($iniSettingCheck))->check();

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('The required PHP setting is not correct.', $result->getMessage());
        $this->assertEquals(
            sprintf('PHP ini setting "%s" is "%s"', $settingKey, $settingValue),
            $result->getName()
        );
    }

    public function testSuccessfulPhpFunctionCheck(): void
    {
        $settingValue = true;
        $settingKey = 'phar.readonly';
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'ini_get' => (string)$settingValue,
            ]
        );

        $iniSettingCheck = [$settingKey => $settingValue];
        $result = (new PhpIniSettingChecker($iniSettingCheck))->check();

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('requirement fulfilled.', $result->getMessage());
        $this->assertEquals(
            sprintf('PHP ini setting "%s" is "%s"', $settingKey, $settingValue),
            $result->getName()
        );
    }
}
