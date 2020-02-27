<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Command;

use InvalidArgumentException;
use MoveElevator\RequirementsChecker\Command\RequirementsCheckerCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class RequirementsCheckerCommandTest extends TestCase
{
    public function testErrorRequirementsCheckerYml(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(1573220930);

        $command = new RequirementsCheckerCommand();
        $input = new ArrayInput(
            [
                'yamlFile' => 'tetst . txt',
            ]
        );

        $command->run($input, new NullOutput());
    }

    public function testErrorRequirementsCheckerYmlNoStringArgument(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionCode(1573220919);

        $command = new RequirementsCheckerCommand();
        $input = new ArrayInput(
            [
                'yamlFile' => ['test'],
            ]
        );

        $command->run($input, new NullOutput());
    }

    public function testSuccessRequirementsChecker(): void
    {
        $command = new RequirementsCheckerCommand();
        $input = new ArrayInput(
            [
                'yamlFile' => 'tests/Fixtures/File/test-config.yaml',
            ]
        );
        $output = new NullOutput();

        $this->assertEquals(0, $command->run($input, $output));
    }
}
