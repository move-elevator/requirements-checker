<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker;

use MoveElevator\RequirementsChecker\Collection\ResultCollection;
use MoveElevator\RequirementsChecker\Model\Result;
use MoveElevator\RequirementsChecker\Service\ReadYamlConfigurationFileService;
use Symfony\Component\Yaml\Exception\ParseException;

class RequirementsCheckerApplication
{
    private $yamlFileService;

    /**
     * @throws ParseException
     */
    public function __construct(string $yamlFilePath)
    {
        $this->yamlFileService = new ReadYamlConfigurationFileService($yamlFilePath);
    }

    /**
     * @return Result[]
     */
    public function check(): iterable
    {
        $resultCollection = new ResultCollection();
        foreach ($this->yamlFileService->getCheckerCollection() as $checker) {
            $resultCollection->append($checker->check());
        }

        return $resultCollection;
    }
}
