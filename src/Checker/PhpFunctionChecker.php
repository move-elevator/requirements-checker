<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

use MoveElevator\RequirementsChecker\Model\Result;

class PhpFunctionChecker extends AbstractChecker
{
    /**
     * @var string
     */
    protected $moduleName;

    public function __construct(string $moduleName)
    {
        $this->moduleName = $moduleName;
    }

    public function check(): Result
    {
        $result = new Result($this->getName());
        if (true === function_exists($this->moduleName)) {
            $result->setSuccess();
        }
        $result->setMessage($this->getMessage($result->isSuccess()));

        return $result;
    }

    protected function getName(): string
    {
        return sprintf('PHP function %s', $this->moduleName);
    }

    private function getMessage(bool $success = false): string
    {
        if (true === $success) {
            return 'requirement fulfilled.';
        }

        return 'The required PHP function is not available.';
    }
}
