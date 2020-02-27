<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Tests\Unit\Checker;

use MoveElevator\RequirementsChecker\Checker\AccessFileSystemChecker;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class AccessFileSystemCheckerTest extends TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    private $fileSystem;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        $this->fileSystem = vfsStream::setup();
    }

    /**
     * @inheritdoc
     */
    public function tearDown(): void
    {
        unset($this->fileSystem);
    }

    public function testSuccessFileSystemChecker()
    {
        $checker = new AccessFileSystemChecker($this->fileSystem->url());
        $result = $checker->check();

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('requirement fulfilled.', $result->getMessage());
    }

    public function testSuccessFileSystemCheckerWithoutConstruct()
    {
        $checker = new AccessFileSystemChecker();
        $result = $checker->check();

        $this->assertTrue($result->isSuccess());
        $this->assertEquals('requirement fulfilled.', $result->getMessage());
    }

    public function testNotReadableFileSystemChecker()
    {
        vfsStream::newFile('file.txt', 0000)
            ->withContent('töst')
            ->at($this->fileSystem);

        $checker = new AccessFileSystemChecker($this->fileSystem->url());
        $result = $checker->check();

        $this->assertFalse($result->isSuccess());
        $this->assertEquals('The required access rights are not available.', $result->getMessage());
    }
}
