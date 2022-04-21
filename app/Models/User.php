<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use acidjazz\Humble\Traits\Humble;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Humble;

    protected $guarded = [];
    protected $appends = ['first_name', 'is_trial'];
    protected $casts = ['is_sub' => 'boolean'];

    public const ADMIN = 'admin';
    public const EDITOR = 'editor';
    public static array $roles = [self::ADMIN, self::EDITOR];

    public array $interfaces = [
        'location' => [
            'name' => 'SessionLocation',
        ],
        'session' => [
            'name' => 'Session',
        ],
        'sessions' => [
            'name' => 'Sessions',
        ],
    ];

    public function getIsTrialAttribute(): bool
    {
        return Carbon::now()->diffInDays($this->created_at) < 8;
    }

    public function getFirstNameAttribute(): string
    {
        return isset($this->name) ? explode(' ', $this->name)[0] : '';
    }

    /**
     * Get the providers for the user model.
     *
     * @return HasMany<Provider>
     */
    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class);
    }
}
