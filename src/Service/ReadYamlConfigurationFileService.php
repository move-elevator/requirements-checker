<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Service;

use MoveElevator\RequirementsChecker\Checker\CheckerInterface;
use MoveElevator\RequirementsChecker\Collection\CheckerCollection;
use MoveElevator\RequirementsChecker\Model\Settings;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class ReadYamlConfigurationFileService
{
    private $yamlFileContent;
    private $settings;
    private $checkerCollection;

    /**
     * @throws ParseException
     */
    public function __construct(string $yamlFilePath)
    {
        $yamlFileContent = (string)@file_get_contents($yamlFilePath);
        $this->yamlFileContent = Yaml::parse($yamlFileContent);
        if (null === $this->yamlFileContent) {
            throw new ParseException(
                sprintf('could not parse given yaml file from "%s".', $yamlFilePath)
            );
        }

        $this->settings = new Settings($this->yamlFileContent['settings']['checker-namespaces'] ?? []);
        $this->checkerCollection = $this->buildCheckerCollection();
    }

    /**
     * @return CheckerInterface[]
     */
    private function buildCheckerCollection(): iterable
    {
        $checkerCollection = new CheckerCollection();

        foreach ($this->yamlFileContent['checks'] as $entry => $content) {
            $checker = $this->handleYamlEntry($entry, $content);
            if (true === is_array($checker)) {
                $checkerCollection->appendMultiple($checker);
            }
        }

        return $checkerCollection;
    }

    /**
     * @param null|array<string>|bool|string $content
     *
     * @return array<object>
     */
    private function handleYamlEntry(string $entry, $content): array
    {
        $checkerArray = [];
        $className = sprintf('%sChecker', $entry);

        if (true === is_array($content)) {
            foreach ($content as $item) {
                $class = $this->instantiateClassFromYaml($className, $item);
                if (null !== $class) {
                    $checkerArray[] = $class;
                }
            }

            return $checkerArray;
        }

        if (false === $content) {
            return $checkerArray;
        }

        $class = $this->instantiateClassFromYaml($className, $content);
        if (null !== $class) {
            $checkerArray[] = $class;
        }

        return $checkerArray;
    }

    /**
     * @param null|array<string>|bool|string $parameter
     */
    private function instantiateClassFromYaml(string $className, $parameter = null): ?object
    {
        $completeClassName = '';

        foreach ($this->settings->getCheckerNamespaces() as $checkerNamespace) {
            if (true === class_exists($checkerNamespace . $className)) {
                $completeClassName = $checkerNamespace . $className;
            }
        }

        if (true === empty($completeClassName)) {
            return null;
        }

        return new $completeClassName($parameter);
    }

    /**
     * @return CheckerInterface[]
     */
    public function getCheckerCollection(): iterable
    {
        return $this->checkerCollection;
    }
}
