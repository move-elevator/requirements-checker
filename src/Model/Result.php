<?php

declare(strict_types=1);

namespace MoveElevator\RequirementsChecker\Model;

class Result
{
    /**
     * @var bool
     */
    private $success = false;

    /**
     * @var string
     */
    private $message = '';

    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(): void
    {
        $this->success = true;
    }
}
