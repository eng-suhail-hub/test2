<?php

namespace App\Services;

use App\Models\Rating;

class RatingService
{
    public function rate(
        int $userId,
        string $rateableType,
        int $rateableId,
        int $score
    ): void {
        Rating::updateOrCreate(
            [
                'user_id' => $userId,
                'rateable_type' => $rateableType,
                'rateable_id' => $rateableId,
            ],
            ['score' => $score]
        );
    }

    public function calculateAverage(string $type, int $id): float
    {
        return Rating::where('rateable_type', $type)
            ->where('rateable_id', $id)
            ->avg('score') ?? 0;
    }
}