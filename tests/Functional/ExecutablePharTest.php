<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class ExecutablePharTest extends TestCase
{
    public function testTriggerPharAndCheckReturnCode(): void
    {
        $process = new Process('/usr/local/bin/php ./build/requirements-checker.phar ./build/example-config.yaml');
        $process->run();
        $this->assertTrue($process->isSuccessful());
    }
}
