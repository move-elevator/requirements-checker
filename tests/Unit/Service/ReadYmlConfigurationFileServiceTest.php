<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Service;

use MoveElevator\RequirementsChecker\Collection\CheckerCollection;
use MoveElevator\RequirementsChecker\Service\ReadYamlConfigurationFileService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Exception\ParseException;

class ReadYmlConfigurationFileServiceTest extends TestCase
{
    public function testUnreadableYmlFile(): void
    {
        $this->expectException(ParseException::class);

        new ReadYamlConfigurationFileService('');
    }

    public function testReadYmlFile(): void
    {
        $service = new ReadYamlConfigurationFileService('tests/Fixtures/File/test-config.yaml');

        $this->assertInstanceOf(CheckerCollection::class, $service->getCheckerCollection());
    }
}
