<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Collection;

use MoveElevator\RequirementsChecker\Checker\ApcCacheChecker;
use MoveElevator\RequirementsChecker\Collection\CheckerCollection;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;

class CheckerCollectionTest extends TestCase
{
    /**
     * @dataProvider getWrongDataFormatsForCollection
     *
     * @param mixed $value
     */
    public function testExceptionWhileAppendingSingleValue($value): void
    {
        $this->expectException(TypeError::class);

        $checkerCollection = new CheckerCollection();
        $checkerCollection->append($value);
    }

    /**
     * @dataProvider getWrongDataFormatsForCollection
     *
     * @param mixed $value
     */
    public function testExceptionWhileAppendingMultipleValue($value): void
    {
        $this->expectException(TypeError::class);

        $checkerCollection = new CheckerCollection();
        $checkerCollection->appendMultiple($value);
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
        $checker = new ApcCacheChecker();

        $checkerCollection = new CheckerCollection();
        $checkerCollection->append($checker);

        $this->assertEquals($checker, $checkerCollection->offsetGet(0));
    }

    public function testAppendingMultipleValue(): void
    {
        $checker = new ApcCacheChecker();

        $checkerCollection = new CheckerCollection();
        $checkerCollection->appendMultiple([$checker]);

        $this->assertEquals($checker, $checkerCollection->offsetGet(0));
    }
}
