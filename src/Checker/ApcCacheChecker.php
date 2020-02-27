<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

use MoveElevator\RequirementsChecker\Model\Result;

class ApcCacheChecker extends AbstractChecker
{
    public function check(): Result
    {
        $result = new Result($this->getName());

        if (
            true === extension_loaded('apc')
            && true === (bool)ini_get('apc.enabled')
        ) {
            $result->setSuccess();
        }

        if (
            true === extension_loaded('apcu')
            && true === (bool)ini_get('apc.enabled')
        ) {
            $result->setSuccess();
        }

        $result->setMessage($this->getMessage($result->isSuccess()));

        return $result;
    }

    protected function getName(): string
    {
        return sprintf(
            '%s available in version',
            strtoupper($this->getType())
        );
    }

    private function getType(): string
    {
        $apcVersion = phpversion('apc');
        if (false === empty($apcVersion)) {
            return 'apc';
        }

        return 'apcu';
    }

    private function getMessage(bool $success = false): string
    {
        if (true === $success) {
            return 'requirement fulfilled.';
        }

        return 'The required PHP module is not available.';
    }
}
