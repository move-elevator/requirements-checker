<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit;

use MoveElevator\RequirementsChecker\Collection\ResultCollection;
use MoveElevator\RequirementsChecker\RequirementsCheckerApplication;
use PHPUnit\Framework\TestCase;

class RequirementsCheckerApplicationTest extends TestCase
{
    public function testSuccessRequirementsCheckerService(): void
    {
        $application = new RequirementsCheckerApplication('tests/Fixtures/File/test-config.yaml');
        $resultCollection = $application->check();

        $this->assertInstanceOf(ResultCollection::class, $resultCollection);
        $this->assertCount(23, $resultCollection);
    }
}
