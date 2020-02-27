<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Checker;

use MoveElevator\RequirementsChecker\Tests\Fixtures\Data\PhpCoreMethodFixture;

/**
 * @param string $name
 *
 * @return bool
 */
function extension_loaded($name): bool
{
    $fixture = PhpCoreMethodFixture::extension_loaded();
    if (null === $fixture) {
        return \extension_loaded($name);
    }

    return $fixture($name);
}

/**
 * @param string $name
 *
 * @return string
 */
function ini_get($name)
{
    $fixture = PhpCoreMethodFixture::ini_get();
    if (null === $fixture) {
        return \ini_get($name);
    }

    return $fixture($name);
}

/**
 * @param null|string $extension
 *
 * @return string
 */
function phpversion($extension = null)
{
    $fixture = PhpCoreMethodFixture::phpversion();
    if (null === $fixture) {
        return \phpversion();
    }

    return $fixture($extension);
}

/**
 * @param string $class_name
 * @param bool   $autoload
 *
 * @return bool
 */
function class_exists($class_name, $autoload = true): bool
{
    $fixture = PhpCoreMethodFixture::class_exists();
    if (null === $fixture) {
        return \class_exists($class_name, $autoload);
    }

    return $fixture($class_name, $autoload);
}

/**
 * @param string $functionName
 *
 * @return bool
 */
function function_exists($functionName): bool
{
    $fixture = PhpCoreMethodFixture::function_exists();
    if (null === $fixture) {
        return \function_exists($functionName);
    }

    return $fixture($functionName);
}
