<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use MoveElevator\RequirementsChecker\Command\RequirementsCheckerCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new RequirementsCheckerCommand());
$application->setDefaultCommand('app:requirements-checker', true);
$application->run();
