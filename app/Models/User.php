<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\UserRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Panel;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    
       /**
     * المستخدم الطالب → ملف الطالب
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * المستخدم (University Admin) → الجامعات التي يديرها
     */
    public function universities(): BelongsToMany
    {
        return $this->belongsToMany(University::class, 'user_university')
            ->withTimestamps();

    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];
    public function isStudent(): bool
    {
        return $this->role === UserRole::STUDENT;
    }

    public function isUniversityAdmin(): bool
    {
        return $this->role === UserRole::UNIVERSITY_ADMIN;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::SUPER_ADMIN;
    }
    
    
    public function canAccessPanel(Panel $panel): bool
{
    return match ($panel->getId()) {
        'admin' => $this->role === 'SUPER_ADMIN',

        'university' => $this->role === 'UNIVERSITY_ADMIN',

        default => false,
    };
}


    public function university(): ?University
{
    return $this->universities()->first();
}
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => UserRole::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }
}
