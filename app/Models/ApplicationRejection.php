<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationRejection extends Model
{
    protected $fillable = [
        'application_id',
        'reason',
        'rejected_by',
        'allow_resubmission',
        'rejected_at',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
    public function rejectedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}