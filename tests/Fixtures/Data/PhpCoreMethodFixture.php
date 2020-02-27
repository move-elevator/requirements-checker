<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Fixtures\Data;

use Closure;
use RuntimeException;

/**
 * @method extension_loaded
 * @method ini_get
 * @method phpversion
 * @method class_exists
 * @method function_exists
 */
class PhpCoreMethodFixture
{
    private static $closures = [];
    private static $counter = [];

    /**
     * @param string$name
     * @param array $arguments
     *
     * @return Closure|null
     */
    public static function __callStatic($name, $arguments): ?Closure
    {
        if (false === array_key_exists($name, self::$closures)) {
            return null;
        }

        if (false === array_key_exists($name, self::$counter)) {
            self::$counter[$name] = 0;
        }
        self::$counter[$name]++;

        return self::$closures[$name];
    }

    public static function setReturnValuesForCoreFunctions(array $result): void
    {
        self::$counter = [];
        self::$closures = [];

        $returnValueSelector = function ($returnValue, $callCounter) {
            if (false === is_array($returnValue)) {
                return $returnValue;
            }

            if (false === isset($returnValue[$callCounter - 1])) {
                throw new RuntimeException('Function was called more often than specified as return values');
            }

            return $returnValue[$callCounter - 1];
        };

        foreach ($result as $type => $returnValue) {
            self::$closures[$type] = function () use ($returnValueSelector, $returnValue, $type) {
                return $returnValueSelector($returnValue, self::$counter[$type]);
            };
        }
    }
}
