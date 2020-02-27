<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

use MoveElevator\RequirementsChecker\Model\Result;

class PhpExtensionChecker extends AbstractChecker
{
    /**
     * @var string
     */
    protected $extensionName;

    public function __construct(string $extensionName)
    {
        $this->extensionName = $extensionName;
    }

    public function check(): Result
    {
        $result = new Result($this->getName());
        if (true === extension_loaded($this->extensionName)) {
            $result->setSuccess();
        }
        $result->setMessage($this->getMessage($result->isSuccess()));

        return $result;
    }

    protected function getName(): string
    {
        return sprintf('PHP extension %s', $this->extensionName);
    }

    private function getMessage(bool $success = false): string
    {
        if (true === $success) {
            return 'requirement fulfilled.';
        }

        return 'The required PHP extension is not available.';
    }
}
