<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

use MoveElevator\RequirementsChecker\Model\Result;

class PhpIniSettingChecker extends AbstractChecker
{
    /**
     * @var string
     */
    protected $initSettingKey;

    /**
     * @var string
     */
    protected $initSettingValue;

    /**
     * @param array<string, mixed> $iniSettings
     */
    public function __construct(array $iniSettings)
    {
        $this->initSettingKey = (string)(array_keys($iniSettings)[0] ?? null);
        $this->initSettingValue = (string)(array_values($iniSettings)[0] ?? null);
    }

    public function check(): Result
    {
        $result = new Result($this->getName());
        if ((string)$this->initSettingValue === ini_get($this->initSettingKey)) {
            $result->setSuccess();
        }
        $result->setMessage($this->getMessage($result->isSuccess()));

        return $result;
    }

    protected function getName(): string
    {
        return sprintf('PHP ini setting "%s" is "%s"', $this->initSettingKey, $this->initSettingValue);
    }

    private function getMessage(bool $success = false): string
    {
        if (true === $success) {
            return 'requirement fulfilled.';
        }

        return 'The required PHP setting is not correct.';
    }
}
