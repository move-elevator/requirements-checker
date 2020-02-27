<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Checker;

use DateTime;
use MoveElevator\RequirementsChecker\Checker\PhpClassChecker;
use MoveElevator\RequirementsChecker\Tests\Fixtures\Data\PhpCoreMethodFixture;
use PHPUnit\Framework\TestCase;

class PhpClassCheckerTest extends TestCase
{
    public function testNotSuccessfulPhpClassCheck(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'class_exists' => false,
            ]
        );
        $class = DateTime::class;
        $result = (new PhpClassChecker($class))->check();

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('The required PHP class does not exist.', $result->getMessage());
        $this->assertEquals('PHP class ' . $class, $result->getName());
    }

    public function testSuccessfulPhpClassCheck(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'class_exists' => true,
            ]
        );
        $class = DateTime::class;
        $result = (new PhpClassChecker($class))->check();

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('requirement fulfilled.', $result->getMessage());
        $this->assertEquals('PHP class ' . $class, $result->getName());
    }
}
