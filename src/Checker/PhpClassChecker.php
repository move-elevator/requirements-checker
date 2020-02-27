<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

use MoveElevator\RequirementsChecker\Model\Result;

class PhpClassChecker extends AbstractChecker
{
    /**
     * @var string
     */
    protected $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function check(): Result
    {
        $result = new Result($this->getName());

        if (true === class_exists($this->className)) {
            $result->setSuccess();
        }
        $result->setMessage($this->getMessage($result->isSuccess()));

        return $result;
    }

    protected function getName(): string
    {
        return sprintf('PHP class %s', $this->className);
    }

    private function getMessage(bool $success = false): string
    {
        if (true === $success) {
            return 'requirement fulfilled.';
        }

        return 'The required PHP class does not exist.';
    }
}
