<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

use DateTimeImmutable;
use Exception;
use MoveElevator\RequirementsChecker\Model\Result;

class SystemDateTimeChecker extends AbstractChecker
{
    /**
     * @throws Exception
     */
    public function check(): Result
    {
        $result = new Result($this->getName());
        if (true === class_exists(DateTimeImmutable::class)) {
            $result->setSuccess();
        }
        $result->setMessage($this->getMessage($result->isSuccess()));

        return $result;
    }

    private function getMessage(bool $success = false): string
    {
        if (true === $success) {
            return 'current system time: ' . (new DateTimeImmutable())->format('H:i:s d.m.Y');
        }

        return 'The system time could not be read out.';
    }
}
