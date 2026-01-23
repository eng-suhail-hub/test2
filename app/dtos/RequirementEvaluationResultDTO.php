<?php

namespace App\DTOs;

class RequirementEvaluationResultDTO
{
    /**
     * @param RequirementCheckDTO[] $checks
     */
    public function __construct(
        public array $checks,
        public float $completionRate,
        public bool $hasBlockingFailure
    ) {}
}
