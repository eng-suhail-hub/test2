<?php

namespace App\DTOs;

class ValidationResult
{
    public bool $passed;
    public ?ValidationErrorDTO $error = null;

    private function __construct(bool $passed)
    {
        $this->passed = $passed;
    }

    public static function pass(): self
    {
        return new self(true);
    }

    public static function fail(string $ruleCode, string $message): self
    {
        $instance = new self(false);
        $instance->error = new ValidationErrorDTO($ruleCode, $message);
        return $instance;
    }
}
