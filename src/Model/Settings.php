<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Model;

class Settings
{
    public const DEFAULT_CHECKER_NAMESPACE = 'MoveElevator\\RequirementsChecker\\Checker\\';

    /**
     * @var array<string>
     */
    private $checkerNamespaces = [];

    /**
     * @param array<string> $checkerNamespaces
     */
    public function __construct(array $checkerNamespaces)
    {
        $this->checkerNamespaces[] = self::DEFAULT_CHECKER_NAMESPACE;

        $settings = $checkerNamespaces ?? [];
        foreach ($settings as $item) {
            $this->checkerNamespaces[] = $item;
        }
    }

    /**
     * @return array<string>
     */
    public function getCheckerNamespaces(): array
    {
        return $this->checkerNamespaces;
    }
}
