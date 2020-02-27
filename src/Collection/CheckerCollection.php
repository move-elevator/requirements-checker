<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Collection;

use ArrayObject;
use MoveElevator\RequirementsChecker\Checker\CheckerInterface;
use TypeError;

class CheckerCollection extends ArrayObject
{
    /**
     * @param int $index
     */
    public function offsetGet($index): CheckerInterface
    {
        return parent::offsetGet($index);
    }

    /**
     * @param array<object> $multipleChecker
     *
     * @throws TypeError
     */
    public function appendMultiple(array $multipleChecker): void
    {
        foreach ($multipleChecker as $item) {
            $this->append($item);
        }
    }

    /**
     * @param CheckerInterface|mixed $value
     *
     * @throws TypeError
     */
    public function append($value): void
    {
        if (false === $value instanceof CheckerInterface) {
            throw new TypeError('You only can append Objects of type ' . CheckerInterface::class);
        }

        parent::append($value);
    }
}
