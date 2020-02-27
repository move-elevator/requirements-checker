<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Model;

use MoveElevator\RequirementsChecker\Model\Settings;
use PHPUnit\Framework\TestCase;

class SettingsTest extends TestCase
{
    public function testSetterAndGetter(): void
    {
        $testNameSpace = 'MoveElevator\RequirementsChecker';

        $testValue = (new Settings([$testNameSpace]))->getCheckerNamespaces();

        $this->assertTrue(in_array($testNameSpace, $testValue));
    }
}
