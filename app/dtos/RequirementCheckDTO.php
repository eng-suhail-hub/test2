<?php

namespace App\DTOs;

class RequirementCheckDTO
{
    public function __construct(
        public string $code,
        public string $name,
        public bool $isSatisfied,
        public int $priority,
        public bool $isBlocking
    ) {}
}
