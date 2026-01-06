<?php

namespace App\Observers;
use App\UserRole;
use App\Models\User;
class UserObserver
{
    public function saving(User $user): void
    {
        // إذا غيّر الدور إلى غير مدير جامعة → نفصل الجامعات
        if ($user->role !== UserRole::UNIVERSITY_ADMIN) {
            $user->universities()->detach();
        }
    }
}
