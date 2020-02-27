<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

use MoveElevator\RequirementsChecker\Model\Result;

class PhpMinimalVersionChecker extends AbstractChecker
{
    private $requirement;

    public function __construct(string $requirement)
    {
        $this->requirement = $requirement;
    }

    public function check(): Result
    {
        $result = new Result($this->getName());
        if (true === version_compare((string)phpversion(), $this->requirement) >= 0) {
            $result->setSuccess();
        }
        $result->setMessage($this->getMessage($result->isSuccess()));

        return $result;
    }

    protected function getName(): string
    {
        return 'Php Minimal Version Checker';
    }

    private function getMessage(bool $success = false): string
    {
        if (true === $success) {
            return sprintf(
                'Requirement(%s) fulfilled: %s',
                $this->requirement,
                phpversion()
            );
        }

        return sprintf(
            'The PHP version does not meet the requirement: %s vs %s',
            $this->requirement,
            phpversion()
        );
    }
}
