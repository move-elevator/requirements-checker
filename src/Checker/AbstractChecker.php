<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

abstract class AbstractChecker implements CheckerInterface
{
    protected function getName(): string
    {
        return str_replace(['/', '\\'], ' ', get_class($this));
    }
}
