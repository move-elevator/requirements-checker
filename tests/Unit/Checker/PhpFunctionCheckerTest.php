<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Checker;

use MoveElevator\RequirementsChecker\Checker\PhpFunctionChecker;
use MoveElevator\RequirementsChecker\Tests\Fixtures\Data\PhpCoreMethodFixture;
use PHPUnit\Framework\TestCase;

class PhpFunctionCheckerTest extends TestCase
{
    public function testNotSuccessfulPhpFunctionCheck(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'function_exists' => false,
            ]
        );

        $functionName = 'json_encode';
        $result = (new PhpFunctionChecker($functionName))->check();

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('The required PHP function is not available.', $result->getMessage());
        $this->assertEquals('PHP function ' . $functionName, $result->getName());
    }

    public function testSuccessfulPhpFunctionCheck(): void
    {
        PhpCoreMethodFixture::setReturnValuesForCoreFunctions(
            [
                'function_exists' => true,
            ]
        );

        $functionName = 'json_encode';
        $result = (new PhpFunctionChecker($functionName))->check();

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('requirement fulfilled.', $result->getMessage());
        $this->assertEquals('PHP function ' . $functionName, $result->getName());
    }
}
