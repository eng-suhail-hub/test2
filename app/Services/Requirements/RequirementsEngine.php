<?php

namespace App\Services\Requirements;

use App\DTOs\{
  RequirementCheckDTO,
  RequirementResultDTO
};
use App\Models\RequirementAssignment;
use App\Models\Student;
use App\Models\StudyType;

class RequirementEngineService
{
    public function evaluate(
        Model $context,
        Model $target,
        ?StudyType $studyType = null
    ): RequirementEvaluationResultDTO {

        $assignments = RequirementAssignment::query()
            ->where('is_active', true)
            ->whereMorphedTo('context', $context)
            ->when($studyType, fn ($q) =>
                $q->whereNull('study_type_id')
                  ->orWhere('study_type_id', $studyType->id)
            )
            ->with(['rule', 'value'])
            ->get();

        $checks = [];
        $score = 0;
        $maxScore = 0;
        $blocking = false;

        foreach ($assignments as $assignment) {

            $maxScore += 100;

            $actualValue = data_get(
                $target,
                $assignment->applies_to_field
            );

            $passed = OperatorEngine::check(
                $assignment->rule->operator,
                $actualValue,
                $assignment->value->value
            );

            if ($passed) {
                $score += 100;
            } elseif ($assignment->priority >= 80) {
                $blocking = true;
            }

            $checks[] = new RequirementCheckDTO(
                $assignment->rule->code,
                $assignment->rule->name,
                $passed,
                $assignment->priority,
                $assignment->priority >= 80
            );
        }

        return new RequirementEvaluationResultDTO(
            $checks,
            $maxScore > 0 ? round(($score / $maxScore) * 100, 2) : 100,
            $blocking
        );
    }
}