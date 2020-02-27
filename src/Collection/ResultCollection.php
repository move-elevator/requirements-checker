<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Collection;

use ArrayObject;
use MoveElevator\RequirementsChecker\Model\Result;
use TypeError;

class ResultCollection extends ArrayObject
{
    /**
     * @param int $index
     */
    public function offsetGet($index): Result
    {
        return parent::offsetGet($index);
    }

    /**
     * @param Result[] $multipleResult
     *
     * @throws TypeError
     */
    public function appendMultiple(array $multipleResult): void
    {
        foreach ($multipleResult as $item) {
            $this->append($item);
        }
    }

    /**
     * @param Result|mixed $value
     *
     * @throws TypeError
     */
    public function append($value): void
    {
        if (false === $value instanceof Result) {
            throw new TypeError('You only can append Objects of type ' . Result::class);
        }

        parent::append($value);
    }
}
