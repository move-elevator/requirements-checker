<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

use Exception;
use MoveElevator\RequirementsChecker\Model\Result;

class AccessFileSystemChecker extends AbstractChecker
{
    /**
     * @var string
     */
    protected $directory;

    public function __construct(string $directory = null)
    {
        if (false === is_string($directory)) {
            $this->directory = __DIR__;

            return;
        }
        $this->directory = $directory;
    }

    public function check(): Result
    {
        $result = new Result($this->getName());
        $result->setMessage($this->getMessage());

        $testFile = sprintf('%s/file.txt', $this->directory);
        $testContent = 'töst';

        try {
            file_put_contents($testFile, $testContent);
            if ($testContent !== file_get_contents($testFile)) {
                return $result;
            }
        } catch (Exception $exception) {
            return $result;
        }

        @unlink($testFile);
        if (true === file_exists($testFile)) {
            return $result;
        }

        $structure = sprintf('%s/step1/', $this->directory);
        if (true === is_dir($structure)) {
            rmdir($structure);
        }


        if (false === mkdir($structure, 0777) || false === is_dir($structure)) {
            return $result;
        }

        rmdir($structure);
        if (true === is_dir($structure)) {
            return $result;
        }

        //@noinspection PhpMissingBreakStatementInspection
        $result->setMessage($this->getMessage(true));
        $result->setSuccess();

        return $result;
    }

    private function getMessage(bool $success = false): string
    {
        if (true === $success) {
            return 'requirement fulfilled.';
        }

        return 'The required access rights are not available.';
    }
}
