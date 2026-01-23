<?php

namespace App\DTOs;

class ValidationErrorDTO
{
    public function __construct(
        public string $ruleCode,
        public string $message
    ) {}
}
