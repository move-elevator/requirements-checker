<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Model;

use MoveElevator\RequirementsChecker\Model\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testSetterAndGetter(): void
    {
        $message = 'testMessage';
        $name = 'name';

        $result = new Result($name);
        $this->assertEquals($name, $result->getName());
        $this->assertFalse($result->isSuccess());
        $this->assertEmpty($result->getMessage());

        $result->setSuccess();
        $this->assertTrue($result->isSuccess());

        $result->setMessage($message);
        $this->assertEquals($message, $result->getMessage());
    }
}
