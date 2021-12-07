<?php

namespace App\Models;

use acidjazz\Humble\Models\Session;
use acidjazz\Humble\Traits\Humble;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

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
            'name' => 'api.SessionLocation',
        ],
        'session' => [
            'name' => 'api.Session',
        ],
        'sessions' => [
            'name' => 'api.Sessions',
        ],
    ];

    public function getIsTrialAttribute(): bool
    {
        return Carbon::now()->diffInDays($this->created_at) < 8;
    }

    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name)[0];
    }

    public function providers(): HasMany
    {
        return $this->hasMany(Provider::class);
    }
}
