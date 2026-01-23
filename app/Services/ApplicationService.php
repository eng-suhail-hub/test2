<?php

namespace App\Services;

class ApplicationService
{
    public function __construct(
        protected RequirementEngineService $engine
    ) {}
    public function getOrCreate(
        Student $student,
        AdmissionCycle $cycle
    ): Application {

        return Application::firstOrCreate(
            [
                'student_id' => $student->id,
                'admission_cycle_id' => $cycle->id,
            ],
            [
                'status' => 'DRAFT',
            ]
        );
    }
    
    public function evaluate(Application $application)
        : RequirementEvaluationResultDTO
    {
        $result = $this->engine->evaluate(
            $application->admissionCycle,
            $application->student,
            $application->admissionCycle->studyType
        );

        $application->update([
            'completion_rate' => $result->completionRate
        ]);

        return $result;
    }
    
    public function canProceed(
        RequirementEvaluationResultDTO $result
    ): bool {
        return !$result->hasBlockingFailure;
    }
    
    public function submit(Application $application): void
    {
        $evaluation = $this->evaluate($application);

        if ($evaluation->hasBlockingFailure) {
            throw new DomainException(
                'متطلبات أساسية غير مستوفاة'
            );
        }

        $cycle = $application->admissionCycle;

        if (
            !$cycle->is_open ||
            ($cycle->capacity !== null &&
             $cycle->accepted_count >= $cycle->capacity)
        ) {
            $application->markPending();
        } else {
            $application->markSubmitted();
        }
    }
    
    public function accept(
        Application $application,
        array $attendanceData
    ): void {
        DB::transaction(function () use ($application, $attendanceData) {

            $application->markAccepted();

            $application->attendanceSchedule()->create(
                $attendanceData
            );

            $application->admissionCycle->increment(
                'accepted_count'
            );
        });
    }
    
    public function reject(
        Application $application,
        string $reason,
        int $rejectedBy,
        bool $allowResubmission = true
    ): void {
        DB::transaction(function () use (
            $application,
            $reason,
            $rejectedBy,
            $allowResubmission
        ) {

            $application->markRejected();

            $application->rejection()->create([
                'reason' => $reason,
                'rejected_by' => $rejectedBy,
                'allow_resubmission' => $allowResubmission,
            ]);
        });
    }
    
    public function resubmit(Application $application): void
    {
        if (
            !$application->rejection ||
            !$application->rejection->allow_resubmission
        ) {
            throw new DomainException(
                'إعادة التقديم غير مسموحة'
            );
        }

        $application->update([
            'status' => 'DRAFT',
            'reviewed_at' => null
        ]);
    }
}
