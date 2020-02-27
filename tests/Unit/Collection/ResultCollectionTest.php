<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Collection;

use MoveElevator\RequirementsChecker\Collection\ResultCollection;
use MoveElevator\RequirementsChecker\Model\Result;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;

class ResultCollectionTest extends TestCase
{
    /**
     * @dataProvider getWrongDataFormatsForCollection
     *
     * @param mixed $value
     */
    public function testExceptionWhileAppendingSingleValue($value): void
    {
        $this->expectException(TypeError::class);

        $resultCollection = new ResultCollection();
        $resultCollection->append($value);
    }

    /**
     * @dataProvider getWrongDataFormatsForCollection
     *
     * @param mixed $value
     */
    public function testExceptionWhileAppendingMultipleValue($value): void
    {
        $this->expectException(TypeError::class);

        $resultCollection = new ResultCollection();
        $resultCollection->appendMultiple($value);
    }

    public function getWrongDataFormatsForCollection(): array
    {
        return [
            ['test'],
            [1],
            [new stdClass()],
            [1.123],
            [[12, 151465]],
            [['test', 'asfdasd']],
        ];
    }

    public function testAppendingSingleValue(): void
    {
        $result = new Result('test');

        $resultCollection = new ResultCollection();
        $resultCollection->append($result);

        $this->assertEquals($result, $resultCollection->offsetGet(0));
    }

    public function testAppendingMultipleValue(): void
    {
        $result = new Result('test');

        $resultCollection = new ResultCollection();
        $resultCollection->appendMultiple([$result]);

        $this->assertEquals($result, $resultCollection->offsetGet(0));
    }
}
