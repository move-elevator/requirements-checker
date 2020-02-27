<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

use MoveElevator\RequirementsChecker\Model\Result;

interface CheckerInterface
{
    public function check(): Result;
}
